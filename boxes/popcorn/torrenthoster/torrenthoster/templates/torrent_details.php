<?
while ($r = db_fetch_object($qid))
{
  if ($r->anon == 'true') $r->uploader='Guest';
?>



<h2><?= pv($r->filename) ?></h2><br>
<a href="torrents.php?mode=download&amp;id=<?= pv($r->hash)?>"><img alt="Download Torrents" border="0" src="<?=$CFG->imagedir?>/download details.jpg"></a>
<?	if ($CFG->regdownload == "yes") {
	 if (is_logged_in()) { } else {
	echo "<br>You need to login to download torrents.";

	} ?>
<br><br>
<div class="main_table">
<table width="100%" border="0" class="infotable">
<tr>
  <td rowspan="5"><img src="images/seeds.jpg" border="0">
  </td>
</tr>

  <tr>
    <td>Download</td>
    <td><a href="torrents.php?mode=download&amp;id=<?= pv($r->hash)?>"><?= pv($r->filename) ?></a> </td>
  </tr>
<tr>
    <td>Uploaded By</td>
    <td><a href="<?=$CFG->wwwroot?>/users/index.php?mode=userinfo&amp;username=<?= p($r->uploader) ?>
"><?= p($r->uploader) ?></a>
</td>
  </tr>

  <tr>
    <td>Category</td>
    <td><?= pv($r->cname) ?></td>
  </tr>
  <tr>
    <td>Size</td>
    <td><?= makesize($r->size) ?></td>
  </tr>
  <tr height ="25">
  </tr>
<tr>  <td rowspan="5"><img src="images/globe.jpg" border="0">
  </td>
</tr>
  <tr>

    <td>Seeds</td>
    <td>		<?if ($r->seeds == 0) {?>
                <div class="rr">
                <?}else{?> <div class="rg"><?}?>
                 <?= $r->seeds ?></div>
	</td>
  </tr>
  <tr>
    <td>Peers</td>
    <td>		<?if ($r->leechers == 0) {?>
                <div class="rr">
                <?}else{?> <div class="rb"><?}?>
                 <?= $r->leechers ?></div>
  </tr>
    <tr>
    <td>Finished</td>
    <td><?= pv($r->finished) ?></td>
  </tr>

  <tr>
      <td>Update Stats</td>
      <td><? if (is_logged_in()) { ?><a href="<?=$CFG->wwwroot?>/update_stats2.php?mode=update&amp;hash=<?= pv($r->hash)?>"> Update Stats <? } else { ?> You must login to update stats. <? } ?></td>
  </tr>

        <tr height ="25">
	    </tr>
	  <tr>  <td rowspan="5"><img src="images/statics.jpg" border="0">
	    </td>
</tr>

    <td>Tracked By</td>
    <td><?= pv($r->announce) ?></td>
  </tr>

    <tr>
    <td>Added</td>
    <td><?= pv($r->data) ?></td>
  </tr>
  <tr>
    <td>Last Update</td>
    <td><?= pv($r->lastupdate) ?></td>
  </tr>
  <tr>
    <td>Comment</td>
    <td><?= pv($r->comment) ?></td>
  </tr>

          <tr height ="25">
  	    </tr>
  	  <tr>  <td rowspan="3"><img src="images/files screenshot.jpg" border="0">
  	    </td>
</tr>



  <tr>
  <td colspan="2">
<table width="100%" border="0" class="infotable">
 <tr>
    <td width="18%">Screenshots</td>
    <td>



    <a href="./upload/<?= pv($r->screenshot)?>" rel="lightbox" title="<?= pv($r->filename) ?>"><img src="./thumbnail.php?gd=2&src=./upload/<?= pv($r->screenshot)?>&maxw=96" /></a>


    </td>
  </tr>




<!--? if (is_logged_in()) { ?-->
<? if ( $r->uploader == $_SESSION['userName'] || $_SESSION['privilege'] == "admin" ) { ?>

 <tr>
 <td width="18%"></td>
 <td>

<input type="button" name="edit" value="Edit this torrent" class="button" onClick="window.open('edit.php?mode=edit&amp;id=<?= pv($r->hash)?>','Upload_Screenshot','width=650,height=600,resizable=0,scrollbars=0,toolbar=0,status=0');return false;" use style="height: 25px;">


</td>
</tr>
<? } ?>


</table>


  </td>
  </tr>

<tr>
      <td colspan="2">

      <div id="files">
	  <h4 onclick="expandcontent(this, 'openfiles')" style="cursor:pointer"><span class="showstate"></span>Files</h4>
	  <div id="openfiles" class="switchcontent">
	  <table width="100%" border="0" class="infotable">
	    <tr>
	      <? @showfiles($r->hash); ?>

	    </tr></table>

	  </div>
</div>
      </td>

  </tr>



</table>
</div>
<?

	}
?>
<!--
<br>
<a href="<?=$CFG->wwwroot?>/index.php?mode=report"><img src="./images/report.gif" width="120" height="18" border="0"></a>
-->
<?
}
?>
