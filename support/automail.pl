#!/usr/local/bin/perl

#######################################################
#
#	osTicket, Open Source Support Ticket System
#	http://www.osticket.com
#
#	Copyright (C) 2003 osTicket, Joseph Shain
#
#	Released under the GNU General Public License
#
#######################################################
#
#	Setup automail.pl Email Gateway for aliases
#
#	Scroll down to configure your path to
#	Sendmail and MySQL settings.
#
#######################################################

sub is_valid {
    $ticket = $_[0];

    $sth = $dbh->prepare("SELECT * FROM tickets WHERE ID=$ticket");
    $sth->execute();

    $hash = $sth->fetchrow_hashref;
    $sth->finish();

    return $hash->{ID};
}

sub sendmail {
    ($to, $from, $subj, $body) = @_;
    open(MAIL, "|$config{'mailprog'} -t");
    print MAIL "To: $to\n";
    print MAIL "From: $from\n";
    print MAIL "Subject: $subj\n\n";
    print MAIL "$body\n";
    close(MAIL);
}

sub keyword {
    $_[0] =~ s/%([_|a-zA-Z][a-zA-Z|\d|_]*)/${$1}/gi;
}

#configuration
%config = (mailprog => '/usr/lib/sendmail',
           database_host => 'localhost',
           database_name => 'Your_Database__Here',
           database_user => 'Your_Username_Here',
           database_pass => 'Your_Password_Here');

use DBI;
$dbh = DBI->connect("DBI:mysql:$config{'database_name'}:$config{'database_host'}", $config{'database_user'}, $config{'database_pass'});

#database configuration
$sth = $dbh->prepare("SELECT * FROM ticket_config");
$sth->execute();
$myconfig = $sth->fetchrow_hashref;

$url = $myconfig->{root_url};

#email message
while (<STDIN>) {
    push @message, $_;
    $eml .= $_;
}

#parse headers
foreach (@message) {
    push @headers, $_;
    last if (/^\s$/ || /^$/);
    if (/oundary=/) {
        $attachment_info = $_;
        $attachment = 1;
    }
    else {
        $attachment = 0;
    }
    $_ =~ s/:\s/:/g;
    if (/:/) {
        @vars = split(':', $_, 2);
        if ($vars[1]) {
            chop($header{$vars[0]} = $vars[1]);
        }
    }
}

$eml_subj = $header{'Subject'};
$user_email = $header{'From'};
$user_email =~ s/"//g;
$local_email = $header{'To'};

$eml_subj =~ s/\s*Re:\s*//gi if ($eml_subj);
$eml_subj = "[No Subject]" if (!$eml_subj);
$user_email =~ s/"/\"/g;

@ticket = split('\[#', $eml_subj, 2);
chop($ticket[1]);
$ticket = int($ticket[1]);

#is address banned?
$sth = $dbh->prepare("SELECT * FROM ticket_banlist");
$sth->execute();
while ($ban = $sth->fetchrow_hashref) {
    $banlist = $ban->{value};
    if ($user_email =~ /$banlist/i) {
        die();
    }
}

#format email priority to osticket priority.
$pri = $header{'X-Priority'};
if ($pri == 1 or $pri == 2) {
    $pri = 3;
}
elsif ($pri == 3) {
    $pri = 2;
}
elsif ($pri == 4 or $pri == 5) {
    $pri = 1;
}
else {
    $pri = 2;
}

#attachment info
($i, $boundary) = split("\"", $attachment_info);

#get filenames and base64 codes for file attachments
if ($boundary) {
    @eml = split($boundary, $eml);
    for ($i = 0; $i <= $#eml; ++$i) {
        if ($eml[$i] =~ /filename/) {
            @lines = split("\n", $eml[$i]);

            $encoding = $eml[$i];
            $encoding =~ s/Content-Transfer-Encoding:\s(.*)\n/$1/i;
            push @encoding, $encoding;

            $feed = 0;
            $code = "";
            foreach (@lines) {
                if ($feed) {
                    $code .= "$_\n";
                }

                if ($_ =~ /filename/) {
                    $_ =~ s/.*filename="(.*)"/$1/;
                    push @files, $_;
                    $feed = 1;
                }
            }
            push @codes, $code;
        }
        else {
            push @bodies, $eml[$i];
        }
    }
}
else {
    for ($i = $#headers + 1; $i <= $#message; $i++) {
        $body .= $message[$i];
    }
}

