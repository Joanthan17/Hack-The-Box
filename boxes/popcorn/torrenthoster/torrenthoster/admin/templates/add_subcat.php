<div id="">
<table>
<tbody>
<br><br><br><br>
<form name="insert_cat" method="post" action="index.php?mode=add_subcatit">
<tr>
<td>Subcategory Name</td>
  <td>
  <input type="text" name="subname" size="50" value="<?= pv($r->subname) ?>"/><td>
  </tr>

  <tr>
<td>Category</td>
    <td><select name="cat">
	<option value="0">(Choose)</option>
<?php
$result = mysql_query("SELECT id, name FROM categories ORDER BY id ASC ") or sqlerr();
while ($row = mysql_fetch_assoc($result))
{

echo "<option value=\"";
echo $row['id'];
echo "\">";
echo $row['name'];
echo "</option>";
}
?>
      </select>
</tr>
<tr><td></td>
      <td><input class="form_button" name="submit" type=submit value="Submit"></td>
</tr>
</form>
</tbody>
</table>
</div>
