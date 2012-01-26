<table width="100%" border="0" cellspacing=0 cellpadding=0>
<form action="admin.php" method="post">
<input type="hidden" name="a" value="user_group">
<input type="hidden" name="g_id" value="<?=$_POST[g_id]?>">
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
<select name="g_id">
<?
$groups = mysql_query("SELECT * FROM ticket_groups");
while ($group = mysql_fetch_array($groups)) {
	?>
    <option value="<?=$group[ID]?>"<?= ($group[ID] == $_POST[g_id]) ? " SELECTED": ""?>><?=$group[name]?></option>
    <?
}
?>
</select></td><td>&nbsp;</td><td><input type="submit" name="select" value="Select" class="inputsubmit"> 
<input type="submit" name="delete" value="Delete" class="inputsubmit"> <input type="submit" name="submit_new" value="Add New" class="inputsubmit"></td></tr></table>
<p>

<table width="100%" border="0" cellspacing=1 cellpadding=2 class="TableMsg">
<tr><td width="120" class="TableHeaderText">&nbsp;Group Access</td><td>&nbsp;</td></tr>
<?
if (!$g_id) { $submit_new = true; }

if ($select) {
	$group = mysql_fetch_array(mysql_query("SELECT * FROM ticket_groups WHERE ID=$g_id"));
    $access_cats = explode(":", $group[cat_access]);
	?>
	<input type="hidden" name="old_name" value="<?=$group[name]?>">
    <tr><td class="mainTable">&nbsp;<b>Name:</b></td><td class="mainTableAlt"><input type="text" name="name" value="<?=$group[name]?>"></td></tr>
    <tr><td class="mainTable">&nbsp;User Groups:</td><td class="mainTableAlt"><input type="checkbox" name="group"<?= $group[user_group] ? " CHECKED": ""?>></td></tr>
    <tr><td class="mainTable">&nbsp;Representatives:</td><td class="mainTableAlt"><input type="checkbox" name="rep"<?= $group[rep] ? " CHECKED": ""?>></td></tr>
	<tr><td class="mainTable">&nbsp;Categories:</td><td class="mainTableAlt"><input type="checkbox" name="cat"<?= $group[cat] ? " CHECKED": ""?>></td></tr>
    <tr><td class="mainTable">&nbsp;Preferences:</td><td class="mainTableAlt"><input type="checkbox" name="pref"<?= $group[pref] ? " CHECKED": ""?>></td></tr>
    <tr><td class="mainTable">&nbsp;Responces:</td><td class="mainTableAlt"><input type="checkbox" name="mail"<?= $group[mail] ? " CHECKED": ""?>></td></tr>
    <tr><td class="mainTable">&nbsp;Banlist:</td><td class="mainTableAlt"><input type="checkbox" name="banlist"<?= $group[banlist] ? " CHECKED": ""?>></td></tr>
    <tr><td class="mainTable">&nbsp;Category:</td><td class="mainTableAlt">

    <input type="checkbox" name="cat_access[all]"<?= (in_array($cat[ID], $access_cats) or $g_id == 1 or $access_cats[0] == "all") ? " CHECKED": ""?>> All
    <br>
    <?
    $cats = mysql_query("SELECT * FROM ticket_categories");
    while ($cat = mysql_fetch_array($cats)) {
    	?>
    	<input type="checkbox" name="cat_access[<?=$cat[ID]?>]"<?= (in_array($cat[ID], $access_cats) or $g_id == 1 or $access_cats[0] == "all") ? " CHECKED": ""?>> <?=$cat[name]?>
        <br>
        <?
    }
    ?>
    </td></tr></table>
	<p>
    <input type="submit" name="submit" value="Save Changes" class="inputsubmit">
	<?
}
elseif ($submit_new) {
	$group = mysql_fetch_array(mysql_query("SELECT * FROM ticket_groups"));
    $access_cats = explode(":", $group[cat_access]);
	?>
    <tr><td class="mainTable">&nbsp;<b>Name:</b></td><td class="mainTableAlt"><input type="text" name="name"></td></tr>
    <tr><td class="mainTable">&nbsp;User Groups:</td><td class="mainTableAlt"><input type="checkbox" name="group"></td></tr>
    <tr><td class="mainTable">&nbsp;Representatives:</td><td class="mainTableAlt"><input type="checkbox" name="rep"></td></tr>
	<tr><td class="mainTable">&nbsp;Categories:</td><td class="mainTableAlt"><input type="checkbox" name="cat"></td></tr>
    <tr><td class="mainTable">&nbsp;Preferences:</td><td class="mainTableAlt"><input type="checkbox" name="pref"></td></tr>
    <tr><td class="mainTable">&nbsp;Responces:</td><td class="mainTableAlt"><input type="checkbox" name="mail"></td></tr>
    <tr><td class="mainTable">&nbsp;Banlist:</td><td class="mainTableAlt"><input type="checkbox" name="banlist"></td></tr>
    <tr><td class="mainTable">&nbsp;Category:</td><td class="mainTableAlt">

    <input type="checkbox" name="cat_access[all]"> All
	<br>
    <?
    $cats = mysql_query("SELECT * FROM ticket_categories");
    while ($cat = mysql_fetch_array($cats)) {
    	?>
    	<input type="checkbox" name="cat_access[<?=$cat[ID]?>]"> <?=$cat[name]?>
		<br>
        <?
    }
    ?>
    </td></tr></table>
	<p>
    <input type="submit" name="add" value="Create User Group" class="inputsubmit">
	<?
}
?>

</td></tr></form></table>
