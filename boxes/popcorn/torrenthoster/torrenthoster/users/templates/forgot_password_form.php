<div class="h1"><br/><?= $CFG->webname ?> Password Recovery<hr size="1"></div>

<p>
<table cellpadding="20">
<tr valign="top">
<td width="300" class="normal">
	<p>Enter in your email address to recover your password.  When you submit
	this request, your password will be reset, and a new password will be sent
	to you via email.

	<p>If you do not want to do this, you can return to the
	<a href="<?=$CFG->wwwroot?>/login.php">login screen</a> or the
	<a href="<?=$CFG->wwwroot?>">home page</a> now.
</td>

<td bgcolor="#f0f0f0">
	<? if (! empty($errormsg)) { ?>
		<div class=warning align=center><? pv($errormsg) ?></div>
	<? } ?>

	<form name="entryform" method="post" action="<?=$ME?>">
	<table>
	<tr>
		<td class="label">Email Address:</td>
		<td><input type="text" name="email" size="25" value="<? pv($frm["email"]) ?>"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="Submit">
			<input type="button" value="Cancel" onClick="javascript: history.go(-1)">
			<p class="normal">
			  <a href="<?=$CFG->wwwroot?>/login.php">Login Screen</a>
			| <a href="<?=$CFG->wwwroot?>">Home Page</a>
		</td>
	</tr>
	</table>
	</form>
</td>
</tr>
</table>

