<?
/*
	osTicket, Open Source Support Ticket System
	http://www.osticket.com

	Copyright (C) 2003 osTicket, Joseph Shain

	Released under the GNU General Public License
*/

class ticket {
	var $id;
	var $subject;
	var $name;
	var $email;
	var $phone;
	var $status;
	var $rep;
	var $cat;
	var $priority;
	var $unanswered;
	var $age;
	var $short_time;
	var $ip;

	function Ticket ($row) {
	    global $config;

		$this->id = $row[ID];
		$this->subject = $row[subject];
		$this->name = $row[name];
		$this->email = $row[email];
		$this->phone = $row[phone];
		$this->status = $row[status];
		$this->rep = $row[rep];
		$this->cat = $row[cat];
		$this->priority = $row[priority];
		$this->ip = $row[ip];

		$t = mysql_fetch_array(mysql_query("SELECT timestamp FROM tickets WHERE ID='$this->id'"));
		$this->short_time = date("m/d/Y", time_convert($t[timestamp]));

        $qs = mysql_query("SELECT * FROM ticket_messages WHERE ticket=$this->id ORDER BY timestamp");
        $in = mysql_num_rows($qs);
        while ($q = mysql_fetch_array($qs)) {
        	$answer = mysql_fetch_array(mysql_query("SELECT message FROM ticket_answers WHERE reference=$q[ID]"));
        	if ($answer[message]) {
        	   --$in;
        	}
        	else {
        	   ++$un;
        	}

        	if ($un and $answer[message]) {
                $in -= $un;
                $un = 0;
        	}
        }
        $this->unanswered = $in;

        if (!$this->unanswered and $this->status !== "closed") {
            $this->status = "answered";
        }
	}
}

function email_alert($ticket, $msg) {
    global $config;
    
    $t = mysql_fetch_array(mysql_query("SELECT * FROM tickets WHERE ID=$ticket"));
    $m = mysql_fetch_array(mysql_query("SELECT * FROM ticket_messages WHERE ID=$msg"));
    
    $config[alert_subj] = str_replace("%ticket", $t[ID], $config[alert_subj]);
    $config[alert_msg] = str_replace("%ticket", $t[ID], $config[alert_msg]);
    $config[alert_msg] = str_replace("%email", $t[email], $config[alert_msg]);
    $config[alert_msg] = str_replace("%message", $m[message], $config[alert_msg]);
    $config[alert_msg] = str_replace("%url", $config[root_url], $config[alert_msg]);
    
    mail($config[alert_user], $config[alert_subj], $config[alert_msg], "From: $config[alert_email]\n");
}

function is_email($email) {
    return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}

function striptags($string) {
    $search = array("'<script[^>]*?>.*?</script>'si", "'<[/!]*?[^<>]*?>'si");
    $replace = array("","");
    $string = preg_replace($search, $replace, $string);
    return $string;
}

function login($type, $id, $pass) {
    if ($type == "admin") {
        $row = mysql_fetch_array(mysql_query("SELECT password FROM ticket_reps WHERE username='$id' AND password='$pass'"));
    }
    else {
	   $row = mysql_fetch_array(mysql_query("SELECT ID FROM tickets WHERE email='$id' AND ID='$pass'"));
	}

	if ($row[password]) {
	    $permis = mysql_fetch_array(mysql_query("SELECT user_group FROM ticket_reps WHERE username='$id'"));
	    $permis = mysql_fetch_array(mysql_query("SELECT * FROM ticket_groups WHERE ID='$permis[user_group]'"));
    }
	elseif ($row[ID]) {
	    $permis = 1;
	}
	else {
	    $permis = 0;
	}
	return $permis;
}

function ValidID($id) {
	$res = mysql_query("SELECT ID FROM tickets WHERE ID=$id");
	return mysql_num_rows($res);
}

