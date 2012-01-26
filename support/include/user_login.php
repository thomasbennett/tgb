<table width="100%" cellspacing="0" cellpadding="5" border="0">
  <?
if ($err) {
    ?>
  <tr> 
    <td class="error">You've entered an invalid email/ticket combination. Please 
      try again.</td>
  </tr>
  <?
}
?>
  <tr> 
    <td>Please login:</td>
  </tr>
  <tr> 
    <td align="center"> 
      <table cellspacing="1" cellpadding="5" border="0" bgcolor="#000000">
        <form action="view.php" method="post">
          <tr> 
            <td bgcolor="#EEEEEE">E-Mail:</td>
            <td bgcolor="#EEEEEE">
              <input class="inputform" type="text" name="login_email" size="20" value="<?=$e?>">
            </td>
            <td bgcolor="#EEEEEE">Ticket Number:</td>
            <td bgcolor="#EEEEEE">
              <input class="inputform" type="text" name="login_ticket" size="10" value="<?=$t?>">
            </td>
            <td bgcolor="#EEEEEE">
              <input class="inputsubmit" type="submit" value="View Status">
            </td>
          </tr>
        </form>
      </table>
    </td>
  </tr>
</table>
<br>