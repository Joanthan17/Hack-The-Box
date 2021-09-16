<br><br>
<table class = "main_table" id = "main" width = "100%" border="0" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th title="" width="6%"></th>
<th title=""><div align="center">Weight</div></th>

<th title="">Category Name</th>
<th title="" width="20%"><div align="center">Category ID</div></th>
<th title=""><div align="center">Remove</div></th>
</tr>
</thead>

<tbody>
<?
while ($r = db_fetch_object($qid))
{
?>
<tr>

	<td><a href="<?=$CFG->wwwroot?>/torrents.php?mode=category&amp;cat=<?= pv($r->id);?>"><img src="../images/folder.png" width="38" height="28" border="0"></a></td>
	<td><div align="center"><?= pv($r->weight);?></div></td>
	<td><a href="<?=$CFG->wwwroot?>/torrents.php?mode=category&amp;cat=<?= pv($r->id);?>"><?= pv($r->name);?></a></td>
	<td><div align="center"><?= pv($r->id);?></div></td>
	<td><div align="center"><a href="<?=$CFG->wwwroot?>/admin/index.php?mode=removecat&amp;cat=<?= pv($r->id);?>">Remove</a></div></td>
</tr>
<?
}
?>
</tbody>
</table>