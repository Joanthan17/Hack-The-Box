

<?
$num = 0;
while ($r = db_fetch_object($qid))
{
$num = $num +1;
?>
<div id="news">
<h3 onclick="expandcontent(this, 'wt<?= $num ?>')" style="cursor:pointer"><span class="showstate"></span><?= $r->title?> - <?= $r->date?></h3>

<div id="wt<?= $num ?>" class="switchcontent">
<?= $r->content ?>
<br/>
Posted by <a href="mailto:SPM.<?= $r->email ?>.SPM"><?= $r->author ?></a>. <?=$r->time?>
</div>
</div>
<?
}
?>

