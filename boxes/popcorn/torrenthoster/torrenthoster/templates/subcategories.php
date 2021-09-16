<a href = "javascript:history.back()" style="text-decoration: none;"><img src="images/back.gif" width="49" height="20" border="0"></a><br><br>
<table class="main_table" id="main" width = "100%" cellpadding="0" cellspacing="0"border="0">
<tr>
<tr height="25">

 <td background="./images/orange bg.jpg" width="6%">
<font color="white" style="font-size:11pt;"><b></b></font>
  </td>

  <td background="./images/orange bg.jpg">
  <font color="white" style="font-size:11pt;"><b>Subcategories</b></font>
  </td>




<? if ($_SESSION['privilege'] == "admin")

{ ?>

  <td background="./images/orange bg.jpg">
<font color="white" style="font-size:11pt;"><b>Remove</b></font>
  </td>


<? } else { } ?>

</tr>

<?
while ($r = db_fetch_object($qid))
{
?>

<tr>
<td><a href="torrents.php?mode=subcategory&amp;sub=<?= $r->id ?>"><img src="images/folder2.png" width="38" height="28" border="0"></a></td>
<td><a href="torrents.php?mode=subcategory&amp;sub=<?= $r->id ?>"><?= $r->name ?></a></td>

<? if ($_SESSION['privilege'] == "admin")
{ ?>

<td><div align="center"><a href="admin/index.php?mode=removesubcat&amp;sub=<?= $r->id ?>">Remove</a></div></td>

<? } else { } ?>

</tr>

<?
}
?>
</table>
<br><a href = "javascript:history.back()" style="text-decoration: none;"><img src="images/back.gif" width="49" height="20" border="0"></a>