<?php require('helpers/functions.php') ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Medical Business Bureau <?php if(isset($pageTitle)) echo " &raquo; $pageTitle" ?></title>

	<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN ?>/css/resets.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN ?>/css/global.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN ?>/css/main.css" />

	<script type="text/javascript" src="<?php echo DOMAIN ?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo DOMAIN ?>/js/cycle.js"></script>
	<script type="text/javascript" src="<?php echo DOMAIN ?>/js/init.js"></script>

	<!--[if IE 6]>
	<link rel="stylesheet" href="<?php echo DOMAIN ?>/css/ie6.css" type="text/css">
	<script language="javascript" src="<?php echo DOMAIN ?>/js/pngFix.js"></script>
	<script>
	DD_belatedPNG.fix('img, #div, .pngFix');
	</script>
	<![endif]-->	
</head>
<body>
	<div id="container">
		<div id="top"></div>
		<div id="head">
			<div id="personality"></div>
			<div id="logo">Medical &amp; Business Bureau</div>
		</div>
		<div id="wrapper">
			<ul id="navContainer" class="inline">
				<?php include('nav.php') ?>
			</ul>

			<div class="clear"></div>

			<div id="content">
				<?php echo $pageContents ?>
			</div>
		</div>
		<div id="bottom"></div>
		<div class="clear"></div>
	</div>

	<div id="footer">
		<div class="center">
            <ul class="left">
                <li>&copy; <?php echo date('Y') ?> Medical &amp; Business Bureau | <a href="<?php echo DOMAIN ?>/privacy">Privacy</a> | Website: <a href="http://thomasgbennett.com" target="_blank">Thomas Bennett</a></li>
            </ul>

			<div class="right">
				<ul class="inline">
					<?php include('nav.php') ?>		
				</ul>
			</div>
		</div>
	</div>
</body>
</html>
