<?

/*
    osTicket - Open Source Support Ticket System

    Copyright (C) 2003, Joseph Shain <support@osticket.com>
    http://www.osticket.com

    PHP/Perl Developer
    Jared Collums <non_zero@ubcomics.com>
	 PHP/MySQL
	 Peter Rotich <osticket@enhancesoft.com>
		==>06/26/2004 fixed attachments problems


    Released under the GNU General Public License
*/

session_start();

include("class.ticket.php");
include("config.php");

$vuser=login($_SESSION[user][type], $_SESSION[user][id], $_SESSION[user][pass]);
if ($_POST[submit_x]) {
    if (!$_POST[subject]) {
        $err .= "No subject specified.<br>";
    }
    if (!is_email($_POST[email])) {
        $err .= "Invalid email.<br>";
    }
    if (!$_POST[name]) {
        $err .= "No name specified.<br>";
    }
    if (!$_POST[message]) {
        $err .= "No message specified.<br>";
    }
    if (!$err)
	 {
    	$ticket = CreateTicket($_POST[subject], $_POST[name], $_POST[email], $_POST[cat], $_POST[phone], $_POST[pri]);
    	$id = PostMessage($ticket, $message, '', false);
		if ($_FILES[attachment][name])
		{
			if($config[accept_attachments]):
				$ext = preg_replace("/.*\.(.{3,4})$/", "$1", $_FILES[attachment][name]);
				if ($config[attachment_dir] and stristr($config[filetypes], ".$ext;")){
					if($vuser && is_uploaded_file($HTTP_POST_FILES['attachment']['tmp_name']) && ($HTTP_POST_FILES['attachment']['size'] != 0) && ($HTTP_POST_FILES['attachment']['size']<$config[attachment_size])):
				 	mt_srand(time());
					$rand=mt_rand(100000, 999999); //six chars.
	        		if(mysql_query("INSERT INTO ticket_attachments (ticket,ref,filename,type) VALUES ($ticket, $id, '$rand" . "_" . $_FILES[attachment][name] . "', 'q')")):
	       		@copy($_FILES[attachment][tmp_name], "$config[attachment_dir]/$rand" . "_" . $_FILES[attachment][name]);
					endif;
					else:
					  $warn="<b>Attachment removed:</b> upload security error<p>";
					endif;
	        }
	        else {
	        		$warn = "<b>Attachment removed:</b> We don't accept the file type '$ext' .<p>";
	        }
			else:
				$warn="<b>Attachment removed:</b> We don't accept attachments";
			endif;
	   }
      if($vuser){
			$_SESSION[view] = "Open";
			$_SESSION[user][warn]=$warn;
  			header("Location: $config[root_url]/view.php"); 
		}
      $inc = "open_submit";
	}
 	else{
   	$_POST[submit_x] = "";
 	}
}
if (!$_POST[submit_x]) {
  $inc = "open_form";
}
include("$include_dir/header.php");
include("$include_dir/$inc.php");
include("$include_dir/footer.php");
?>
