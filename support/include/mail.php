<table border="0" cellspacing=0 cellpadding=0>
<tr><td>
<form action="admin.php" method="post">
<input type="hidden" name="a" value="mail">

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
<table width="100%" border="0" cellspacing=0 cellpadding=0><tr><td>
	<table width="100%" border="0" cellspacing=0 cellpadding=0><tr class="TableMsg">
		<td width="1"><img src="images/spacer.gif" width="1" height="1"></td>
		<td><table border="0" cellspacing=3 cellpadding=0><tr>
			<td class="TableHeaderText">&nbsp;New Ticket Reply</td></tr></table></td>
		<td width="1"><img src="images/spacer.gif" width="1" height="1"></td>
	</tr><tr>
		<td class="TableHeader"><img src="images/spacer.gif" width="1" height="1"></td>
		<td class="TableInfoText"><table border="0" cellspacing=3 cellpadding=0><tr>
			<td class="TableInfoText">&nbsp;You can define the message that will be seen everytime a new ticket is opened.</td></tr></table></td>
		<td class="TableHeader"><img src="images/spacer.gif" width="1" height="1"></td>
	</tr></table>
<tr><td>
	<table width="100%" border="0" cellspacing=1 cellpadding=2 class="TableHeader">
	<tr><td class="mainTable" width="120">&nbsp;Enable:</td><td class="mainTableAlt"><input type="checkbox" name="ticket_response" <?=$config[ticket_response] ? "checked": ""?>></td></tr>
	<tr><td class="mainTable">&nbsp;Subject:</td><td class="mainTableAlt"><input type="text" name="ticket_subj" value="<?=$config[ticket_subj]?>" size="45"></td></tr>
	<tr><td class="mainTable">&nbsp;Message:</td><td class="mainTableAlt"><textarea rows="7" cols="45" name="ticket_msg"><?=$config[ticket_msg]?></textarea></td></tr>
	<tr><td class="mainTable">&nbsp;Variables:</td><td class="mainTableAlt">%ticket: Ticket Number.<br>%email: Email of user.<br>%url: osTicket URL.</td></tr></table>
</td></tr></table>

<table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="images/spacer.gif" width="1" height="5"></td></tr></table>	

<table width="100%" border="0" cellspacing=0 cellpadding=0><tr><td>
	<table width="100%" border="0" cellspacing=0 cellpadding=0><tr class="TableMsg">
		<td width="1"><img src="images/spacer.gif" width="1" height="1"></td>
		<td><table border="0" cellspacing=3 cellpadding=0><tr>
			<td class="TableHeaderText">&nbsp;New Message Reply</td></tr></table></td>
		<td width="1"><img src="images/spacer.gif" width="1" height="1"></td>
	</tr><tr>
		<td class="TableHeader"><img src="images/spacer.gif" width="1" height="1"></td>
		<td class="TableInfoText"><table border="0" cellspacing=3 cellpadding=0><tr>
			<td class="TableInfoText">&nbsp;You can define the message that will be seen everytime a replied is made to a ticket.</td></tr></table></td>
		<td class="TableHeader"><img src="images/spacer.gif" width="1" height="1"></td>
	</tr></table>
<tr><td>
	<table width="100%" border="0" cellspacing=1 cellpadding=2 class="TableHeader">
	<tr><td class="mainTable" width="120">&nbsp;Enable:</td><td class="mainTableAlt"><input type="checkbox" name="message_response" <?=$config[message_response] ? "checked": ""?>></td></tr>
	<tr><td class="mainTable">&nbsp;Subject:</td><td class="mainTableAlt"><input type="text" name="message_subj" value="<?=$config[message_subj]?>" size="45"></td></tr>
	<tr><td class="mainTable">&nbsp;Message:</td><td class="mainTableAlt"><textarea rows="7" cols="45" name="message_msg"><?=$config[message_msg]?></textarea></td></tr>
	<tr><td class="mainTable">&nbsp;Variables:</td><td class="mainTableAlt">%ticket: Ticket Number.<br>%email: Email of user.<br>%url: osTicket URL.</td></tr></table>
</td></tr></table>

<table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="images/spacer.gif" width="1" height="5"></td></tr></table>	

<table width="100%" border="0" cellspacing=0 cellpadding=0><tr><td>
	<table width="100%" border="0" cellspacing=0 cellpadding=0><tr class="TableMsg">
		<td width="1"><img src="images/spacer.gif" width="1" height="1"></td>
		<td><table border="0" cellspacing=3 cellpadding=0><tr>
			<td class="TableHeaderText">&nbsp;Over Ticket Limit Reply</td></tr></table></td>
		<td width="1"><img src="images/spacer.gif" width="1" height="1"></td>
	</tr><tr>
		<td class="TableHeader"><img src="images/spacer.gif" width="1" height="1"></td>
		<td class="TableInfoText"><table border="0" cellspacing=3 cellpadding=0><tr>
			<td class="TableInfoText">&nbsp;This message will be seen when a user has reached the max allowed opened tickets defined in preferences</td></tr></table></td>
		<td class="TableHeader"><img src="images/spacer.gif" width="1" height="1"></td>
	</tr></table>
