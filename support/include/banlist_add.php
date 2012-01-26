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
<script language="JavaScript" src="ew.js"></script>
<script language="JavaScript">
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
<img src="images/spacer.gif" width="1" height="10"><br>
<form onSubmit="return EW_checkMyForm(this);"  action="admin.php" method="post">
<input type="hidden" name="a" value="banlist_add">
<input type="hidden" name="ab" value="A">
  <table border="0" cellspacing="0" cellpadding="4">
    <tr> 
      <td><b>Add/Copy Banned:</b></td>
      <td><font size="-1">
        <input type="text" name="x_value" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_value); ?>"></td>
		<td><input class="inputsubmit" type="submit" name="Action" value="Submit"></td>
    </tr>
  </table>
</form>
<a href="admin.php?a=banlist">Back to List</font></a>