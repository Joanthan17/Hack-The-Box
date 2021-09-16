<?

//ob_start("ob_gzhandler");

global $time_begin;
$time_begin = get_micro_time();


echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";

function selfURL() {
	$s = empty($_SERVER["HTTPS"]) ? ''
		: ($_SERVER["HTTPS"] == "on") ? "s"
		: "";
	$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
	$port = ($_SERVER["SERVER_PORT"] == "80") ? ""
		: (":".$_SERVER["SERVER_PORT"]);
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
}
function strleft($s1, $s2) {
	return substr($s1, 0, strpos($s1, $s2));
}


if ( selfURL() == "$CFG->wwwroot/torrents.php?mode=upload" )
{
$side=false;
} else {
$side=true;
}



$microtime = microtime();
$split = explode(" ", $microtime);
$exact = $split[0];
$secs = date("U");
$bgtm = $exact + $secs;
error_reporting(E_ALL ^ E_NOTICE);
?>
<?
/* check if file is being accessed directly */
if (eregi("header.php",$_SERVER['PHP_SELF']))
{
  Header("Location: $CFG->wwwroot");
  die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">



<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="<?=$CFG->wwwroot?>/templates/layout.css" type="text/css" />
<link rel="stylesheet" href="<?=$CFG->wwwroot?>/templates/colours.css" type="text/css" title="Default"/>
<link rel="stylesheet" href="<?=$CFG->wwwroot?>/templates/tabcss.css" type="text/css"/>


	<link rel="stylesheet" href="<?=$CFG->wwwroot;?>/css/lightbox.css" type="text/css" media="screen" />

	<script src="<?=$CFG->wwwroot;?>/js/prototype.js" type="text/javascript"></script>
	<script src="<?=$CFG->wwwroot;?>/js/scriptaculous.js?load=effects" type="text/javascript"></script>
	<script src="<?=$CFG->wwwroot;?>/js/lightbox.js" type="text/javascript"></script>



<link rel="alternate" type="application/xml" title="<? pv($DOC_TITLE) ?> RSS feed" href="<?=$CFG->wwwroot?>/rss.php"/>
<link rel="shortcut icon" href="<?=$CFG->wwwroot?>/favicon.ico" />
<title><? pv($DOC_TITLE) ?></title>
<script src="<?=$CFG->wwwroot;?>/sorttable.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$CFG->wwwroot;?>/hide.js"></script>



</head>
<body>

<table border="0" cellpadding="0" cellspacing="0" bgcolor="white" height="100%" width="950"  style="border-collapse:collapse;">
    <tr height="100%" bgcolor="#f9f9f9">
    <td align="right" >
    <? if (is_logged_in()) { ?>
		<? if ($_SESSION['privilege'] == "admin") { ?>
		<a href="<?=$CFG->wwwroot?>/admin"> <img src="<?=$CFG->imagedir?>/admin.png" width="70" height="40" border="0"></a>
		<a href="<?=$CFG->wwwroot?>/update_stats.php"> <img src="<?=$CFG->imagedir?>/updatestats.png" width="110" height="40" border="0"></a>

		<? } ?>

		<a href="<?=$CFG->wwwroot?>/users"> <img src="<?=$CFG->imagedir?>/mytorrents.png" width="110" height="40" border="0"></a>
		<a href="<?=$CFG->wwwroot?>/logout.php"> <img src="<?=$CFG->imagedir?>/logout.png" width="70" height="40" border="0"></a>

		<? } else { ?>

			<a href="<?=$CFG->wwwroot?>/login.php"> <img src="<?=$CFG->imagedir?>/login.png" width="70" height="40" border="0"></a>
			<a href="<?=$CFG->wwwroot?>/users/index.php?mode=register"> <img src="<?=$CFG->imagedir?>/register.png" width="70" height="40" border="0"></a>

		<? } ?>
</td>
</tr>

    <tr height="100%" >
	<td width="50%" height="100%" valign="bottom" background="<?=$CFG->imagedir?>/banner.jpg"><a href="<?=$CFG->wwwroot?>"><img src="<?=$CFG->imagedir?>/logo.png" width="110" height="90" border="0"></a>



</td>
</tr>
<tr>
        <td width="100%" height="100%" style="border-width:0px; border-color:rgb(204,204,204); border-style:solid;" bgcolor="white" >



<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="20" background="./images/top-bg.jpg" bgcolor="#f9f9f9">

                        <tr>
                          <td width="45%" height="50" align="left">
                          <a href="<?=$CFG->wwwroot?>"><img src="<?=$CFG->imagedir?>/link-home.png" width="50" height="50" border="0"></a>
                          <a href="<?=$CFG->wwwroot?>/index.php?mode=directory"><img src="<?=$CFG->imagedir?>/link-browse.png" width="50" height="50" border="0"></a>
                          <a href="<?=$CFG->wwwroot?>/torrents.php?mode=upload"><img src="<?=$CFG->imagedir?>/link-upload.png" width="50" height="50" border="0"></a>
                          <a href="<?=$CFG->forumroot?>"><img src="<?=$CFG->imagedir?>/link-forum.png" width="50" height="50" border="0"></a>
                          <a href="<?=$CFG->wwwroot?>/index.php?mode=stats"><img src="<?=$CFG->imagedir?>/link-stats.png" width="50" height="50" border="0"></a>
                          <a href="<?=$CFG->wwwroot?>/index.php?mode=news"><img src="<?=$CFG->imagedir?>/link-news.png" width="50" height="50" border="0"></a>
                          <a href="<?=$CFG->wwwroot?>/index.php?mode=faq"><img src="<?=$CFG->imagedir?>/link-faq.png" width="50" height="50" border="0"></a>
                          </td>

                          <td align="right">
                          <a href="<?=$CFG->wwwroot?>/index.php?mode=about"><img src="<?=$CFG->imagedir?>/link-about.png" width="50" height="50" border="0"></a>
                          <a href="http://www.myanmartorrents.com/" target="_blank"><img src="<?=$CFG->imagedir?>/link-development.png" width="70" height="50" border="0"></a>
                          </td>

			</tr>


<!-- BIG BANNER START -->


</table>

<!-- END BIG BANNER -->




			    <? if (nvl($side)) {?>
 <!-- BEGIN SIDEBAR -->
    <div id="sidebar">
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr border="0">

<? if ($CFG->usephpbb != "yes") {

    if (is_logged_in()) { ?>

 <div class="" align="center">

</td>
	</tr>
		<tr border="0">
	<td align="left">

<a href="<?=$CFG->wwwroot?>/users/index.php?mode=changepassword"><img src="<?=$CFG->imagedir?>/control panel.gif" width="179" height="40" border="0"></a>

</td>
	</tr>
	<tr height="20">



</div>



	</td>
	</tr>
	<? } else { ?>
	<tr valign="top">


			<td>
			<? if (! empty($errormsg)) { ?>
				<div class="warning" align="center"><? pv($errormsg) ?></div>
			<? } ?>

			<form name="entryform" method="post" action="<?=$CFG->wwwroot?>/login.php">
			<table>

<tr><td><img src="<?=$CFG->imagedir?>/login2.jpg" width="100" height="30" border="0"><br>
</td>
</tr>
			<tr>

				<td><font color="#333333">Username</font><br>
				<input type="text" name="username" style="font-size:1.25em" size="21" value="<? pv($frm["username"]) ?>"></td>
			</tr>
			<tr>
				<td><font color="#333333">Password</font><br>
				<input type="password" name="password" style="font-size:1.25em" size="21"></td>
			</tr>


			<tr>

				<td><input type="submit" class="button" value="Login">
					<br><br><div class="normal">
					  <a href="<?=$CFG->wwwroot?>/users/index.php?mode=register" style="text-decoration: none;">Sign up</a> |
					<a href="<?=$CFG->wwwroot?>/users/forgot_password.php" style="text-decoration: none;"> Lost password</a></div>
				</td>
			</tr>
			</table>
			</form>
			</td>
</tr>
<? } ?>


</table>

<? } ?>




<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">




<tr>
<td>

<div class="left">

<form action="<?=$CFG->wwwroot?>/torrents.php" method="post" enctype="multipart/form-data">
<img src="<?=$CFG->imagedir?>/search.jpg" width="100" height="30" border="0"><br>
<div><input type="text" name="name" id="search" style="font-size:1.25em" size="21" />
<input type="hidden" name="mode" value="search"/><br>
<input class="button" type="submit" value="Search">

</div>

</form>
</div>
<br><br>
<a href="<?=$CFG->wwwroot?>/rss.php"><img alt="Feed" src="<?=$CFG->imagedir?>/feed2.png" border="0"></a>
</td>
</tr>


</table>

</div>


	<!-- END USER MENU -->

<div id="content">
   <?}else {?>
 <div id="contentfull">
    <?
    }
?>