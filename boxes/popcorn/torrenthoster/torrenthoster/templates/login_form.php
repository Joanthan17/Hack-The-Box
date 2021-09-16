<style>
.h1      { font-family: Arial, sans-serif; font-size: 14pt; font-weight: bold; }
.label   { font-family: Arial, sans-serif; font-size: 10pt; font-weight: bold; }
.normal  { font-family: Arial, sans-serif; font-size: 10pt; }
.warning { font-family: Arial, sans-serif; font-size: 12pt; font-weight: bold; color: #ff0000; }
</style>

<p>
<table cellpadding="20" align="center" width="100%">
<tr><td colspan="2" align="center"><h1><b><font color="#3589E3">Login</font></b></h1></td>
</tr>
<tr valign="top">
<td align="right">
<img src="images/green mark.jpg" border="0">
</td>

	<td>
	<? if (! empty($errormsg)) { ?>
		<div class="warning" align="center"><? pv($errormsg) ?></div>
	<? } ?>

	<form name="entryform" method="post" action="<?=$CFG->wwwroot?>/login.php">
	<table>
	<tr>
		<td class=""><font color="#333333">Username:</font></td>
		<td><input type="text" name="username" style="font-size:1.25em" size="21" value="<? pv($frm["username"]) ?>"></td>
	</tr>
	<tr>
		<td class=""><font color="#333333">Password:</font></td>
		<td><input type="password" name="password" style="font-size:1.25em" size="21"></td>
	</tr>
	<tr>
		<td></td>
		<td><input class="button" type="submit" value="Login">
			<br><br><div class="normal">
			  <a href="<?=$CFG->wwwroot?>/users/index.php?mode=register" style="text-decoration: none;">Sign up</a>
			| <a href="<?=$CFG->wwwroot?>/users/forgot_password.php" style="text-decoration: none;">Lost password</a></div>
		</td>
	</tr>
	</table>
	</form>
	</td>
</tr>
</table>
<table cellpadding="20" align="center" width="100%">
<tr>
<td>

</td>
</tr>
</table>
</body>
</html>
