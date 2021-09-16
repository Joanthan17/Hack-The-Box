<?
// div colors
$color1 = 'class="light"';
$color2 = 'class="dark"';
$row_count = 0; ?>

<?
while ($r = db_fetch_object($qid))
{
?>
<?= $r->name ?>
 <tr>
 <td><? if ($r->reg == 'true'){?><a href="<?=$CFG->wwwroot?>/index.php?mode=faq"><img class="reg" alt="Tracker Requires Registration" src="<?=$CFG->imagedir;?>/reg.gif"/></a><?}?>
	      <a href="torrents.php?mode=details&amp;id=<?= pv($r->hash);?>"><?= pv($r->filename2);?></a>
  </td>

  <td align = "center">
  <?= makesize($r->size);?>
  </td>
<td <?if ($r->seeds == 0) {?>class="r"><?}else{?> class="g"><?}?><?= $r->seeds ?>/<?= $r->leechers ?></td>
<td <?if ($r->leechers == 0) {?>class="r"><?}else{?> class="b"><?}?><?= $r->leechers ?></td>
<td <?if ($r->download == 0) {?>class="r"><?}else{?> class="b"><?}?><?= $r->download ?></td>

<? if ($r->seeds >= 5){?>
<td align="right">
<img alt="Torrent's Health" src="<?=$CFG->health;?>/5.gif" width="54" height="10"/><?}?></td>

<? if ($r->seeds == 4){?>
<td align="right">
<img alt="Torrent's Health" src="<?=$CFG->health;?>/4.gif" width="54" height="10"/><?}?></td>

<? if ($r->seeds == 3){?>
<td align="right">
<img alt="Torrent's Health" src="<?=$CFG->health;?>/3.gif" width="54" height="10"/><?}?></td>

<? if ($r->seeds == 2){?>
<td align="right">
<img alt="Torrent's Health" src="<?=$CFG->health;?>/3.gif" width="54" height="10"/><?}?></td>

<? if ($r->seeds == 1){?>
<td align="right">
<img alt="Torrent's Health" src="<?=$CFG->health;?>/2.gif" width="54" height="10"/><?}?></td>

<? if ($r->seeds == 0){?>
<td align="right">
<img alt="Torrent's Health" src="<?=$CFG->health;?>/1.gif" width="54" height="10"/><?}?></td>

  </tr>
  </div>


<?
}
?>

