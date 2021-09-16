<?
/*
		Project : T-Xore    version     0.0.4      released     on 06/2006   By  Bogaa
		This piece of software is free to use by anyone and may be redistributed
		and modified by anyone in any way. We   can't be held   liable for damage
		or copyright infringement claims. Read the documentation!

		Bogaa's Homepage : http://www.meganova.org
		Project Homepage  : http://www.devnova.org
*/


// GLOBALS
@ini_set("max_execution_time", "3600");
@ini_set ( "memory_limit", "128M");
$y = 0;
// Connect to database

if ( ($_SESSION['userName'] == "admin") || ($_SESSION['privilege'] == "admin") )

{

	include_once("../login.php");
	exit;
}

include ("../config.php");
require_once '../BDecode.php';
include("$CFG->templatedir/header.php");

// Lower the priority of this apache process
@exec('renice +20 '.getmypid());
ob_implicit_flush();
//adminheader('Admin section : Update Torrent Stats');

// Fetch Trackers From sql
$result = mysql_query("SELECT DISTINCT announce_url FROM namemap ORDER BY filename DESC") or die(mysql_error());

echo '<h1>Updating all torrents in '.mysql_num_rows($result).' Trackers</h1><pre>';


while($row = mysql_fetch_assoc($result))
{
$tracker = $row['announce_url'];
$tracker = trim(str_replace('/announce', '/scrape', $tracker));

echo "Fetching From :\t<span title=\"$tracker\">".substr($tracker,0,20)."</span>\t\t";
@ob_flush();


@$fp = file_get_contents($tracker);
if(!$fp)
{
echo "\t Tracker is not responding<br />";
@ob_flush();
}
else
{
$stats = BDecode($fp);
$query  = "SELECT info_hash, seeds, leechers ";
$query .= "FROM namemap ";
$query .= "WHERE announce_url = '".$row['announce_url']."'";
$res_tor = mysql_query($query) or die('Error in SQL query: '.mysql_error());

while($row_tor = mysql_fetch_assoc($res_tor))
{
$y++;
$binhash = addslashes(pack("H*", $row_tor['info_hash']));
$hash = $row_tor['info_hash'];
$_seeds = $stats['files'][$binhash]['complete'];
$_peers = $stats['files'][$binhash]['incomplete'];
$last_update = date("YmdHis");


// temporary fix
if ($_seeds + $_peers > 0)
{

@mysql_query("UPDATE torrents SET  seeds = '$_seeds', leechers = '$_peers', updated= '$last_update' WHERE info_hash = '$hash' LIMIT 1") or die(mysql_error());
}
}
mysql_free_result($res_tor);
echo " :: ";
echo "	$y torrents have been updated<br />";

@ob_flush();
}
}
mysql_free_result($result);

echo "</pre><h3>$y torrents have been updated</h3>";


echo "</div><div id=\"footer\"><p>Rendertime: 0</p>";
echo "<p><a href=\"http://www.gnu.org/copyleft/gpl.html\"><img alt=\"GPL License\" src=\"$CFG->imagedir/gpl.png\"/></a> <a href=\"http://validator.w3.org/check?uri=referer\"><img alt=\"Valid XHTML 1.1!\" src=\"$CFG->imagedir/xhtml.gif\"/></a> <a href=\"http://jigsaw.w3.org/css-validator/check/referer\"><img alt=\"Valid CSS!\" src=\"$CFG->imagedir/css.gif\"/></a> <a href=\"http://www.spreadfirefox.com/?q=affiliates&amp;id=61312&amp;t=85\"><img alt=\"Get FireFox\" src=\"$CFG->imagedir/logo-firefox.png\"/></a></p>";
echo "<p>© Copyright 2006 MyanmarTorrents.com, All rights reserved.</a></p></div>";


?>

