<table width="100%" border="0" cellspacing=0 cellpadding=0>
<form action="admin.php" method="post">
<input type="hidden" name="a" value="my">
<tr><td>

	<?
    if ($_SESSION[user][type] == "admin") {
        $access = array();
        foreach ($titles as $item => $val) {
            if ($oslogin[$item]) {
                array_push($access, "<a href=admin.php?a=$item><img src=images/buttons/$item.gif alt=$val border=0></a>");
            }
        }
        $access = join(" ", $access);
        $access = $access ? "$access": "";
        ?>
    	<table width="100%" border="0" cellspacing=0 cellpadding=0>
        <tr><td align="center">
    	<?=$access?>
    	<?=$access ? " ": ""?>
    	<a href="admin.php?a=my"><img src=images/buttons/my.gif alt="My Account" border=0></a>
        </td></tr>
		<tr><td><img src="images/spacer.gif" width="1" height="10"></td></tr>
        </table>
	   <?
    }
    ?>

<table width="100%" border="0" cellspacing=1 cellpadding=2 class="TableMsg">
<tr><td class="TableHeaderText" width="120">&nbsp;My Account</td><td>&nbsp;</td></tr>
<?
$rep = mysql_fetch_array(mysql_query("SELECT * FROM ticket_reps WHERE username='" . $_SESSION[user][id] . "'"));
?>
<tr><td class="mainTable">&nbsp;<b>Username:</b></td><td class="mainTableAlt"><input type="text" name="username" value="<?=$_SESSION[user][id]?>"></td></tr>
<tr><td class="mainTable">&nbsp;<b>Name:</b></td><td class="mainTableAlt"><input type="text" name="name" value="<?=$rep[name]?>"></td></tr>
<tr><td class="mainTable">&nbsp;<b>Email:</b></td><td class="mainTableAlt"><input type="text" name="email" value="<?=$rep[email]?>"></td></tr>
<tr><td class="mainTable">&nbsp;<b>Password:</b></td><td class="mainTableAlt"><input type="password" name="password"></td></tr>
<tr><td class="mainTable">&nbsp;New Password:</td><td class="mainTableAlt"><input type="password" name="npassword"></td></tr>
<tr><td class="mainTable">&nbsp;Verify Password:</td><td class="mainTableAlt"><input type="password" name="vpassword"></td></tr>
<tr><td class="mainTable">&nbsp;Signature:</td><td class="mainTableAlt"><textarea name="sig" cols="30" rows="5"><?=$rep[signature]?></textarea></td></tr>
</table>
<p>
<input class="inputsubmit" type="submit" name="submit" value="Save Changes">

</td></tr></form></table>
