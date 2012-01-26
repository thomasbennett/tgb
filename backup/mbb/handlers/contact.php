<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 

<?php

if(!$_POST) exit;

$values = array ('name','email','phone','message');
$required = array('name','email','phone','message');

//message will be sent to:
$your_email = "thomas.g.bennett@gmail.com";
$email_subject = "Someone has contacted you via MBB.com";
$email_content = "Message:\n";
$from .= 'From:' .$_POST[$values[1]];

for( $i = 0 ; $i < count( $values ) ; ++$i ) {
	for( $c = 0 ; $c < count( $required ) ; ++$c ) {
		if( $values[$i]==$required[$c]) {
			echo $required[$x];
            if( empty($_POST[$values[$i]]) || $_POST[$values[3]] == 'Phone *' ||$_POST[$values[4]] == 'Enter your message...' || $_POST[$values[1]] == 'Email Address *' ) { echo 'All fields are required.'; exit; }
		}
	}
	$email_content .= $values[$i].': '.$_POST[$values[$i]]."\n";
}

if(mail($your_email,$email_subject,$email_content,$from)) {
	echo '<div class="response">Thanks! Someone will get back to you as soon as possible.</div>'; 
} else {
	echo '<div class="response">There was an error! Please make sure all fields are filled out correctly.</div>';
}

?>
