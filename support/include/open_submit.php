<font color="red"><b>
<?=$err?>
</b></font> 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr> 
    <td> 
      <table cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td><img src="images/spacer.gif" width="1" height="3"></td>
        </tr>
      </table>
      <table>
        <tr>
          <td align="center"><font color=red><?=$warn;?></font></td>
        </tr>
        <tr>
          <td> 
      </table>
      <table width="100%" cellspacing="1" cellpadding="10" border="0" class="TableMsg">
        <tr> 
          <td bgcolor="#ffffff"> A support ticket has been created and a representative 
            will be getting back to you shortly. An email with the ticket id has been sent to 
			<b><?=$email?></b>. You'll need the ticket id along with your email to login and to view status of your ticket(s). 
            <p> Support Team 
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<tr> 
  <td align="center">
    <div align="center">View Ticket Status</div>
    <p> 
    <table cellspacing="1" cellpadding="5" border="0" bgcolor="#000000">
      <form action="view.php" method="post">
        <input type="hidden" name="a" value="vticket">
        <tr> 
          <td bgcolor="#EEEEEE">E-Mail:</td>
          <td bgcolor="#EEEEEE">
            <input type="text" name="login_email" size="20" value="">
          </td>
          <td bgcolor="#EEEEEE">Ticket Number:</td>
          <td bgcolor="#EEEEEE">
            <input type="text" name="login_ticket" size="10" value="">
          </td>
          <td bgcolor="#EEEEEE">
            <input class="inputsubmit" type="submit" value="View Status">
          </td>
        </tr>
      </form>
    </table>
    <br>
