<div id="">
<table>
<tbody>
<br><br><br><br>
<form name="insert_cat" method="post" action="index.php?mode=add_catit">
<tr>
<td>Category Name</td>
  <td>
  <input type="text" name="name" size="25" value="<?= pv($r->name) ?>"/><td>
  </tr>
  <br>
<td>Weight</td>
  <td>
  <input type="text" name="weight" size="25" value="<?= pv($r->weight) ?>"/><td>
  </tr>
<tr>

<td>

</td>
      <td><input class="form_button" name="submit" type=submit value="Submit"></td>
</tr>
</form>
</tbody>
</table>
</div>
