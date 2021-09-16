<style>
.h1      { font-family: Arial, sans-serif; font-size: 14pt; font-weight: bold; }
.label   { font-family: Arial, sans-serif; font-size: 10pt; font-weight: bold; }
.normal  { font-family: Arial, sans-serif; font-size: 10pt; }
.warning { font-family: Arial, sans-serif; font-size: 12pt; font-weight: bold; color: #ff0000; }
</style>

<p>
<table cellpadding="20" width="100%">
<tr valign="top">


	<td>
	<? if (! empty($errormsg)) { ?>
		<div class="warning" align="center"><? pv($errormsg) ?></div>
	<? } ?>

	<form name="entryform" method="post" action="<?=$CFG->wwwroot?>/login.php">
	<table width="500">
	<tr width="100%">
		<td class="label" width="70">Subject:</td>
		<td><input type="text" name="subject" size="30" value="<? pv($frm["username"]) ?>"></td>
	</tr>
	<tr width="100%" width="50">
		<td class="label" valign="top">Problem:</td>
		<td><textarea name="report" rows="4" cols="50"></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="Submit">
		</td>
	</tr>
	</table>
	</form>
	</td>
</tr>
</table>

</body>
</html>