//Ticket Functions
function CreateTicket($subject, $name, $email, $cat, $phone, $pri=2, $ip='') {
    global $config;

	do {
        mt_srand ((double) microtime() * 1000000);
		$id =  mt_rand(100000, 999999);
	} while(ValidID($id));
	
    $t = mysql_fetch_array(mysql_query("SELECT UNIX_TIMESTAMP(timestamp) AS timestamp FROM tickets WHERE email='$email' ORDER BY timestamp DESC"));
    $interval = time() - $t[timestamp];
	$gmtime = (time() - date("Z")) + 3600;
	
	mysql_query("INSERT INTO tickets (subject, name, email, cat, phone, status, ID, priority, ip, timestamp) VALUES ('" . addslashes(striptags($subject)) . "', '" . addslashes(striptags($name)) . "', '".striptags($email)."', '$cat', '". addslashes(striptags($phone)) . "', 'open', $id, $pri, '$ip', FROM_UNIXTIME('$gmtime') + 0)");
    $id = mysql_error() ? mysql_error(): $id;

    $config[ticket_subj] = stripslashes(str_replace("%ticket", $id, $config[ticket_subj]));
    $config[ticket_msg] = stripslashes(str_replace("%ticket", $id, $config[ticket_msg]));
    $config[ticket_msg] = str_replace("%email", $email, $config[ticket_msg]);
    $config[ticket_msg] = str_replace("%url", $config[root_url], $config[ticket_msg]);

    if ($config[remove_original]) {
        $remove_tag = "$config[remove_tag]\n\n";
    }

    $cat = mysql_fetch_array(mysql_query("SELECT * FROM ticket_categories WHERE ID=$cat"));

    if (($interval >= $min_interval) and $config[ticket_response]) {
        mail($email, $config[ticket_subj], $remove_tag . stripslashes($config[ticket_msg]) . "\n\n" . $cat[signature], "From: $cat[email]\n");
    }

	return $id;
}

function CloseTicket($ticket) {
	mysql_query("UPDATE tickets SET status = 'closed' WHERE ID=$ticket");
}

function ReopenTicket($ticket) {
	mysql_query("UPDATE tickets SET status='open' WHERE ID=$ticket");
}

function DeleteTicket($id) {
    global $config;

	mysql_query("DELETE FROM ticket_answers WHERE ticket=$id");
	mysql_query("DELETE FROM ticket_messages WHERE ticket=$id");
	mysql_query("DELETE FROM tickets WHERE id=$id");

	$files = mysql_query("SELECT filename FROM ticket_attachments WHERE ticket=$id");
	while ($file = mysql_fetch_array($files)) {
		@unlink("$config[attachment_dir]/$file[filename]");
	}
	mysql_query("DELETE FROM ticket_attachments WHERE ticket=$id");
	
	$files = mysql_query("SELECT * FROM ticket_privmsg WHERE ticket=$id");
	while ($file = mysql_fetch_array($files)) {
	    if ($file[attachment]) {
		  @unlink("$config[attachment_dir]/$file[attachment]");
		}
	}
	mysql_query("DELETE FROM ticket_privmsg WHERE ticket=$id");
	mysql_query("DELETE FROM ticket_attachments WHERE ticket=$id");
}

function PostMessage($ticket, $message, $headers='', $notify=true) {
    global $config;
	$headers = $config[save_headers] ? $headers: "";
	$gmtime = (time() - date("Z")) + 3600;
	
	ReopenTicket($ticket);
	mysql_query("INSERT INTO ticket_messages (ticket, message, headers, timestamp) VALUES($ticket, '" . addslashes(striptags($message)) . "', '" . addslashes($headers) . "', FROM_UNIXTIME('$gmtime') + 0)");

    if ($config[alert_new]) {
	   email_alert($ticket, mysql_insert_id());
	}
	
	$t = mysql_fetch_array(mysql_query("SELECT email, cat FROM tickets WHERE ID=$ticket"));
	$c = mysql_fetch_array(mysql_query("SELECT email FROM ticket_categories WHERE ID=$t[cat]"));

	$config[message_subj] = str_replace("%ticket", $ticket, $config[message_subj]);
	$config[message_msg] = str_replace("%ticket", $ticket, $config[message_msg]);
	$config[message_msg] = str_replace("%email", $t[email], $config[message_msg]);
	$config[message_msg] = str_replace("%url", $config[root_url], $config[message_msg]);

	if ($config[message_response] and $notify) {
        mail($t[email], $config[message_subj], $config[message_msg], "From: $c[email]\n");
    }
	return mysql_insert_id();
}

