<?
while ($r = db_fetch_object($qid))
{
?>

<div>

<h1><?= pv($r->filename) ?></h1>
<table width="100%" border="0" class="infotable">
  <tr>
    <td>Download</td>
    <td><a href="<?=$CFG->wwwroot?>/torrents.php?mode=download&amp;id=<?= pv($r->hash)?>"><?= pv($r->filename) ?></a> </td>
  </tr>
  <tr>
	<td>Edit
	</td>
	<td><a href="<?=$CFG->wwwroot?>/admin/index.php?mode=edit&amp;id=<?= pv($r->hash)?>"><?= pv($r->filename) ?></a> </td>
</tr>

  <tr>
    <td>Category</td>
    <td><?= pv($r->cname) ?></td>
  </tr>
  <tr>
    <td>Size</td>
    <td><?= makesize($r->size) ?></td>
  </tr>
<tr>
    <td>Seeds</td>
    <td><div class="r"><?= $r->seeds ?></div></td>
  </tr>
  <tr>
    <td>Peers</td>
    <td><div class="b"><?= $r->leechers ?></div></td>
  </tr>
    <tr>
    <td>Finished</td>
    <td><div class="g"><?= pv($r->finished) ?></div></td>
  </tr>
<tr>
    <td>Tracked By</td>
    <td><?= pv($r->announce) ?></td>
  </tr>
    <tr>
    <td>Added</td>
    <td><?= pv($r->data) ?></td>
  </tr>
  <tr>
    <td>Last Update</td>
    <td><?= pv($r->lastupdate) ?></td>
  </tr>
  <tr>
    <td>Comment</td>
    <td><?= pv($r->comment) ?></td>
  </tr>
</table>
</div>
<?
}
?>
