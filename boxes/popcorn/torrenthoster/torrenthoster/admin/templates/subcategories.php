<table class="main_table" id="main" width = "100%" cellpadding="0" cellspacing="0"border="0">
<tr>
<th>Subcategories</th>
</tr>

<?
while ($r = db_fetch_object($qid))
{
?>

<tr>
<td><a href="index.php?mode=subcategory&amp;sub=<?= $r->id ?>"><?= $r->name ?></a></td>
</tr>
<?
}
?>
</table>
