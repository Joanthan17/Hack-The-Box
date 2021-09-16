<div id="news">
<table>
<tbody>

<form name="insert_news" method="post" action="index.php?mode=insertit_news">
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

<tr><td></td>
      <td><input class="form_button" name="submit" type=submit value="Submit"></td>
</tr>
</form>
</tbody>
</table>
</div>
