<div id="news">
<table>
<tbody>
<?
while ($r = db_fetch_object($qid))
{
  
  ?>
<form name="editit_news" method="post" action="index.php?mode=editit_news">
<tr>
<td>Title</td>
  <td>
  <input type="text" name="title" size="50" value="<?= pv($r->title) ?>"/><td>
  </tr>
<tr>
  <td>
  Content
  </td>

  <td>
  <textarea name="content" rows="7" cols="50"><?= pv($r->content) ?></textarea>
  </td>
</tr>

<tr>
  <td>
  Date
  </td>
<td>
  <input type="text" name="date" size="6" value="<?= $r->date?>"/>(DD/MM/YY)</td>
</tr>  

<tr>
<td>Author</td>
<td>
  <input type="hidden" name="id" value="<?= pv($r->id) ?>" /> 
  <input type="text" name="author" size="15" value="<?= pv($r->author) ?>"/>
  <td>
</tr>
<tr><td></td>
      <td><input class="form_button" name="submit" type=submit value="Update"></td>
</tr>
</form>
  <?
}
?>
</tbody>
</table>
</div>
