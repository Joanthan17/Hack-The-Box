<h1>Welcome <? pv($frm["firstName"]) ?></h1>
<p class="normal">
Thank you for registering to <?= $CFG->webname ?>  Your account information is:
</p>

<blockquote>
<table>
<tr>
	<td class="normal">Username:</td>
	<td class="normal"><b><? pv($frm["username"]) ?></b></td>
</tr>
<tr>
	<td class="normal">Password:</td>
	<td class="normal"><b><? pv($frm["password"]) ?></b></td>
</tr>
</table>
</blockquote>

<p class="normal">
Please write these down in a safe place and please do not give your password
to anyone. There will be a method to reset it if you forget it on the login
page.
</p>

<p class="normal">
To continue using the system, please <a href="<?=$CFG->wwwroot?>/login.php">login</a> now.
</p>
