<table width="100%" border="0" cellspacing=0 cellpadding=0>
<form action="admin.php" method="post">
<input type="hidden" name="a" value="rep">
<input type="hidden" name="r_id" value="<?=$_POST[r_id]?>">
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
<table border="0" cellspacing=0 cellpadding=0><tr><td>
<select name="r_id">
<?
$reps = mysql_query("SELECT * FROM ticket_reps");
while ($rep = mysql_fetch_array($reps)) {
	$selected = ($rep[ID] == $_POST[r_id]) ? " SELECTED": "";
	?>
    <option value="<?=$rep[ID]?>"<?=$selected?>><?=$rep[name]?></option>
    <?
}
?>
</select></td><td>&nbsp;</td><td><input type="submit" name="select" value="Select" class="inputsubmit"> 
<input class="inputsubmit" type="submit" name="delete" value="Delete"> <input type="submit" name="submit_new" value="Add New" class="inputsubmit"></td></tr></table>
<p>

<table width="100%" border="0" cellspacing=1 cellpadding=2 class="TableMsg">
<tr><td class="TableHeaderText" width="120">&nbsp;Representative</td><td>&nbsp;</td></tr>
<?
if (!$_POST[r_id]) { $submit_new = true; }

if ($select) {
	$rep = mysql_fetch_array(mysql_query("SELECT * FROM ticket_reps WHERE ID='$_POST[r_id]'"));
	?>
	<input type="hidden" name="old_username" value="<?=$rep[username]?>">
	<tr><td class="mainTable">&nbsp;<b>Username:</b></td><td class="mainTableAlt"><input type="text" name="username" value="<?=$rep[username]?>"></td></tr>
    <tr><td class="mainTable">&nbsp;<b>Name:</b></td><td class="mainTableAlt"><input type="hidden" name="old_name" value="<?=$rep[name]?>"><input type="text" name="name" value="<?=$rep[name]?>"></td></tr>
    <tr><td class="mainTable">&nbsp;<b>Email:</b></td><td class="mainTableAlt"><input type="text" name="email" value="<?=$rep[email]?>"></td></tr>
    <tr><td class="mainTable">&nbsp;<b>Password:</b></td><td class="mainTableAlt"><input type="password" name="password"></td></tr>

    <tr><td class="mainTable">&nbsp;<b>Group:</b></td><td class="mainTableAlt">

   <select name="group">
   <?
   $groups = mysql_query("SELECT * FROM ticket_groups");
   while ($group = mysql_fetch_array($groups)) {
       $selected = ($group[ID] == $rep[user_group]) ? " SELECTED": "";
        ?>
        <option value="<?=$group[ID]?>"<?=$selected?>><?=$group[name]?></option>
        <?
   }
   ?>
   </select>

   </td></tr>

   <tr><td class="mainTable">&nbsp;Signature:</td><td class="mainTableAlt"><textarea name="edit_sig" cols="30" rows="5"><?=$rep[signature]?></textarea></td></tr>
   </table>
   <p> 
   <input class="inputsubmit" type="submit" name="submit" value="Save Changes">
   <?
}
elseif ($submit_new) {
	?>
	<tr><td class="mainTable">&nbsp;<b>Username:</b></td><td class="mainTableAlt"><input type="text"" name="username"></td></tr>
    <tr><td class="mainTable">&nbsp;<b>Name:</b></td><td class="mainTableAlt"><input type="text" name="name"></td></tr>
    <tr><td class="mainTable">&nbsp;<b>Email:</b></td><td class="mainTableAlt"><input type="text" name="email"></td></tr>
    <tr><td class="mainTable">&nbsp;<b>Password:</b></td><td class="mainTableAlt"><input type="password" name="password"></td></tr>
    <tr><td class="mainTable">&nbsp;<b>Group:</b></td><td class="mainTableAlt">
   <select name="group">
   <?
   $groups = mysql_query("SELECT * FROM ticket_groups");
   while ($group = mysql_fetch_array($groups)) {
        ?>
        <option value="<?=$group[ID]?>"><?=$group[name]?></option>
        <?
   }
   ?>
   </select>
   </td></tr>
    <tr><td class="mainTable">&nbsp;Signature:</td><td class="mainTableAlt"><textarea name="sig" cols="30" rows="5"></textarea></td></tr>
    </table>
	<p>
	<input class="inputsubmit" type="submit" name="add" value="Create Representative">
	<?
}
?>

</td></tr></form></table>
