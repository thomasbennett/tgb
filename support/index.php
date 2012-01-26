<? 
	session_start();
	@header("Cache-control: private");
	include("class.ticket.php");
	include("config.php");
	include("$include_dir/header.php"); 
?> 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr> 
    <td width="350" valign="top"> 
      <? include("$include_dir/form.php"); ?>
    </td>
    <td valign="top"> 
      <table cellspacing="0" cellpadding="0" border="0">
        <tr> 
          <td>If you want to view the status of a ticket, provide us with your 
            login details below. If this is your first time contacting us, please 
            use the form on the left to open a new ticket.</td>
        </tr>
        <tr> 
          <td align="center"><br>
            <table cellspacing="0" cellpadding="8" border="0" class="tableheader">
              <tr> 
                <td bgcolor="#ffffff"> 
                  <table cellspacing="0" cellpadding="3" border="0">
                    <form action="view.php" method="post">
                      <tr> 
                        <td>E-Mail:</td>
                        <td> 
                          <input class="inputform" type="text" name="login_email" size="20" value="<?=$e?>">
                        </td>
                      </tr>
                      <tr> 
                        <td>Ticket Number:</td>
                        <td> 
                          <input class="inputform" type="text" name="login_ticket" size="10" value="<?=$t?>">
                        </td>
                      </tr>
                      <tr> 
                        <td> 
                          <input class="inputsubmit" type="submit" value="View Status">
                        </td>
                        <td>&nbsp;</td>
                      </tr>
                    </form>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<? 
	include("$include_dir/footer.php"); 
?>
