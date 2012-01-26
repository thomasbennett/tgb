<!-- <?php session_start(); ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache"); // HTTP/1.0 
?> -->
<html>
<head>
<title><?=$osticket_title?> : <?=$titles[$inc] ? "$titles[$inc]": ""?></title>
<link rel="stylesheet" href="stylesheet.css" type="text/css">
<META NAME="ROBOTS" CONTENT="NOINDEX">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=UTF-8">
<script language="JavaScript" type="text/javascript">
<!--
function PopWindow()
{
window.open('help.php','help','width=400,height=250,menubar=no,scrollbars=no,toolbar=no,location=yes,directories=no,resizable=no,top=200,left=300');
}
//-->
</script>
</head>
<body background="images/bg.gif" bgcolor="#FFFFFF" link="#000000" vlink="#000000" text="#000000" leftmargin="0" rightmargin="0" topmargin="10">
<center>
<table width="740" bgcolor="#cccccc" cellspacing="1" cellpadding="1"><tr><td bgcolor="#ffffff">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr><td><a href="<?=$page?>"><img src="images/logo.jpg" alt="Main" border="0"></a></td></tr>
  <tr><td bgcolor="#999999"><img src="images/spacer.gif" width="1" height="2"></td></tr>
  <tr><td align="right" class="TableHeader">
    <table cellpadding="0" cellspacing="3" border="0" class="barTxt">
    <tr>
<td><a class="barTxt" href="<?=$page?>"><img src="images/arrow.gif" border="0"></a></td>
 <td><a class="barTxt" href="<?=$page?>">Main</a></td>
<td><a class="barTxt" href="JavaScript:PopWindow()"><img src="images/arrow.gif" border="0"></a></td>
 <td><a class="barTxt" href="JavaScript:PopWindow()">Help</a><?if ($login) {?>
<td><?if (!$config[search_disp]) {?><a class="barTxt" href="search.php"><img src="images/arrow.gif" border="0"></a></td>
 <td><a class="barTxt" href="search.php">Search</a></td><?}?>
<td><a class="barTxt" href="open.php"><img src="images/arrow.gif" border="0"></a></td>
 <td><a class="barTxt" href="open.php">New Ticket</a></td>
<td><a class="barTxt" href="<?=$page?>?a=logout"><img src="images/arrow.gif" border="0"></a></td>
 <td><a class="barTxt" href="<?=$page?>?a=logout">Logout</a><?}?></td></tr>
    </table>
  </td></tr>
</table>

<table bgcolor="#FFFFFF" width="100%" cellpadding="10" cellspacing="0" border="0" align="center">
	<tr>
		<td align="center">
