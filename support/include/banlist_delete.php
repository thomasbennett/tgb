<?
/*
	Original Ban List Contribution by
	Chris Mathers
	chris@cheapdemos.com
 
	      This contrib will allow you to view, edit, delete the
	      banlist table from the admin area
 
	Modified for osTicket STS Distribution
*/
?>
<img src="images/spacer.gif" width="1" height="10"><br>
<form action="admin.php" method="post">
<input type="hidden" name="a" value="banlist_delete">
<p>
<input type="hidden" name="ab" value="D">
<?php
foreach ($key as $reckey) {
?>
<input type="hidden" name="key[]" value="<?php echo $reckey; ?>">
<?php
}
?>
<table border="0" cellspacing="1" cellpadding="4" class="TableMsg">
<tr>
<td class="TableHeaderText">Delete Banned</td>
</tr>
<?php
$recCount = 0;
while ($row = mysql_fetch_array($rs)) {
	$recCount = $recCount++;	
	$bgcolor = "#FFFFFF"; // set row color
	if ($recCount % 2 <> 0 ) {
		$bgcolor="#F5F5F5"; // display alternate color for rows
	}
	$x_value = @$row["value"];
	$x_value_id = @$row["value_id"];
?>
<tr class="mainTableAlt">
<td><font size="-1">
<?php echo $x_value; ?>&nbsp;
</font></td>
</tr>
<?php
}
mysql_free_result($rs);
mysql_close($conn);
?>
</table>
<br>
<input class="inputsubmit" type="submit" name="Action" value="Confirm Delete">
</form>
<a href="admin.php?a=banlist">Back to List</a>