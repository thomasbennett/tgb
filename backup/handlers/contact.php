<!DOCTYPE html> 
<html>
<?php

if(!$_POST) exit;

$values = array ('name','email','message');
$required = array('name','email','message');

//message will be sent to:
$your_email = "thomas.g.bennett@gmail.com";
$email_subject = "A message from your website";
$email_content = "Message:\n";
$from .= 'From:' .$_POST[$values[1]];

for( $i = 0 ; $i < count( $values ) ; ++$i ) {
	for( $c = 0 ; $c < count( $required ) ; ++$c ) {
		if( $values[$i]==$required[$c]) {
			echo $required[$x];
            if( empty($_POST[$values[$i]])) { ?> 
                <script> $(function(){ alert('All fields are required.'); }); </script>
                <?php 
                exit; 
            }
		}
	}
	$email_content .= $values[$i].': '.$_POST[$values[$i]]."\n";
}

if(mail($your_email,$email_subject,$email_content,$from)) { ?>
    <script>
        $(function(){ alert('Got it. Thanks.'); });
    </script>
<?php  } else { ?>

<?php } ?>
</html>
