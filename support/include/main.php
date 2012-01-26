<script>
function selectAll()
{
  void(d=document);
  void(el=d.getElementsByTagName('INPUT'));
  for(i=0;i<el.length;i++)
    void(el[i].checked=1) 
}
</script>
<?
if ($config[search_disp]) {
	include("$include_dir/search.php");
}

$status = $_SESSION[view] ? str_replace("View ", "", $_SESSION[view]): "Open";

$p = !$p ? 1: $p;
$start = ($p - 1) * $config[tickets_per_page];

$where = $_SESSION[user][type] == "client" ? "WHERE email='" . $_SESSION[user][id] . "'": "";
$tickets_res = mysql_query("SELECT * FROM tickets $where ORDER BY timestamp DESC");
?>
<table width="100%" border="0" cellspacing=0 cellpadding=0 align="center">
<?
if ($err) {
    ?>
    <tr>
        <td class="error"><?=$err?><?=$help_link?><p></td>
    </tr>
    <?
}
?>
<tr><td class="error"><?=$_SESSION[user][warn]?></td></tr>
<tr><td>&nbsp;&nbsp;<b><?=$status?> Tickets</b><br><br></td></tr>
</table>
<table width="100%" border="0" cellspacing=1 cellpadding=2>
<form action="<?=$PHP_SELF?>" method="POST">
<tr><td>
<table border="0" cellspacing=1 cellpadding=2 class="TableMsg" align="center">
<tr>
	<td width="22">&nbsp;</td>
	<td width="50" class="TableHeaderText">Ticket</td>
	<td width="70" class="TableHeaderText">Date</td>
	<td width="263" class="TableHeaderText">Subject</td>
	<td width="100" class="TableHeaderText">Category</td>
	<td width="50" class="TableHeaderText">Priority</td>
    <td width="125" class="TableHeaderText">From</td>
	<td width="20" class="TableHeaderText">UM</td>
</tr>
<?
$_SESSION[user][warn]='';
$class = "mainTable";
$total = 0;
while ($tickets_row = mysql_fetch_array($tickets_res)) {
    $eval = new Ticket($tickets_row);

    if ($eval->status == "answered") {
        ++$i;
        $um[$i] = $eval;
    }
    
    if ($total >= $start and $total <= ($start + $config[tickets_per_page]) - 1 and $eval->status == strtolower($status) and ($_SESSION[user][type] == "client" or (@in_array($eval->cat, $oslogin[cat_access]) or $oslogin[cat_access][0] == "all"))) {
        switch ($eval->priority) {
        case 1:
        	$color = "class=priLow";
        	$pri = "Low";
        break;
        case 2:
        	$color = "class=priNormal";
        	$pri = "Normal";
        break;
        case 3:
        	$color = "class=priHigh";
        	$pri = "High";
        }

        $cat_res = mysql_query("SELECT * FROM ticket_categories WHERE ID=$eval->cat");
        $cat_row = mysql_fetch_array($cat_res);
        
        $hide = ($_SESSION[user][type] == "client" and $cat_row[hidden]);
        $cat_row[name] = $hide ? "In Process...": $cat_row[name];
        ?>
        <tr class="<?=$class?>" onmouseover="this.className='mainTableOn';" onmouseout="this.className='<?=$class?>';">
        <td align="center"><input type="checkbox" name="t[<?=$eval->id?>]">
        <td align="center"><a href="<?=$page?>?a=view&id=<?=$eval->id?>"><?=$eval->id?></a></td>
        <td align="center"><?=$eval->short_time?></td>
        <td>&nbsp;<a href="<?=$page?>?a=view&id=<?=$eval->id?>"><?=$eval->subject?></a></td>
        <td>&nbsp;<?=$cat_row[name]?></td>
        <td align="center" <?=$color?>><?=$pri?></td>
        <td>&nbsp;<?=$eval->name?></td>
        <td>&nbsp;<?=$eval->unanswered?>
        </tr>
        <?
         $class = ($class == "mainTableAlt") ? "mainTable": "mainTableAlt";
    }

    if ($eval->status == strtolower($status)) {
        ++$total;
    }
}
?>
</table>

<?
$pages = $total / $config[tickets_per_page];
$pages = (intval($pages) !== $pages) ? intval($pages) + 1: $pages;

for ($x = 1; $x <= $pages; ++$x) {
    if ($x == $p) {
        $ps .= "$x, ";
    }
    else {
        $ps .= "<a href='admin.php?p=$x'>$x</a>, ";
    }
}
if ($pages > 1) {
    echo "page: " . substr($ps, 0, strlen($ps)-2);
}
?>