function PostAnswer($message, $rep, $reference, $attachment=false) {
	global $config;

    $msg_res = mysql_query("SELECT ticket FROM ticket_messages WHERE ID=$reference");
	$msg_row = mysql_fetch_array($msg_res);
	$ticket = $msg_row[ticket];

	$res = mysql_query("SELECT * FROM tickets WHERE ID=$ticket");
	if (mysql_error() or !mysql_num_rows($res)) {
		return false;
	}
	
	$gmtime = (time() - date("Z")) + 3600;
	mysql_query("INSERT INTO ticket_answers (ticket, message, rep, reference, timestamp) VALUES($ticket, '" . addslashes($message) . "', $rep, $reference, FROM_UNIXTIME('$gmtime') + 0)");
	if (mysql_error()) {
		return false;
	}

	$ticket_row = mysql_fetch_array($res);
	$cat_res = mysql_query("SELECT * FROM ticket_categories WHERE ID=$ticket_row[cat]");
	$cat_row = mysql_fetch_array($cat_res);
	$rep_res = mysql_query("SELECT * FROM ticket_reps WHERE ID=$rep");
	$rep_row = mysql_fetch_array($rep_res);

	if ($config[remove_original]) {
	    $config[remove_tag] = "$config[remove_tag]\n\n";
	}

	$message = str_replace("\r", "\n", $message);
	$message = str_replace("\n\n", "\n", $message);
	
	if ($config[accept_attachments] and $config[attachment_dir] and $attachment[name])
	{
    	if ($file = fopen($attachment[tmp_name],'rb'))
	{
		$data = fread($file,filesize($attachment[tmp_name]));
		$data = chunk_split(base64_encode($data));
		fclose($file);
	}
        
	$semi_rand = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

        $headers = "MIME-Version: 1.0\n" .
                   "Content-Type: multipart/mixed;\n" .
                   " boundary=\"{$mime_boundary}\"";

        $message = "This is a multi-part message in MIME format.\n\n" .
                   "--{$mime_boundary}\n" .
                   "Content-Type: text/plain; charset=\"UTF-8\"\n" .
                   "Content-Transfer-Encoding: 7bit\n\n" .
                   $config[remove_tag] . $message . "\n\n" . $rep_row[signature] . "\n\n";

        $message .= "--{$mime_boundary}\n" .
                    "Content-Type: " . $attachment[type] . ";\n" .
                    " name=\"" . $attachment[name] . "\"\n" .
                    "Content-Disposition: attachment;\n" .
                    " filename=\"" . $attachment[name] . "\"\n" .
                    "Content-Transfer-Encoding: base64\n\n" .
                    $data . "\n\n" .
                    "--{$mime_boundary}--\n";
    }
    else {
        if ($config[remove_original] and $config[remove_tag]) {
            $remove_tag = "$config[remove_tag]\n\n";
        }
        $message = $remove_tag . $message . "\n\n" . $rep_row[signature];
    }
                
	mail($ticket_row[email], "[#$ticket_row[ID]] $ticket_row[subject]", $message, "From: $cat_row[email]\n$headers");

	return mysql_insert_id();
}

function time_convert($mysql_timestamp) {
    global $config;
    $t = mysql_fetch_array(mysql_query("SELECT UNIX_TIMESTAMP($mysql_timestamp) AS timestamp"));
    $t[timestamp] += ($config[timezone] * 3600);
    return $t[timestamp];
}
?>
