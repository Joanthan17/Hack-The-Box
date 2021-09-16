<style>
.h1      { font-family: Arial, sans-serif; font-size: 14pt; font-weight: bold; }
.label   { font-family: Arial, sans-serif; font-size: 10pt; font-weight: bold; }
.normal  { font-family: Arial, sans-serif; font-size: 10pt; }
.warning { font-family: Arial, sans-serif; font-size: 12pt; font-weight: bold; color: #ff0000; }
</style>

<p>
<table cellpadding="20">
<tr valign="top">
	<td width="300" class="normal">
	<p>If you do not already have an account, please
	<a href="<?=$CFG->wwwroot?>/users/index.php?mode=register">&nbsp;click here </a> to sign up for an account now.

	<p>If you have an account but you have forgotten your password,
	<a href="<?=$CFG->wwwroot?>/users/forgot_password.php">click here</a> to recover
	your password.

	<p>If you have do not wish to login yet,
	<a href="<?=$CFG->wwwroot?>">click here</a> to return to the home page.
	</td>

	<td bgcolor="#f0f0f0">
	<? if (! empty($errormsg)) { ?>
		<div class="warning" align="center"><? pv($errormsg) ?></div>
	<? } ?>

	<form name="entryform" method="post" action="<?=$CFG->wwwroot?>/login.php">
	<table>
	<tr>
		<td class="label">Username:</td>
		<td><input type="text" name="username" size="20" value="<? pv($frm["username"]) ?>"></td>
	</tr>
	<tr>
		<td class="label">Password:</td>
		<td><input type="password" name="password" size="20"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="Login">
			<input type="button" value="Cancel" onClick="javascript: history.go(-1)">
			<p class="normal">
			  <a href="<?=$CFG->wwwroot?>/users/index.php?mode=register">Sign up for an account</a>
			| <a href="<?=$CFG->wwwroot?>/users/forgot_password.php">Forgot my password</a>
		</td>
	</tr>
	</table>
	</form>
	</td>
</tr>
</table>

</body>
</html>
