<form name="entryform" method="post" action="<?=$ME?>">
<table>
<tr>
	<td class="label">Name:</td>
	<td><input type="text" name="name" size="25" value="<? pv($frm["name"]) ?>">
		<?err($errors->firstName)?>
	</td>
</tr>
<tr>
	<td class="label">User Name:</td>
	<td><input type="text" name="username" size="25" value="<? pv($frm["username"]) ?>">
		<?err($errors->username)?>
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
	<td><input type="submit" value="Edit"></td>
</tr>
</table>
</form>
