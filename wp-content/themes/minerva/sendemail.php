<?php

require_once( '../../../wp-load.php' );

/************************
* Variables you can change
*************************/
$mailto   = $_POST['sendto'];
$name     = ucwords($_POST['name']); 
$subject  = $_POST['subject']; // Enter the subject here.
$email    = $_POST['email'];
$message  = $_POST['message'];

	if(strlen($_POST['name']) < 1 ){
		echo  'email_error';
	}
	
  else if(strlen($email) < 1 ) {
		echo 'email_error';
	}

	else if(strlen($message) < 1 ){
		echo 'email_error';

  } else {
    
		if(!isValidEmail($email)) { echo "email_error"; exit; }	

		
		//subject and the html message
		$messages = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head></head>
		<body>
		<table>
			<tr><td valign="top"><b>Name</b></td><td valign="top">:</td><td valign="top">' . stripslashes($name) . '</td></tr>
			<tr><td valign="top"><b>Mail</b></td><td valign="top">:</td><td valign="top">' . $email . '</td></tr>
			<tr><td valign="top"><b>Subject</b></td><td valign="top">:</td><td valign="top">' . stripslashes($subject) . '</td></tr>
			<tr><td valign="top"><b>Message</b></td><td valign="top">:</td><td valign="top">' . stripslashes($message) . '</td></tr>
		</table>
		</body>
		</html>';
		
		$headers = "MIME-Version: 1.0" . "\r\n";  
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";  
		$headers .= "From: " . stripslashes($name) . " <" . $email . ">" . "\r\n";  	
		$headers .= "Sender-IP: " . $_SERVER["SERVER_ADDR"] . "\r\n";
		$headers .= "Priority: normal" . "\r\n";
		$headers .= "X-Mailer: PHP/" . phpversion();
		
		$Message_Body    = utf8_decode($messages);
		
	//send the mail
		wp_mail( $mailto, $subject, $Message_Body, $headers );
			
		$susu = __('Thanks, your message was successfully sent!','minerva');
			
			echo $susu;
			
			exit;
}

	function isValidEmail($email){
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
?>