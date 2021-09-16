

<table class = "main_table" id = "" width = "100%" border="0" cellpadding="0" cellspacing="0">
<?
while ($r = db_fetch_object($qid))
{
?>

<tr>

<td colspan="6"><a href="<?=$CFG->wwwroot?>/torrents.php?mode=category&amp;cat=<?= pv($r->id);?>" style="text-decoration: none;"><h2><b><?= pv($r->name);?></b></h2></a></td>

</tr>


<tr height="25">

 <td background="./images/orange bg.jpg">
<font color="white" style="font-size:11pt;"><b>Date</b></font>
  </td>

  <td background="./images/orange bg.jpg">
  <font color="white" style="font-size:11pt;"><b>Filename</b></font>
  </td>

  <td background="./images/orange bg.jpg">
<font color="white" style="font-size:11pt;"><b>DL</b></font>
  </td>

  <td background="./images/orange bg.jpg">
<font color="white" style="font-size:11pt;"><b>Peers</b></font>
  </td>

  <td background="./images/orange bg.jpg">
<font color="white" style="font-size:11pt;"><b>Size</b></font>
  </td>

  <td background="./images/orange bg.jpg">
<font color="white" style="font-size:11pt;"><b>Subcategories</b></font>
  </td>

</tr>

<? $qid2= db_query("SELECT DISTINCT subcategories.name as subname, subcategories.id as subid, namemap.size as size, namemap.info_hash as hash, namemap.seeds as seeds, namemap.leechers as leechers, namemap.filename2 as filename, DATE_FORMAT(namemap.data,'%Y-%m-%d') as date
FROM namemap, categories, subcategories WHERE namemap.category = $r->id AND namemap.subcategory = subcategories.id LIMIT 10"); ?>

<?
while ($r = db_fetch_object($qid2))
{
?>
<tr height="" align="left">
<td width="80"><?= $r->date ?></td>

<td align="left" width="300">
<a href="torrents.php?mode=details&amp;id=<?= pv($r->hash);?>"><?= pv($r->filename);?></a>
</td>

<td>
<a href="torrents.php?mode=download&amp;id=<?= pv($r->hash)?>"><img alt="Download Torrent" width="19" height="16" border="0" src="<?=$CFG->imagedir?>/download.png"></a>
</td>

<td <?if ($r->seeds == 0) {?>class="r"><?}else{?> class="g"><?}?><?= $r->seeds ?>/<?= $r->leechers ?></td>

<td align = "left">
<?= makesize($r->size);?>
</td>

<td><a href="<?=$CFG->wwwroot?>/torrents.php?mode=subcategory&amp;sub=<?= pv($r->subid);?>" style="text-decoration: none;"><?= $r->subname ?></a></td>
</tr>

<?
}
?>
<tr><td>
<br><br>
</td></tr>

<?
}
?>

</table>
