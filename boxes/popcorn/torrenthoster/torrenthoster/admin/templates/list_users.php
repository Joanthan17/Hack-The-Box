<br>
<table class = "main_table" id = "main" width = "100%" border="0" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th title="click to sort by Username">Username</th>
<th title="click to sort by Email">Email</th>
<th title="click to sort by Privilege">Privilege</th>
<!-- th title="click to sort by Joined Date">Joined Date</th -->
<th title="click to sort by Last Connect">Last Connect</th>
<th title="Delete">Delete</th>
</tr>
</thead>

<tbody>
<?
while ($r = db_fetch_object($qid))
{
?>
<tr>

	<td><?= pv($r->userName);?></td>
	<td><?= pv($r->Email);?></td>
	<td><?= pv($r->Privilege);?></td>
	<!-- td><?= pv($r->joined);?></td -->
	<td><?= pv($r->lastconnect);?></td>
	<td>
	<a href="<?=$CFG->wwwroot?>/admin/index.php?mode=deleteuser&amp;id=<?= pv($r->id)?>">Delete</a>
	</td>


</tr>
<?
}
?>
</tbody>
</table>