#find body (if multi-part email)
foreach(@bodies) {
    @lines = split("\n", $_);
    foreach (@lines) {
        if (/oundary=/) {
            $b = $_;
        }
    }
    ($i, $boundary) = split("\"", $b);
    if ($boundary) {
        @ibodies = split($boundary, $_);
    }
    else {
        $ibodies[0] = $_;
    }

    foreach(@ibodies) {
        if ($#bodies == 0) {
            $type = ".*";
        }
        else {
            $type = "plain";
        }
        if (/content-type:\stext\/$type/i) {
            $body = $_;
            @lines = split("\n", $body);
            $body = "";
            $f = -1;
            foreach(@lines) {
                if ($f) {
                    $body .= "$_\n";
                }
                if (!$_) {
                    ++$f;
                }
            }

        }
    }
}

#delete original message
if ($myconfig->{remove_original} && $myconfig->{remove_tag} && index($body, $myconfig->{remove_tag})) {
    $remove_tag = $myconfig->{remove_tag};
    @lines = split(/$remove_tag/i, $body);
    $body = $lines[0];

    @lines = split(/-*[\n|\s|\0]Original Message[\n|\s|\0]-*/, $body);
    $body = $lines[0];
}

#right and left trim
$body =~ s/<script[^>]*?>.*?<\/script>//g;
$body =~ s/<[\/!]*?[^<>]*?>//g;
$body =~ s/'/\\'/g;
$body =~ s/--$//g;
$body =~ s/[\n|<br>]*$//gi;
$body =~ s/^(.*)>/<$1>/i;
$body =~ s/^[\n|<br>]*//gi;

#get category
$sth = $dbh->prepare("SELECT * FROM ticket_categories");
$sth->execute();
while ($row_hash = $sth->fetchrow_hashref) {
    if ($local_email =~ $row_hash->{email}) {
        $local_email = $row_hash->{email};
        $cat = $row_hash->{ID};
        $signature = $row_hash->{signature};
    }
}

#add signature/remove tag
if ($signature) {
    $signature = "\n\n$signature";
}
if ($myconfig->{remove_original}) {
    $remove_tag = $myconfig->{remove_tag} . "\n\n";
}

#save email headers
if ($myconfig->{save_headers}) {
    $eml_headers = $eml;
}
$eml_headers = $dbh->quote($eml_headers);

#get greenwich mean time
use POSIX;
@gm = gmtime();
$gmtime = POSIX::mktime($gm[0], $gm[1], $gm[2], $gm[3], $gm[4], $gm[5]);

@oldgm = gmtime(time()-75);
$gmoldtime = $oldgm[5] . $oldgm[4] . $oldgm[3] . $oldgm[2] . $oldgm[1] . $oldgm[0];

@what = split('<', $user_email, 2);
$email = $what[1];
$email =~ s/\>//g;
$email =~ s/\'//g;

$name = $what[0];
$name =~ s/\s$//;
if (!$name) {
     $name = $email;
}
elsif (!$email) {
     $email = $name;
}

# flood protection, find all posts made by this email in the last 10 minutes
@smoog_what = split('<', $user_email, 2);
$smoog_email = $smoog_what[1];
$smoog_email =~ s/\>//g;
$smoog_email =~ s/\'//g;

$smoog_mysqltime = $gmtime - 75;
$smoog_earlieststamp = -1;
$smoog_messagesfound = 0;
$smoog_query = "SELECT * FROM tickets WHERE email='$smoog_email' ORDER BY timestamp ASC";
$smoog_tickets = $dbh->prepare($smoog_query);
$smoog_tickets->execute();

while ($smoog_t = $smoog_tickets->fetchrow_hashref) {
	  $smoog_query = "SELECT UNIX_TIMESTAMP(timestamp) as unitimestamp FROM ticket_messages WHERE ticket='" . $smoog_t->{ID} . "' AND timestamp > '$gmoldtime'";
      $smoog_messages = $dbh->prepare($smoog_query);
      $smoog_messages->execute();
      while ($m = $smoog_messages->fetchrow_hashref) {
      		if ($smoog_earlieststamp == -1 || $smoog_earlieststamp > $m->{unitimestamp}) {
      			$smoog_earlieststamp = $m->{unitimestamp};
      		} 
			$smoog_messagesfound++;
     }
}
# done figuring out recent message count, now lets check the rate.
$smoog_msgrate = (60 * $smoog_messagesfound) / ($gmtime - $smoog_earlieststamp); 
if (!length($smoog_email) || $smoog_msgrate > 5) { # you can change the number here, its the max num of messages per min sent by 1 email.
	die();
}
# print 'Message rate: ' . $smoog_msgrate . ', messages found: ' . $smoog_messagesfound . ', query: '. $smoog_query . "\n, email: $smoog_email $gmtime $user_email";
# die();
# end flood protection