<input class="inputsubmit2" type=button onclick="selectAll()" value="Select All"> 
<input class="inputsubmit2" type=reset value="Unselect">
<center><br>
<?
//unanswered messages when status is "open"
$config[umq] = ($i < $config[umq]) ? $i: $config[umq];
if ($status == "Open" and $config[umq]) {
?>
    <table width="100%" border="0" cellspacing=0 cellpadding=0 align="center">
    <tr><td>&nbsp;<b>Last <?=$config[umq]?> Answered Tickets</b><br><br>
    </td></tr>
    </table>
    <table width="100%" border="0" cellspacing=1 cellpadding=2 class="TableMsg" align="center">
    <tr>
	<td width="22">&nbsp;</td>
	<td width="50" class="TableHeaderText">Ticket</td>
	<td width="70" class="TableHeaderText">Date</td>
	<td width="263" class="TableHeaderText">Subject</td>
	<td width="100" class="TableHeaderText">Category</td>
	<td width="50" class="TableHeaderText">Priority</td>
    <td width="125" class="TableHeaderText">From</td>
	<Td width="20" class="TableHeaderText">UM</td>
    </tr>
    <?
    $class = "mainTable";
    for ($i = 1; $i <= $config[umq]; ++$i) {
    switch ($um[$i]->priority) {
    case 1:
    	$color = "class=priLow";
    	$pri = "Low";
    break;
    case 2:
    	$color = "class=priNormal";
    	$pri = "Normal";
    break;
    case 3:
    	$color = "class=priHigh";
    	$pri = "High";
    }
    if ($_SESSION[user][type] == "client" or (@in_array($um[$i]->cat, $oslogin[cat_access]) or $oslogin[cat_access][0] == "all")) {
        $cat_res = mysql_query("SELECT * FROM ticket_categories WHERE ID=" . $um[$i]->cat);
        $cat_row = mysql_fetch_array($cat_res);
        
        $hide = ($_SESSION[user][type] == "client" and $cat_row[hidden]);
        $cat_row[name] = $hide ? "In Process...": $cat_row[name];
        ?>
            <tr class="<?=$class?>" onmouseover="this.className='mainTableOn';" onmouseout="this.className='<?=$class?>';">
            <td align="center"><input type="checkbox" name="t[<?=$um[$i]->id?>]">
            <td align="center"><a href="<?=$PHP_SELF?>?a=view&id=<?=$um[$i]->id?>"><?=$um[$i]->id?></a></td>
            <td align="center"><?=$um[$i]->short_time?></td>
            <td>&nbsp;<a href="<?=$PHP_SELF?>?a=view&id=<?=$um[$i]->id?>"><?=$um[$i]->subject?></a></td>
            <td>&nbsp;<?=$cat_row[name]?></td>
            <td align="center" <?=$color?>><?=$pri?></td>
            <td>&nbsp;<?=$um[$i]->name?></td>
            <td>&nbsp;<?=$um[$i]->unanswered?></td>
            </tr>
        <?
        $class = ($class == "mainTableAlt") ? "mainTable": "mainTableAlt";
    }
    }
    ?>
    </table>
    <br><br>
<?
}
if ($_SESSION[user][type] == "admin" and $oslogin[ID] == ADMIN) {
?>
<input type="image" src="images/buttons/delete.gif" name="delete" value="Delete">
<?
}
switch ($status) {
    case "Closed":
    ?>
    <input type="image" src="images/buttons/reopen.gif" name="reopen" value="Reopen"> <input type="image" src="images/buttons/view_open.gif" name="view_open" value="View Open"> <input input type="image" src="images/buttons/view_answered.gif" name="view_answered" value="View Answered">
    <?
    break;
    case "Open":
    ?>
    <input type="image" src="images/buttons/close.gif" name="close" value="Close"> <input type="image" src="images/buttons/view_answered.gif" name="view_answered" value="View Answered"> <input type="image" src="images/buttons/view_closed.gif" name="view_closed" value="View Closed">
    <?
    break;
    case "Answered":
    ?>
    <input type="image" src="images/buttons/close.gif" name="close" value="Close"> <input type="image" src="images/buttons/view_open.gif" name="view_open" value="View Open"> <input type="image" src="images/buttons/view_closed.gif" name="view_closed" value="View Closed">
    <?
    break;
}
?>
<input type="image" src="images/buttons/refresh.gif" name="refresh" value="Refresh">
</center>
</td></tr>
</form>
</table>
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
<?
