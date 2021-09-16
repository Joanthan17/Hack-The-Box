
<table class = "main_table" id = "main" width = "100%" border="0" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th title="click to sort by Privilege">IP</th>
<th title="click to sort by Username">Date</th>
<th title="Ban IP">Ban IP</th>
</tr>
</thead>

<tbody>
<?
while ($r = db_fetch_object($qid))
{
?>
<tr>
	<td><?= pv($r->ip);?></td>
	<td><?= pv($r->date);?></td>
	<td>
	<a href="<?=$CFG->wwwroot?>/admin/index.php?mode=ban_ip&amp;id=<?= pv($r->ip)?>">Ban IP</a>
	</td>

</tr>
<?
}
?>
</tbody>
</table>