<tr><td>
	<table width="100%" border="0" cellspacing=1 cellpadding=2 class="TableHeader">
	<tr><td class="mainTable" width="120">&nbsp;Enable:</td><td class="mainTableAlt"><input type="checkbox" name="limit_response" <?=$config[limit_response] ? "checked": ""?>></td></tr>
	<tr><td class="mainTable">&nbsp;E-Mail:</td><td class="mainTableAlt"><input type="text" name="limit_email" value="<?=$config[limit_email]?>" size="45"></td></tr>
	<tr><td class="mainTable">&nbsp;Subject:</td><td class="mainTableAlt"><input type="text" name="limit_subj" value="<?=$config[limit_subj]?>" size="45"></td></tr>
	<tr><td class="mainTable">&nbsp;Message:</td><td class="mainTableAlt"><textarea rows="7" cols="45" name="limit_msg"><?=$config[limit_msg]?></textarea></td></tr>
	<tr><td class="mainTable">&nbsp;Variables:</td><td class="mainTableAlt">%ticket_max: Maximum tickets a user can have open (see preferences).<br>%url: osTicket URL.</td></tr></table>
</td></tr></table>

<table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="images/spacer.gif" width="1" height="5"></td></tr></table>	

<table width="100%" border="0" cellspacing=0 cellpadding=0><tr><td>
	<table width="100%" border="0" cellspacing=0 cellpadding=0><tr class="TableMsg">
		<td width="1"><img src="images/spacer.gif" width="1" height="1"></td>
		<td><table border="0" cellspacing=3 cellpadding=0><tr>
			<td class="TableHeaderText">&nbsp;Category Transfer Notification</td></tr></table></td>
		<td width="1"><img src="images/spacer.gif" width="1" height="1"></td>
	</tr><tr>
		<td class="TableHeader"><img src="images/spacer.gif" width="1" height="1"></td>
		<td class="TableInfoText"><table border="0" cellspacing=3 cellpadding=0><tr>
			<td class="TableInfoText">&nbsp;This message will be seen when a message has been transfered to a different category.</td></tr></table></td>
		<td class="TableHeader"><img src="images/spacer.gif" width="1" height="1"></td>
	</tr></table>
<tr><td>
	<table width="100%" border="0" cellspacing=1 cellpadding=2 class="TableHeader">
	<tr><td class="mainTable" width="120">&nbsp;Enable:</td><td class="mainTableAlt"><input type="checkbox" name="trans_response" <?=$config[trans_response] ? "checked": ""?>></td></tr>
	<tr><td class="mainTable">&nbsp;Subject:</td><td class="mainTableAlt"><input type="text" name="trans_subj" value="<?=$config[trans_subj]?>" size="45"></td></tr>
	<tr><td class="mainTable">&nbsp;Message:</td><td class="mainTableAlt"><textarea rows="7" cols="45" name="trans_msg"><?=$config[trans_msg]?></textarea></td></tr>
	<tr><td class="mainTable">&nbsp;Variables:</td><td class="mainTableAlt">%ticket: Ticket Number.<br>%cat_name: Name of category transferred to.<br>%trans_msg: Representative's transfer note.<br>%url: osTicket URL.</td></tr></table>
</td></tr></table>

<table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="images/spacer.gif" width="1" height="5"></td></tr></table>	

<table width="100%" border="0" cellspacing=0 cellpadding=0><tr><td>
	<table width="100%" border="0" cellspacing=0 cellpadding=0><tr class="TableMsg">
		<td width="1"><img src="images/spacer.gif" width="1" height="1"></td>
		<td><table border="0" cellspacing=3 cellpadding=0><tr>
			<td class="TableHeaderText">&nbsp;Email Alert</td></tr></table></td>
		<td width="1"><img src="images/spacer.gif" width="1" height="1"></td>
	</tr><tr>
		<td class="TableHeader"><img src="images/spacer.gif" width="1" height="1"></td>
		<td class="TableInfoText"><table border="0" cellspacing=3 cellpadding=0><tr>
			<td class="TableInfoText">&nbsp;This message will be seen by Admin only when the system has received a new message.</td></tr></table></td>
		<td class="TableHeader"><img src="images/spacer.gif" width="1" height="1"></td>
	</tr></table>
<tr><td>
	<table width="100%" border="0" cellspacing=1 cellpadding=2 class="TableHeader">
	<tr><td class="mainTable" width="120">&nbsp;Enable:</td><td class="mainTableAlt"><input type="checkbox" name="alert_new" <?=$config[alert_new] ? "checked": ""?>></td></tr>
	<tr><td class="mainTable">&nbsp;Addresses to Email:</td><td class="mainTableAlt"><input type="text" name="alert_user" value="<?=$config[alert_user]?>"></td></tr>
	<tr><td class="mainTable">&nbsp;From E-Mail:</td><td class="mainTableAlt"><input type="text" name="alert_email" value="<?=$config[alert_email]?>" size="45"></td></tr>
	<tr><td class="mainTable">&nbsp;Subject:</td><td class="mainTableAlt"><input type="text" name="alert_subj" value="<?=$config[alert_subj]?>" size="45"></td></tr>
	<tr><td class="mainTable">&nbsp;Message:</td><td class="mainTableAlt"><textarea rows="7" cols="45" name="alert_msg"><?=$config[alert_msg]?></textarea></td></tr>
	<tr><td class="mainTable">&nbsp;Variables:</td><td class="mainTableAlt">%ticket: Ticket Number.<br>%email: Email of user.<br>%message: Content of ticket request.<br>%url: osTicket URL.</td></tr></table>
</td></tr></table>
<p>

<input class="inputsubmit" type="submit" name="submit" value="Save Changes">
</form>
</td></tr>
</table>
