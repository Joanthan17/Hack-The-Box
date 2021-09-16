
<div>
<table class="main_table" width="100%">
  <tbody>
<th>Title</th>
<th>Date</th>
<th>Author</th>
<th>Edit</th>
<th>Delete</th>
<?
while ($r = db_fetch_object($qid))
{
  ?>
  <tr>
  <td><?= $r->title?></td>
  <td><?= $r->date?></td>
  <td><?= $r->author ?></a></td>
  <td><a href="<?=$CFG->wwwroot?>/admin/index.php?mode=editnews&amp;id=<?= $r->id ?>">Edit</a></td>
  <td><a href="<?=$CFG->wwwroot?>/admin/index.php?mode=deletenews&amp;id=<?= $r->id ?>">Delete</a></td>
  </tr>
  <?
}
?>
</tbody>
</table>
</div>
