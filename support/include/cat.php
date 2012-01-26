<table width="100%" border="0" cellspacing=0 cellpadding=0> 
<form action="admin.php" method="post"> 
<input type="hidden" name="a" value="cat"> 
<input type="hidden" name="c_id" value="<?=$_POST[c_id]?>">
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
<select name="c_id"> 
<?
$cats = mysql_query("SELECT * FROM ticket_categories");
while ($cat = mysql_fetch_array($cats)) {
	$selected = ($cat[ID] == $c_id) ? " SELECTED": "";
	?> <option value="<?=$cat[ID]?>"<?=$selected?>><?=$cat[name]?></option> 
<?
}
?> </select></td><td>&nbsp;</td><td><input type="submit" name="select" value="Select" class="inputsubmit"> 
<input class="inputsubmit" type="submit" name="delete" value="Delete"> <input type="submit" name="submit_new" value="Add New" class="inputsubmit"></td></tr></table>
<p> 

<table width="100%" border="0" cellspacing=1 cellpadding=2 class="TableMsg">
<tr><td class="TableHeaderText" width="120">&nbsp;Categories</td><td>&nbsp;</td></tr>
<?
if (!$_POST[c_id]) { $_POST[submit_new] = true; }

if ($_POST[select]) {
	$cat = mysql_fetch_array(mysql_query("SELECT * FROM ticket_categories WHERE ID=$c_id"));
    ?> <input type="hidden" name="old_name" value="<?=$cat[name]?>"> 
<tr><td class="mainTable">&nbsp;<b>Name:</b></td><td class="mainTableAlt"><input type="text" name="name" value="<?=$cat[name]?>"></td></tr> 
<tr><td class="mainTable">&nbsp;POP3&nbsp;Host:</td><td class="mainTableAlt"><input type="text" name="pophost" value="<?=$cat[pophost]?>"></td></tr> 
<tr><td class="mainTable">&nbsp;POP3&nbsp;User:</td><td class="mainTableAlt"><input type="text" name="popuser" value="<?=$cat[popuser]?>"></td></tr> 
<tr><td class="mainTable">&nbsp;POP3&nbsp;Pass:</td><td class="mainTableAlt"><input type="password" name="poppass" value="<?=$cat[poppass]?>"></td></tr> 
<tr><td class="mainTable">&nbsp;<b>Email:</b></td><td class="mainTableAlt"><input type="text" name="email" value="<?=$cat[email]?>"></td></tr> 
<tr><td class="mainTable">&nbsp;Signature:</td><td class="mainTableAlt"><textarea name="sig" cols="30" rows="5"><?=$cat[signature]?></textarea></td></tr> 
<tr><td class="mainTable">&nbsp;Hidden:</td><td class="mainTableAlt"><input type="checkbox" name="hidden" <?= $cat[hidden] ? " CHECKED": ""?>></td></tr>
</table>
<p>
<input class="inputsubmit" type="submit" name="submit" value="Save Changes">
<?
}
elseif ($_POST[submit_new]) {
    ?> <tr><td class="mainTable">&nbsp;<b>Name:</b></td><td class="mainTableAlt"><input type="text" name="name"></td></tr> 
<tr><td class="mainTable">&nbsp;POP3&nbsp;Host:</td><td class="mainTableAlt"><input type="text" name="pophost"></td></tr> 
<tr><td class="mainTable">&nbsp;POP3&nbsp;User:</td><td class="mainTableAlt"><input type="text" name="popuser"></td></tr> 
<tr><td class="mainTable">&nbsp;POP3&nbsp;Pass:</td><td class="mainTableAlt"><input type="password" name="poppass"></td></tr> 
<tr><td class="mainTable">&nbsp;<b>Email:</b></td><td class="mainTableAlt"><input type="text" name="email"></td></tr> 
<tr><td class="mainTable">&nbsp;Signature:</td><td class="mainTableAlt"><textarea name="sig" cols="30" rows="5"></textarea></td></tr>  
<tr><td class="mainTable">&nbsp;Hidden:</td><td class="mainTableAlt"><input type="checkbox" name="hidden"></td></tr>
</table>
<p>
<input class="inputsubmit" type="submit" name="add" value="Create Category">
<?
}
?> 
</td></tr></form></table>
