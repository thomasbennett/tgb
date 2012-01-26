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
<form action="admin.php">
<input type="hidden" name="a" value="banlist">
<table border="0" cellspacing="0" cellpadding="4">
	<tr>
				<td>Quick Search:</td>		
		<td><input type="text" name="psearch" size="20"></td>
			<td><input class="inputsubmit" type="Submit" name="Submit" value="Submit">		
		&nbsp;&nbsp;<a href="admin.php?a=banlist&cmd=reset">Show all</a>
		</td>
	</tr>
		<tr><td>&nbsp;</td><td colspan="2"><input type="radio" name="psearchtype" value="" checked>Exact phrase&nbsp;&nbsp;<input type="radio" name="psearchtype" value="AND">All words&nbsp;&nbsp;<input type="radio" name="psearchtype" value="OR">Any word</td></tr>	
</table>
</form>

<table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="100%" valign="top">

<form method="post">
  <table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableMsg">
    <tr> 
      <td class="TableHeaderText" colspan="4">&nbsp;Ban List<a href="admin.php?a=banlist&order=<?php echo urlencode("value"); ?>">&nbsp;
        <?php if ($OrderBy == "value") { ?>
        <font face="Webdings">
        <?php echo (@$_SESSION["ticket_banlist_OT"] == "ASC") ? 5 : ((@$_SESSION["ticket_banlist_OT"] == "DESC") ? 6 : "") ?>
        </font>
        <?php } ?>
		</font>
        </a> </td>
    </tr>
    <?php

// avoid starting record > total records
if ($startRec > $totalRecs) {
	$startRec = $totalRecs;
}

// set the last record to display
$stopRec = $startRec + $displayRecs - 1;
$recCount = $startRec - 1;

// move to the first record
@mysql_data_seek($rs, $recCount);
$recActual = 0;
while (($row = @mysql_fetch_array($rs)) && ($recCount < $stopRec)) {
	$recCount++;	
	if ($recCount >= $startRec)	{
		$recActual++;	
		$bgcolor = "#FFFFFF"; // set row color
		if (($recCount % 2) <> 0)	{ // display alternate color for rows
			$bgcolor = "#F5F5F5";
		}

		// load key for record
		$key = @$row["value_id"];
		$x_value = @$row["value"];
		$x_value_id = @$row["value_id"];
?>
    <tr class="mainTableAlt"> 
      <td width="23" align="center">
        <input type="checkbox" name="key[]" value="<?php echo $key; ?>">
        </td>
      <td width="30" align="center"><a href="<?php echo (!is_null(@$row["value_id"])) ? "admin.php?a=banlist_edit&key=".urlencode($row["value_id"]) : "javascript:alert('Invalid Record! Key is null');";	?>
">Edit</a></td>
      <td width="41" align="center"><a href="<?php echo (!is_null(@$row["value_id"])) ? "admin.php?a=banlist_add&key=".urlencode($row["value_id"]) : "javascript:alert('Invalid Record! Key is null');";	?>
">Copy</a></td>
      <td>
        &nbsp;<?php echo $x_value; ?>
        &nbsp;</td>
    </tr>
    <?php
	}
}
?>
  </table>
<?php
if ($recActual > 0) {
?>
<br><input class="inputsubmit" type="button" name="btndelete" value="Delete Selected" onClick="this.form.action='admin.php?a=banlist_delete&';this.form.submit();"></p>
<?php
}
?>
</form>
<?php

// close connection
@mysql_free_result($rs);
mysql_close($conn);
?>
<?php

