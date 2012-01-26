<table width="100%" cellspacing="0" cellpadding="5" border="0">
<?
if ($login_err) {
    ?>
    <tr>
        <td class="error">You've entered an invalid username/password combination. Please try again.</td>
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
        <form action="admin.php" method="post">
        <tr>
            <td bgcolor="#EEEEEE">Username:</td><td bgcolor="#EEEEEE"><input class="inputform" type="text" name="login_user" size="20" value="<?=$em?>"></td>
            <td bgcolor="#EEEEEE">Password:</td><td bgcolor="#EEEEEE"><input class="inputform" type="password" name="login_pass" size="10" value="<?=$tt?>"></td>
            <td bgcolor="#EEEEEE"><input class="inputsubmit" type="submit" name="submit" value="Log In"></td>
        </tr>
        </form>
        </table>
    </td>
</tr>
</table>
<br>
