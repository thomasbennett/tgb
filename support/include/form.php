<table align="left" cellpadding=3 cellspacing=0>
<form action="open.php" method="POST" enctype="multipart/form-data">
<tr>
<td align="left"><b>Full Name:</b></td>
<?
if ($vuser && $_SESSION[user][type] == "client") {
    $client = mysql_fetch_array(mysql_query("SELECT DISTINCT name FROM tickets WHERE email='" . $_SESSION[user][id] . "'"));
    ?>
    <input type="hidden" name="name" value="<?=$client[name]?>">
    <td><?=$client[name]?></td>
    <?
}
else {
	?>
    <td><input type="text" name="name" size="25" value="<?=$_REQUEST[name]?>"></td>
	<?
}
?>

</tr>
<tr>
 <td align="left"><b>Email Address:</b></td>
<?
if (!$vuser || $_SESSION[user][type] !== "client") {
    ?>
    <td><input type="text" name="email" size="25" value="<?=$_REQUEST[email]?>"></td>
    <?
}
else {
	?>
	<input type="hidden" name="email" size="25" value="<?=$_SESSION[user][id]?>">
	<td><?=$_SESSION[user][id]?></td>
	<?
}
?>
</tr>
<tr>
 <td align="left">Telephone:</td>
 <td><input type="text" name="phone" size="25" value="<?=$_REQUEST[phone]?>"></td>
</tr>
<tr>
 <td align="left"><b>Department:</b></td>
 <td><select name="cat">
<?
$cats = mysql_query("SELECT * FROM ticket_categories");
while ($category = mysql_fetch_array($cats)) {
    $selected = ($_REQUEST[cat] == $category[ID]) ? " SELECTED": "";
    ?>
    <option value="<?=$category[ID]?>"<?=$selected?>><?=$category[name]?></option>
    <?
}
?>
</select>
 </td>
</tr>
<tr>
 <td align="left"><b>Subject:</b></td>
 <td><input type="text" name="subject" size="35" value="<?=$_REQUEST[subject]?>"></td>
</tr>
<tr>
 <td align="left" valign="top"><b>Message:</b></td>
 <td><textarea name="message" cols="35" rows="6"><?=$_REQUEST[message]?></textarea></td>
</tr>
<tr>
 <td align="left">Priority:</td>
 <td>
  <select name="pri">
  <option value="1">Low</option>
  <option value="2" selected>Normal</option>
  <option value="3">High</option>
  </select>
 </td>
</tr>
<?if($vuser && $config[accept_attachments]){?>
<tr>
<td>Attachment:</td><td><input type="hidden" name="MAX_FILE_SIZE" value="<?=$config[attachment_size]?>"><input type="file" name="attachment"></td>
</tr>
<?}?>
<tr>
<td></td><td><input class="inputsubmit" type="submit" name="submit_x" value="Open Ticket">&nbsp;<input class="inputsubmit" type="reset" value="Reset"></td>
</tr>
</form>
</table>