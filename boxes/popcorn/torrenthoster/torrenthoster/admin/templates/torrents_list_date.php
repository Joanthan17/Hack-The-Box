
<table class = "main_table" id = "main" width = "100%" border="0" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th title="click to sort by Category">Added</th>
<th title="click to sort by name">Filename</th>
<th title="click to sort by size">Size</th>
<th title="click to sort by seeds">Seeds</th>
<th title="click to sort by downloaders">Peers</th>
<th title="Delete">Delete</th>
</tr>
</thead>

<tbody>
<?
while ($r = db_fetch_object($qid))
{
?>
<tr>
	<td>
		<a href="index.php?mode=added&amp;cat=<?= $r->added ?>"><?= pv($r->added);?></a>
	</td>
	<td>
		<a href="index.php?mode=edit&amp;id=<?= pv($r->hash);?>"><?= pv($r->filename);?></a>
	</td>
	<td align = "center">
		<?= makesize($r->size);?>
	</td>
	<td <?if ($r->seeds == 0) {?>class="r"><?}else{?> class="g"><?}?><?= $r->seeds ?></td>
	<td	<?if ($r->leechers == 0) {?>class="r"><?}else{?> class="b"><?}?><?= $r->leechers ?></td>
	<td>
	<a href="<?=$CFG->wwwroot?>/admin/index.php?mode=delete&amp;id=<?= pv($r->hash)?>">Delete</a>
	</td>


</tr>
<?
}
?>
</tbody>
</table>

