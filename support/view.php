<?
session_start();
@header("Cache-control: private");

include("class.ticket.php");
include("config.php");

session_register("user");
session_register("view");

if ($_POST[view_answered_x]) {
    $_SESSION[view] = "Answered";
}
elseif ($_POST[view_closed_x]) {
    $_SESSION[view] = "Closed";
}
elseif ($_POST[view_open_x]) {
    $_SESSION[view] = "Open";
}

if (!$_REQUEST[a]) {
    if ($_POST[close_x]) {
        $_REQUEST[a] = "close";
    }
    elseif ($_POST[reopen_x]) {
        $_REQUEST[a] = "reopen";
    }
}

if ((!$_POST[login_email] or !$_POST[login_ticket]) and ($_SESSION[user][type] !== "client")) {
    $inc = "user_login";
}
else {
    $a = strtolower($_REQUEST[a]);
    
	$_SESSION[user][id] = $_POST[login_email] ? $_POST[login_email]: $_SESSION[user][id];
    $_SESSION[user][pass] = $_POST[login_ticket] ? $_POST[login_ticket]: $_SESSION[user][pass];
    $_SESSION[user][type] = "client";

    $oslogin = login($_SESSION[user][type], $_SESSION[user][id], $_SESSION[user][pass]);
	if ($oslogin) {
		switch ($a) {
			case "view":
				$inc = "viewticket";
			break;
			case "close":
                if (count($_POST[t])) {
    				foreach ($_POST[t] as $id => $val) {
    					CloseTicket($id);
    				}
				}
            break;
            case "reopen":
				if (count($_POST[t])) {
                    foreach ($_POST[t] as $id => $val) {
						ReopenTicket($id);
					}
				}					
			break;
			case "post":
		    if ($_POST[message]) {
			    $iid = PostMessage($_POST[id], $_POST[message]);
			    
			    $ext = preg_replace("/.*\.(.{3,4})$/", "$1", $_FILES[attachment][name]);
			    if ($_FILES[attachment][name]) {
			    	if ($config[attachment_dir] and stristr($config[filetypes], ".$ext;") && $_FILES[attachment][size] != 0  && $_FILES[attachment][size]<$config[attachment_size]) {
						mt_srand(time());
						$rand = mt_rand(100000, 999999);

				        $filename = $rand . "_" . $_FILES[attachment][name];
				        copy($_FILES[attachment][tmp_name], "$config[attachment_dir]/$filename");
				        mysql_query("INSERT INTO ticket_attachments (ticket, ref, filename, type) VALUES ('$_POST[id]', '$iid', '$filename', 'q')");
	                }
	                else {
	                	$err = "We don't accept the file type '$ext'.<p>";
	                }
				}
				$inc = "viewticket";
			}
			else {
			    $err = "Required fields missing.";
			}
			break;
			case "logout":
                session_destroy();
                $inc = "user_login";
			break;
		}
	}
    else {
        $err = 1;
        $inc = "user_login";
	}
}
$inc = !$inc ? "main": $inc;

include("$include_dir/header.php");
include("$include_dir/$inc.php");
include("$include_dir/footer.php");
?>