// display page numbers
if ($totalRecs > 0) {
	$rsEof = ($totalRecs < ($startRec + $displayRecs));

	// find out if there should be backward or forward Buttons on the table
	if ($startRec == 1)	{
		$isPrev = False;
	} else	{
		$isPrev = True;
		$PrevStart = $startRec - $displayRecs;
		if ($PrevStart < 1) {
			$PrevStart = 1;
		}
?>	
	<a href="admin.php?a=banlist&start=<?php echo $PrevStart; ?>"><b>Prev</b></a>
<?php
	}
	if ($isPrev || $totalRecs != 0) {
		$x = 1;
		$y = 1;	
		$dx1 = intval(($startRec-1)/($displayRecs*$recRange))*$displayRecs*$recRange+1;
		$dy1 = intval(($startRec-1)/($displayRecs*$recRange))*$recRange+1;
		if (($dx1+$displayRecs*$recRange-1) > $totalRecs ) {
			$dx2 = intval($totalRecs/$displayRecs)*$displayRecs+1;
			$dy2 = intval($totalRecs/$displayRecs)+1;
		} else {
			$dx2 = $dx1+$displayRecs*$recRange-1;
			$dy2 = $dy1+$recRange-1;
		}
		while ($x <= $totalRecs) {
			if ($x >= $dx1 && $x <= $dx2) {
				if ($startRec == $x) {
?>
	<b><?php echo $y; ?></b>
<?php
				} else {
?>
	<a href="admin.php?a=banlist&start=<?php echo $x; ?>"><b><?php echo $y; ?></b></A>
<?php	
				}
				$x = $x + $displayRecs;
				$y = $y + 1;
			} elseif ($x >= ($dx1-$displayRecs*$recRange) && $x <= ($dx2+$displayRecs*$recRange)) {
				if ($x+$recRange*$displayRecs < $totalRecs) {
?>
	<a href="admin.php?a=banlist&start=<?php echo $x;?>"><b><?php echo $y; ?>-<?php echo $y+$recRange-1; ?></b></a>
<?php 
				} else {
					$ny = intval(($totalRecs-1)/$displayRecs) + 1;
					if ($ny == $y) {
?>
	<a href="admin.php?a=banlist&start=<?php echo $x; ?>"><b><?php echo $y; ?></b></a>
<?php 
					} else {
?>
	<a href="admin.php?a=banlist&start=<?php echo $x; ?>"><b><?php echo $y; ?>-<?php echo $ny; ?></b></a>
<?php	
					}
				}
				$x = $x + $recRange*$displayRecs;
				$y = $y + $recRange;
			} else {
				$x = $x + $recRange*$displayRecs;
				$y = $y + $recRange;
			}
		}
	}

	// next link
  if ($totalRecs >= $startRec + $displayRecs) {
		$NextStart = $startRec + $displayRecs;
		$isMore = True
?>
	<a href="admin.php?a=banlist&start=<?php echo $NextStart; ?>"><b>Next</b></a>
<?php 
	} else {
		$isMore = False;
	}	
?>
	
<?php 
	if ($startRec > $totalRecs) {
		$startRec = $totalRecs;
	}
	$stopRec = $startRec + $displayRecs - 1;
	$recCount = $totalRecs - 1;
	if ($rsEof) {
		$recCount = $totalRecs;
	}
	if ($stopRec > $recCount) {
		$stopRec = $recCount;
	}
?>
	&nbsp;(Records <?php echo $startRec;  ?> to <?php echo $stopRec; ?> of <?php echo $totalRecs; ?>)
<?php 
} else {
?>
	No records found
<?php 
}
?>
<br>
<!-- start Javascript
function  EW_checkMyForm(EW_this) {
if (EW_this.x_value && !EW_hasValue(EW_this.x_value, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_value, "TEXT", "Please Enter Text"))
                return false; 
        }
return true;
}

// end JavaScript -->
</script>
</td>
<td><img src="images/spacer.gif" width="10" height="1"></td>
</td><td valign="top">

<form onSubmit="return EW_checkMyForm(this);"  action="admin.php" method="post">
<p>
<input type="hidden" name="a" value="banlist_add">
<input type="hidden" name="ab" value="A">
  <table border="0" cellspacing="1" cellpadding="2" class="TableMsg">
    <tr> 
      <td class="TableHeaderText">&nbsp;Add to Ban List</td>
		</tr><tr>
      <td class="mainTable">
  <table border="0" cellspacing="0" cellpadding="3">
    <tr> 
      <td><input type="text" name="x_value" size="30" maxlength="255" value=""></td>
	</tr><tr>
	  <td><input class="inputsubmit" type="submit" name="Action" value="Add"></td>
    </tr>
  </table></td>
    </tr>
  </table>
</form>
</td></tr></table>