#create new ticket
if (!$ticket) {
    do {
        $min = 100000;
        $max = 999999;
        $ticket = int(rand($max - $min + 1)) + $min;
    } while (is_valid($ticket));

    chdir($myconfig->{attachment_dir});

    @what = split('<', $user_email, 2);
    $email = $what[1];
    $email =~ s/\>//g;
    $email =~ s/\'//g;

    $name = $what[0];
    $name =~ s/\s$//;
    if (!$name) {
        $name = $email;
    }
    elsif (!$email) {
        $email = $name;
    }

    $sth = $dbh->prepare("SELECT COUNT(*) AS tq FROM tickets WHERE email='$email' AND status='open'");
    $sth->execute();
    $row_hash = $sth->fetchrow_hashref;
    $tq = $row_hash->{tq};

    if ($tq < $myconfig->{ticket_max}) {
        $eml_subj = $dbh->quote($eml_subj);
        $name = $dbh->quote($name);

        $sth = $dbh->prepare("SELECT UNIX_TIMESTAMP(timestamp) AS timestamp FROM tickets WHERE email='$email' ORDER BY timestamp DESC");
        $sth->execute();
        $row_hash = $sth->fetchrow_hashref;
        $interval = time() - $row_hash->{timestamp};
        $ip =~ s/\[(.*)\]/$1/;

        $sth = $dbh->prepare("INSERT INTO tickets (subject, name, email, cat, status, ID, priority, ip, timestamp) VALUES ($eml_subj, $name, '$email', '$cat', 'open', $ticket, $pri, '" . $header{'X-Originating-IP'} . "', FROM_UNIXTIME('$gmtime') + 0)");
        $sth->execute();

        $sth = $dbh->prepare("INSERT INTO ticket_messages (ticket, message, headers, timestamp) VALUES ($ticket, '$body', $eml_headers, FROM_UNIXTIME('$gmtime') + 0)");
        $sth->execute();

        if ($interval > $myconfig->{min_interval}) {
            keyword($myconfig->{ticket_subj});
            keyword($myconfig->{ticket_msg});
            if ($myconfig->{ticket_response}) {
                sendmail($user_email, $local_email, $myconfig->{ticket_subj}, $remove_tag . $myconfig->{ticket_msg} . $signature);
            }
        }
    }
    #if over ticket limit
    else {
        $ticket_max = $myconfig->{ticket_max};

        keyword($myconfig->{limit_subj});
        keyword($myconfig->{limit_msg});
        if ($myconfig->{limit_response}) {
            sendmail($user_email, $myconfig->{limit_email}, $myconfig->{limit_subj}, $remove_tag . $myconfig->{limit_msg} . $signature);
        }
    }
}
#post message
else {
    $sth = $dbh->prepare("UPDATE tickets SET status = 'open' WHERE ID=$ticket");
    $sth->execute();

    $sth = $dbh->prepare("INSERT INTO ticket_messages (ticket, message, headers, timestamp) VALUES ($ticket, '$body', $eml_headers, FROM_UNIXTIME('$gmtime') + 0)");
    $sth->execute();

    keyword($myconfig->{message_subj});
    keyword($myconfig->{message_msg});

    if ($myconfig->{message_response}) {
        sendmail($user_email, $local_email, $myconfig->{message_subj}, $remove_tag . $myconfig->{message_msg} . $signature);
    }
}

#alert owner
if ($myconfig->{alert_new}) {
    keyword($myconfig->{alert_subj});

    $email = $user_email;
    $content = $body;

    keyword($myconfig->{alert_msg});
    sendmail($myconfig->{alert_user}, $myconfig->{alert_email}, $myconfig->{alert_subj}, $myconfig->{alert_msg});
}

#upload attachments
if ($myconfig->{accept_attachments} && $myconfig->{attachment_dir}) {
    use MIME::Base64;
    chdir($myconfig->{attachment_dir});

    $sth = $dbh->prepare("SELECT LAST_INSERT_ID() AS iid");
    $sth->execute();
    $row_hash = $sth->fetchrow_hashref;
    $iid = $row_hash->{iid};

    for ($i = 0; $i <= $#files; ++$i) {
        $id= int(rand(999999-100000+1))+100000;
        $filename=$id."_$files[$i]";
        open(ATTACH, ">$filename");
        binmode(ATTACH);
        $codes[$i] =~ s/Content-Transfer-Encoding:\s(.*)\n//i;

        if ($encoding[$i] =~ /base64/i) {
            $codes[$i] = decode_base64($codes[$i])
        }

        if (length($codes[$i]) < $myconfig->{attachment_size}) {
            print ATTACH $codes[$i];
        }
        close(ATTACH);

        $sth = $dbh->prepare("INSERT INTO ticket_attachments (ticket, ref, filename, type) VALUES ($ticket, $iid, '$filename', 'q')");
        $sth->execute();
    }
}

$sth->finish();
$dbh->disconnect();
