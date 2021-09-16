
<table class = "main_table" id = "main" width = "100%" border="0" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th title="click to sort by Username">IP</th>
<th title="click to sort by Email">Reason</th>
<th title="Delete">Remove</th>
</tr>
</thead>

<tbody>
<?
while ($r = db_fetch_object($qid))
{
?>
<tr>

	<td><?= pv($r->ip);?></td>
	<td><?= pv($r->reason);?></td>
	<td>
	<a href="<?=$CFG->wwwroot?>/admin/index.php?mode=remove_ban&amp;id=<?= pv($r->ip)?>">Remove</a>
	</td>


</tr>
<?
}
?>
</tbody>
</table>

