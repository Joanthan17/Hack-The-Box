
<form name="form1" method="post" action="<?=$ME?>?mode=register">
<table width="100%">
<tr><td width="100%" class="normal">
<div class="normal">
<img src="<?=$CFG->imagedir?>/register user.gif" border="0">
Please fill out the registration form, note that all fields are required.<br>
</div>
</td>
</tr>
<tr>
	<td colspan="2"><div id="dotted"></div></td>
</tr>
<tr>
<td>
<table width="100%">
<tr>
	<td width="130" class="label">Username:</td>
	<td align="left"><input type="text" name="username" size="25" value="<? pv($frm["username"]) ?>">
		<?err($errors->username)?>
	</td>
</tr>


<tr>
	<td width="130" class="label">Password:</td>
	<td><input type="password" name="password" size="25">
		<?err($errors->password)?>
	</td>
</tr>
<tr>
	<td width="130" class="label">Password:(confirm)</td>
	<td><input type="password" name="password2" size="25">
		<?err($errors->password)?>
	</td>
</tr>

<tr>
	<td width="130" class="label">Email:</td>
	<td><input type="text" name="email" size="25" value="<? pv($frm["email"]) ?>">
		<?err($errors->email)?>
	</td>
</tr>

<tr>
	<td width="130" class="label">Enter Code:</td>
	<td><img src="php_captcha.php">
	<br>
	<input name="number" type="text" id=\&quot;number\&quot;>
	<?err($errors->code)?>
	</td>
</tr>

<tr>
	<td colspan="2"><div id="dotted"></div></td>
</tr>
<tr>
	<td colspan="2" align="left"><input type="submit" value="Register"/></td>
</tr>
</table>
</td></tr>
</table>
</form>

