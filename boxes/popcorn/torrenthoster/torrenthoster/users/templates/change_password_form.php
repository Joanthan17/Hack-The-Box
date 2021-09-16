<form name="entryform" method="post" action="<?=$ME?>?mode=changepassword">
<table>
<tr>
	<td class="label">Old Password:</td>
	<td><input type="password" name="oldpassword" size="25">
		<?err($errors->oldpassword)?>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td class="label">New Password:</td>
	<td><input type="password" name="newpassword" size="25">
		<?err($errors->newpassword)?>
	</td>
</tr>
<tr>
	<td class="label">Confirm Password:</td>
	<td><input type="password" name="newpassword2" size="25">
		<?err($errors->newpassword2)?>
	</td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" value="Change Password">
		<input type="reset" value="Reset">
	</td>
</tr>
</table>
</form>
