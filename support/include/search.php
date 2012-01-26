<?
$spage = $config[search_disp] ? $page: "search.php";
?>

<!-- SEARCH FORM START -->
<form action="<?=$spage?>" method="get">
<input type="hidden" name="s" value="<?=$s?>">

<table>
<tr>
<?
if ($_SESSION[user][type] == "admin") {
    ?>
    <td>E-mail: </td><td><input type="text" name="email" value="<?=$_GET[email]?>"></td>
    <?
}
else {
    $_GET[email] = $_SESSION[user][id];
}
?>
<td>Query: </td><td><input type="text" name="query" value="<?=$_GET[query]?>"></td>
<?
if ($s == "advanced") {
    ?>
    <td>Category:</td><td><select name="cat"><option></option>
    <?
    $cats = mysql_query("SELECT * FROM ticket_categories");
    while ($category = mysql_fetch_array($cats)) {
        $selected = ($_GET[cat] == $category[ID]) ? " SELECTED": "";
        ?>
        <option value="<?=$category[ID]?>"<?=$selected?>><?=$category[name]?></option>
        <?
    }
    ?>
    </select></td>
    <td>Status is:</td><td>
    
    <select name="status">
        <option></option>
        <option<?= $_GET[status] == "Open" ? " SELECTED": ""?>>Open</option>
        <option<?= $_GET[status] == "Answered" ? " SELECTED": ""?>>Answered</option>
        <option<?= $_GET[status] == "Closed" ? " SELECTED": ""?>>Closed</option>
    </select>
    
    </td></tr></table>
    <table>
    <tr><td>Sort by:</td><td>

    <select name="sort">
    	<option value="ID"<?= $_GET[sort] == "ID" ? " SELECTED": ""?>>Ticket #</option>
        <option value="priority"<?= $_GET[sort] == "priority" ? " SELECTED": ""?>>Priority</option>
        <option value="timestamp"<?= $_GET[sort] == "timestamp" ? " SELECTED": ""?>>Date</option>
        <option value="cat"<?= $_GET[sort] == "cat" ? " SELECTED": ""?>>Category</option>
    </select>
    
    <select name="way">
        <option value="ASC"<?= $_GET[way] == "ASC" ? " SELECTED": ""?>>Ascending</option>
        <option value="DESC"<?= $_GET[way] == "DESC" ? " SELECTED": ""?>>Descending</option>
    </select></td>
    <td>Results Per Page:</td><td>

    <select name="per">
    <?
    for ($x = 5; $x <= 25; $x += 5) {
        ?>
        <option<?=$_GET[per] == $x ? " SELECTED": ""?>><?=$x?></option>
        <?
    }
    ?>
    </select>

    </td>
    <td>
    <input type="submit" name="search_submit" class="inputsubmit" value="Search">
    [ <a href="<?=$spage?>">Basic</a> ]
    </td>
    <?
}
else {
    ?>
    <td>
    <input type="submit" name="search_submit" class="inputsubmit" value="Search">
    [ <a href="<?=$spage?>?s=advanced">Advance</a> ]
    </td>
    <?
}
?>
</tr>
</table>
<p>

<?
if ($_GET[search_submit]) {
    if (!$_GET[per]) {
        $_GET[per] = $config[tickets_per_page];
    }
    
    $_GET[pg] = !$_GET[pg] ? 1: $_GET[pg];
    $start = ($_GET[pg] - 1) * $_GET[per];

    $_GET[query] = $_GET[query] ? "(
    ticket_messages.message
    LIKE '%$_GET[query]%' OR ticket_answers.message
    LIKE '%$_GET[query]%' OR tickets.subject
    LIKE '%$_GET[query]%'
    )": 1;

    $_GET[cat] = $_GET[cat] ? "tickets.cat=$_GET[cat] AND": "";
    $restrict = ($_SESSION[user][type] == "client" or $_GET[email]) ? "tickets.email='$_GET[email]' AND": "";
    $_GET[sort] = !$_GET[sort] ? "timestamp": $_GET[sort];

    $search = mysql_query("SELECT DISTINCT tickets.ID AS ID, tickets.cat AS cat, tickets.subject AS subject, tickets.status AS status, priority, tickets.name AS name
    FROM (
    (
    tickets
    LEFT JOIN ticket_messages ON ticket_messages.ticket = tickets.ID
    )
    LEFT JOIN ticket_answers ON ticket_answers.reference = ticket_messages.ID
    )
    WHERE $_GET[cat] $restrict $_GET[query] ORDER BY tickets.$_GET[sort] $_GET[way]");

    $QUERY_STRING = eregi_replace("pg=[0-9]*&", "", $QUERY_STRING);
    ?>
    <table width="100%" border="0" cellspacing=0 cellpadding=0 align="center">
    <tr><td>
    <b>Search Tickets</b><br><br>
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
	<td width="20" class="TableHeaderText">UM</td>
    </tr>
    <?
    $class = "mainTableAlt";
    while ($item = mysql_fetch_array($search)) {
        $class = $class == "mainTableAlt" ? "mainTable": "mainTableAlt";
        $eval = new ticket($item);

        if ($total >= $start and $total <= ($start + $_GET[per]) - 1 and ($eval->status == strtolower($_GET[status]) or !$_GET[status])) {
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
            if ($_SESSION[user][type] == "client" or (@in_array($eval->cat, $oslogin[cat_access]) or $oslogin[cat_access][0] == "all")) {
                $cat_res = mysql_query("SELECT * FROM ticket_categories WHERE ID=" . $eval->cat);
                $cat_row = mysql_fetch_array($cat_res);
                ?>
                <tr class="<?=$class?>">
                <td align="center"><input type="checkbox" name="t[<?=$eval->id?>]">
                <td align="center"><a href="<?=$page?>?a=view&id=<?=$eval->id?>"><?=$eval->id?></a></td>
                <td align="center"><?=$eval->short_time?></td>
                <td>&nbsp;<?=$eval->subject?></td>
                <td>&nbsp;<?=$cat_row[name]?></td>
                <td align="center" <?=$color?>><?=$pri?></td>
                <td>&nbsp;<?=$eval->name?></td>
                <td>&nbsp;<?=$eval->unanswered?></td>
                </tr>
                <?
            }
        }

        if ($eval->status == strtolower($_GET[status]) or !$_GET[status]) {
            ++$total;
        }
    }
    ?>
    </table><br>
    <?
    @($pages = $total / $_GET[per]);
    $pages = (intval($pages) == $pages) ? $pages: intval($pages) + 1;
    if ($pages > 1) {
        for ($x = 1; $x <= $pages; ++$x) {
            if ($x == $_GET[pg]) {
                $pgs .= ", $x";
            }
            else {
                $pgs .= ", <a href='$spage?pg=$x&$QUERY_STRING'>$x</a>";
            }
        }
    }
    $pgs = substr($pgs, 2);
    ?>
    <?=intval($total)?> Ticket(s) Found <?= $pgs ? "( $pgs )": ""?>
<?
}
?>
</form>
<!-- SEARCH FORM END -->
