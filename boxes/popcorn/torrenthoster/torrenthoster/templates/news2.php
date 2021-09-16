<div id="news2">

<?
$num = 0;
while ($r = db_fetch_object($qid))
{
$num = $num +1;
?>
<table width="100%">
<tr>
<td width="70" rowspan="3" valign="top"><img src="<?=$CFG->imagedir?>/news-arrow.gif" width="55" height="55" border="0">
</td>
<td width="635" align="left">
<h4><?= $r->title?><br /></h4>
</td>
</tr>


<tr><td>
<font style="font-size:10pt;"><?= $r->content ?></font>
<br />

</td>
</tr
<tr><td align="right">
<b><?= $r->date?></b> Posted by <a href="<?=$CFG->wwwroot?>/users/index.php?mode=userinfo&amp;username=<?= $r->author ?>"><?= $r->author ?></a>.<br />
</td>
</tr>
<tr align="right">
	<td colspan="2"><div id="dotted"></div></td>
</tr>
</table>
<br /><br />
<?
}
?>
</div>
