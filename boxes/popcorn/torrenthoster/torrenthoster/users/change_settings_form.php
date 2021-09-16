<form name="entryform" method="post" action="<?=$ME?>">
<table>
<tr>
	<td class="label">Firstname:</td>
	<td><input type="text" name="firstName" size="25" value="<? pv($frm["firstName"]) ?>">
		<?err($errors->firstName)?>
	</td>
</tr>
<tr>
	<td class="label">Lastname:</td>
	<td><input type="text" name="lastName" size="25" value="<? pv($frm["url"]) ?>">
		<?err($errors->lastName)?>
	</td>
</tr>
<tr>
	<td class="label">Email:</td>
	<td><input type="text" name="email" size="25" value="<? pv($frm["email"]) ?>">
		<?err($errors->email)?>
	</td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr>
	<td></td>
	<td><input type="submit" value="Register"></td>
</tr>
</table>
</form>
