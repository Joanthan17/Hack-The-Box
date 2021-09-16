<?
while ($r = db_fetch_object($qid))
{
?>
<br>
<table class="main_table" border="0">

<tr>
<td rowspan="7"><img src="images/stats.png" border="0"></td>
</tr>

<tr>
<td><h5>Total Seeds</h5></td>
<td><div class="b"><?= pv($r->seeds)?></div></td>
</tr>

<tr>
<td><h5>Total Peers</h5></td>
<td><div class="b"><?= pv($r->leechers)?></div></td>
</tr>

<tr>
<td width="150"><h5>Finished Downloads</h5></td>
<td><div class="b"><?= pv($r->finished)?></div></td>
</tr>

<tr>
<td><h5>Trackers</h5></td>
<td><div class="b"><?= pv($r->trackers)?></div></td>
</tr>

<tr>
<td><h5>Torrents</h5></td>
<td><div class="b"><?= pv($r->torrents)?></div></td>
</tr>

<tr>
<td><h5>Total Size</h5></td>
<td><div class="b"><?= makesize($r->size)?></div></td>
</tr>







<?
}
?>
</table>

