<?php require('../helpers/functions.php') ?>
<?php $pageTitle = "Contact Us" ?>
<?php ob_start() ?>

<div class="left">
    <img class="right" src="<?php echo DOMAIN ?>/images/contact.jpg" />

    <h1>Make the Right Move</h1>
    <p>Don't wait! Make the right move and give us a call or shoot us an email. We'll help you in turning over your lost revenue into the money you never thought you would see.</p>

    <h1>Address</h1>
	<p>P.O. Box 514<br />
	1303 Tebeau St<br />
	Waycross, GA 31502</p>

	<h1>Reach us by phone</h1>
	<p>(912) 283-4050 (Phone)<br />
	(912) 283-0550 (Fax) <br />
	(877) 211-7808 (Toll Free)</p>

    <h1>Shoot us an email</h1>
    <p>Manager: <a href="mailto:susan@mbbcollect.com">Susan Bennett</a></p>
</div>

<?php $pageContents = ob_get_clean() ?>
<?php require('../template.php') ?>
