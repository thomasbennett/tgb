<?
/*
	osTicket, Open Source Support Ticket System
	http://www.osticket.com

	Copyright (C) 2003 osTicket, Joseph Shain

	Released under the GNU General Public License
*/

include_once("class.ticket.php");
include_once("config.php");

if (!function_exists('imap_open')) {
    $err = "IMAP functions are not available.<br>";
}
else {

function get_mime_type(&$structure) {
	$primary_mime_type = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");
	
	if($structure->subtype) {
		return $primary_mime_type[(int) $structure->type] . '/' . $structure->subtype;
	}
	return "TEXT/PLAIN";
}

function get_part($stream, $msg_number, $mime_type, $structure = false, $part_number = false) {
	if(!$structure) {
		$structure = imap_fetchstructure($stream, $msg_number);
	}
	if($structure) {
		if($mime_type == get_mime_type($structure)) {
			if(!$part_number) {
				$part_number = "1";
			}
			$text = imap_fetchbody($stream, $msg_number, $part_number);
			if($structure->encoding == 3) {
				return imap_base64($text);
			} else if($structure->encoding == 4) {
				return imap_qprint($text);
			} else {
				return $text;
			}
		}
		if($structure->type == 1) /* multipart */ {
			while(list($index, $sub_structure) = each($structure->parts)) {
				if($part_number) {
					$prefix = $part_number . '.';
				}
				$data = get_part($stream, $msg_number, $mime_type, $sub_structure, $prefix . ($index + 1));
				if($data) {
					return $data;
				}
			}
		}
	}
	return false;
}

$cat_res = mysql_query("SELECT * FROM ticket_categories");
while ($cat_row = mysql_fetch_array($cat_res)) {
if ($cat_row[pophost]) {
    $mbox = @imap_open("{" . $cat_row[pophost] . "/pop3:110}INBOX", $cat_row[popuser], $cat_row[poppass]);
    if (!$mbox) {
    	$mbox = @imap_open("{" . $cat_row[pophost] . "/pop3/notls}INBOX", $cat_row[popuser], $cat_row[poppass]);
    }
    	
    if (!$mbox) {
	    $err .= "Unable to open mailbox for category \"$cat_row[name]\".<br>";
	}
	else {
	$curmsg = 1;

	while ($curmsg <= @imap_num_msg($mbox)) {
		$body = get_part($mbox, $curmsg, "TEXT/PLAIN");
		if (!$body) {
			$body = get_part($mbox, $curmsg, "TEXT/HTML");
		}
		if (!$body) {
			continue;
		}
		$head = imap_headerinfo($mbox, $curmsg, 800, 800);
		$email = $head->reply_toaddress;
		
		if (strpos($email, "<")) {
			$email = eregi_replace(".*<(.*)>.*", "\\1", $email);
        }
			
        $name = $head->fromaddress;
///ADDED by KVAS: character fix
$decoded1 = imap_mime_header_decode($name);
$name = $decoded1[0]->text;
////END
		if (strpos($name, "<")) {
			$name = eregi_replace("(.*) <.*>.*", "\\1", $name);
        }
        if (!$name) {
            $name = $email;
        }
            			
		$subject = $head->fetchsubject;
///ADDED by KVAS: character fix
    $decoded = imap_mime_header_decode($subject);
    $subject = $decoded[0]->text;
    $head->fetchsubject = $subject;
/////END	
        $subject = !$subject ? "[No Subject]": $subject;

        $eml_headers = imap_fetchheader($mbox, $curmsg, FT_PREFETCHTEXT);
        $x_pri = split("\n", $eml_headers);
        foreach ($x_pri as $item) {
            $arr = split(": ", $item);
            if (eregi("x-priority", $arr[0])) {
                if (strstr($arr[1], "1") or strstr($arr[1], "2")) {
                    $pri = 3;
                }
                elseif (strstr($arr[1], "4") or strstr($arr[1], "5")) {
                    $pri = 1;
                }
            }
            elseif (eregi("X-Originating-IP", $arr[0])) {
                $ip = $arr[1];
                $ip = eregi_replace("\[(.*)\]", "\\1", $ip);
            }
        }
        if (!$pri) {
            $pri = 2;
        }
            
        $body = ltrim(rtrim($body));
        
        if ($config[remove_original] and $config[remove_tag] and strpos($body, $config[remove_tag])) {
            $lines = split($config[remove_tag], $body);
            $body = $lines[0];
        }

        $c = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS cnt FROM tickets WHERE email='$email' AND status='open'"));
        if ($c[cnt] > $config[ticket_max]) {
            $config[limit_msg] = str_replace("%local_email", $cat_row[email], $config[limit_msg]);
            $config[limit_msg] = str_replace("%ticket_max", $config[ticket_max], $config[limit_msg]);
            
            if ($config[limit_response]) {
                mail($email, $config[limit_subj], $config[limit_msg], "From: $config[limit_email]\n");
            }
            die();
        }
        
    	if (!ereg ("[[][#][0-9]{6}[]]", $head->fetchsubject)) {
            $ticket_id = CreateTicket($subject, $name, $email, $cat_row[ID], "", $pri, $ip);
    	}
        else {
    		$ticket_id = substr(strstr($head->fetchsubject, "[#"), 2, 6);
    	}
    	
    	$iid = PostMessage($ticket_id, $body, $eml_headers, false);
    	
    	if (is_dir($config[attachment_dir]) and $config[accept_attachments]) {
    	$struct = imap_fetchstructure($mbox, $curmsg);
        for ($i = 0; $q < count($struct->parts); ++$q) {
            $filename="";
            $section = $struct->parts[$q];

            $param = $section->dparameters;
            for ($x = 0; $x <= count($param); ++$x) {
                if (eregi("filename", $param[$x]->attribute)) {
                    $filename = $param[$x]->value;
///ADDED by KVAS: character fix
	$decoded_filename = imap_mime_header_decode($param[$x]->value);
	$filename = $decoded_filename[0]->text;
///END
                }
            }
            $part = imap_fetchbody($mbox, $curmsg, $q+1);
				$ext = preg_replace("/.*\.(.{3,4})$/", "$1",$filename);
            if ($filename && stristr($config[filetypes],".$ext;")) {
                if ($section->encoding == "3") {
                    $part = base64_decode($part);
                }
                if (!$config[attachment_size] or ($section->bytes <= $config[attachment_size])) {
							
						  mt_srand(time());
               	  $rand=mt_rand(100000, 999999); //six chars.
                    $file = fopen("$config[attachment_dir]/$rand"."_$filename", "w+");
                    fputs($file, $part);
                    fclose($file);
                    mysql_query("INSERT INTO ticket_attachments (ticket, ref, filename, type) VALUES ($ticket_id, $iid, '$rand" . "_$filename', 'q')");
                }
            }
        }
        }
        
    	imap_delete($mbox, $curmsg);
		$curmsg++;
	}
	@imap_expunge($mbox);
	@imap_close($mbox);
	}
	}
}
}
?>
