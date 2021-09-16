
<a href = "javascript:history.back()" style="text-decoration: none;"><img src="<?=$CFG->imagedir?>/back.gif" width="49" height="20" border="0"></a> <br><br>

<table class="main_table" id="main" width = "100%" border="0" cellpadding="0" cellspacing="0">

<tr height="2">

 <tr height="25">

  <td background="<?=$CFG->imagedir?>/orange bg.jpg">
 <font color="white" style="font-size:11pt;"><b></b></font>
   </td>

   <td background="<?=$CFG->imagedir?>/orange bg.jpg">
   <font color="white" style="font-size:11pt;"><b></b>Date</font>
   </td>

   <td background="<?=$CFG->imagedir?>/orange bg.jpg">
 <font color="white" style="font-size:11pt;"><b>Filename</b></font>
   </td>

   <td background="<?=$CFG->imagedir?>/orange bg.jpg">
 <font color="white" style="font-size:11pt;"><b>Peers</b></font>
   </td>

   <td background="<?=$CFG->imagedir?>/orange bg.jpg">
 <font color="white" style="font-size:11pt;"><b>Size</b></font>
   </td>

   <td background="<?=$CFG->imagedir?>/orange bg.jpg">
 <font color="white" style="font-size:11pt;"><b>Subcategories</b></font>
   </td>

</tr>
<tr>
<?
while ($r = db_fetch_object($qid))
{
?>

<td>
	<a href="<?=$CFG->wwwroot?>/torrents.php?mode=details&amp;id=<?= pv($r->hash);?>"><div align="center"><img src="<?=$CFG->imagedir?>/details.png" width="16" height="16" border="0"></div></a>
	</td>
<td>
		<a href="<?=$CFG->wwwroot?>/torrents.php?mode=added&amp;cat=<?= $r->added ?>"><?= pv($r->added);?></a>
	</td>
	<td><? if ($r->added == 'true'){?><a href="<?=$CFG->wwwroot?>/index.php?mode=faq"><img class="reg" alt="Tracker Requires Registration" src="<?=$CFG->imagedir;?>/reg.gif"/></a><?}?>
		<a href="<?=$CFG->wwwroot?>/torrents.php?mode=details&amp;id=<?= pv($r->hash);?>"><?= pv($r->filename);?></a>
	</td>
	<td	<?if ($r->seeds == 0) {?>class="r"><?}else{?> class="g"><?}?><?= $r->seeds ?>/<?= $r->leechers ?></td>
	<td align = "center">
		<?= makesize($r->size);?>
	</td>

	<td><?= $r->subname ?></td>

</tr>
<?
}
?>
</tr>
</table>
<br><a href = "javascript:history.back()" style="text-decoration: none;"><img src="<?=$CFG->imagedir?>/back.gif" width="49" height="20" border="0"></a>

