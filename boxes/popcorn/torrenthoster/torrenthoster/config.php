<?php

  //rename this file to config.php
  /* turn on verbose error reporting (15) to see all warnings and errors */
  error_reporting(15);

//include "forumdb.php";

  //define a generic object to hold all the configuration variables
  class object {};

  //declare an instance of the generic object
  $CFG = new object;
  //declare root directory
  $CFG->dirroot     = dirname(__FILE__);

  //Edit This For TORRENT HOSTER Database
  //database configuration
  $CFG->host = "localhost";
  $CFG->dbName = "torrenthoster";	//db name
  $CFG->dbUserName = "";    //db username
  $CFG->dbPassword = "";	//db password

	$dbhost 	= $CFG->host;
	$dbuser 	= $CFG->dbUserName;
	$dbpass 	= $CFG->dbPassword;
	$database 	= $CFG->dbName;




  /* directory configuration, if all your webtorrent.com files are in one directory
 * you probably only need to set the wwwroot variable.  valid examples are:
 *
 * $CFG->wwwroot = "http://myserver.com/webtorrent";
 * $CFG->wwwroot = "http://localhost/webtorrent";
 * $CFG->wwwroot = "http://myserver.com";
 *
 * do not include the trailing slash. dirroot is the physical path on your
 * server where the application can find it's files. for more security, it is
 * recommended that you move the libraries and templates ($CFG->libdir
 * and $CFG->templatedir) outside of your web directories.
 */


  /* Edit below this */

  $CFG->wwwroot	 = "http://localhost/";  //full path to your website
  $CFG->forumroot = "http://www.myanmartorrents.com/phpbb";
  $CFG->webname = "Torrent Hoster";
  $CFG->support     = "webmaster@wmyanmartorrents.com";
  $CFG->rssnum      = "10"; //number of rss to show
  $CFG->mainnews	= "10"; //number of news on the main page, use 0 to not print news on main page
  $CFG->maintorrents= "30";//number of torrents in the main page
  $CFG->torrents    = "$CFG->dirroot/torrents"; //torrent folder repect to your wwwroot
  $CFG->usesub	    = "yes"; //Do you want to use Subcategories? "yes" or "no"
  //$CFG->usephpbb  = "no"; //put "yes" if you want to connect with phpbb users. "yes" or "no" << DO NOT USE IT YET
  $CFG->regdownload = "yes"; //only registered users can download torrents. "yes" or "no"
  $CFG->regupload   = "yes"; //only registered users can upload torrents. "yes" or "no"
  /*
      no to change below this (i think)
  */

  $CFG->templatedir = "$CFG->dirroot/templates";
  $CFG->libdir      = "$CFG->dirroot/lib";
  $CFG->imagedir    = "$CFG->wwwroot/images";
  $CFG->health      = "$CFG->wwwroot/health";
  $CFG->icondir     = "$CFG->imagedir/icons";
  $CFG->version     = "2.0";

  //$CFG->sessionname = "mtc";

  /* define database error handling behavior, since we are in development stages
  * we will turn on all the debugging messages to help us troubleshoot */
  $DB_DEBUG = true;
  $DB_DIE_ON_FAIL = true;




  //start session to hold username and password when linking from page to page
  session_start();
  header("Cache-control: private"); // IE 6 Bug Fix.

  //load up libraries
  require "lib/dblib.php";
  require "lib/stdlib.php";
  require "lib/webtorrent.php";

  /* setup some global variables */
  $ME = qualified_me();

  /* connect to the database */
  db_connect($CFG->host, $CFG->dbName, $CFG->dbUserName, $CFG->dbPassword);

/*
  	Print out header
  *******************************************/
  function stheader($title)
  {
  //global $time_begin;
  //$time_begin = get_micro_time();

  //global $sitename;
  echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <link rel="stylesheet" href="stylesheet.css" type="text/css" />
  <title>T-Xore : ';

  //echo htmlentities($title);




echo '</title>
</head><body>
<script type="text/javascript" src="dyn.js"></script>
';

}

// Get microtime
function get_micro_time()
{
  list($usec, $sec) = explode(' ', microtime());
  return ((float)$usec + (float)$sec);
}

function connect_forum($fdbhost, $fdbuser, $fdbpass, $fdatabase)
{
$errormes = 'The sql server has encountered a problem, we are trying to fix it as soon as possible';
@$connection = mysql_connect($fdbhost, $fdbuser, $fdbpass);
@mysql_select_db($fdatabase) or die($errormes);
}



function torsize ($size)
{
if ($size >= 1099511627776) 	{$size = round($size / 1024 / 1024 / 1024 / 1024, 2).' TB';}
elseif ($size >= 1073741824) 	{$size = round($size / 1024 / 1024 / 1024, 2).' GB';}
elseif ($size >= 1048576) 		{$size = round($size / 1024 / 1024, 2).' MB';}
elseif ($size >= 1024) 			{$size = round($size / 1024, 2).' KB';}
else 							{$size = $size.' Byte';}
return $size;
}



/* show files contained in a torrent */
function showfiles($hash)
{
$filename2 = $hash;
//global $CFG->torrents;
include_once("lib/BDecode.php") ;
include_once("lib/BEncode.php") ;
include_once("config.php") ;

$filename = "torrents/$filename2.btf";

$stream = @file_get_contents("$filename");


if ($stream == FALSE)
{
echo 'No details availiable... 1 ';
}
if(!isset($stream))
{
echo 'No details availiable... 2 ';
break;
}
else
{

$array = BDecode($stream);
if ($array === FALSE)

{
echo 'No details availiable... 3 ';
break;
}
else
{
if(array_key_exists("info", $array) === FALSE){
echo 'No details availiable... 4 ';
break;
}
else
{
$infovariable = $array["info"];
if (isset($infovariable["files"]))
{

$filecount = "";
foreach ($infovariable["files"] as $file)
{

$row_color = ($row_count % 2) ? $color1 : $color2;

$filecount += "1";
$multiname = $file['path'];
$multitorrentsize = torsize ($file['length']);
$torrentsize += $file['length'];
$combinedsize = torsize($torrentsize);
$strname = strip_tags ($multiname[0]);

$strname = htmlentities($strname);
$strname = strip_tags($strname);

echo "<tr><td width=\"50%\">$strname</td><td> $multitorrentsize</td></tr>";
$row_count++;
}
}
else
{
$singletf = $infovariable['name'] ;
$singletf  = strip_tags($singletf );
$torrentsize = torsize($infovariable['length']);

$singletf = htmlentities($singletf);
$singletf = strip_tags($singletf);

echo "<tr><td width=\"80%\">$torrentsize</td><td>$singletf</td></tr>";
}
}
}
}
}

function connect ($dbhost, $dbuser, $dbpass, $database)
{
$errormes = 'The sql server has encountered a problem, we are trying to fix it as soon as possible';
@$connection = mysql_connect($dbhost, $dbuser, $dbpass);
@mysql_select_db($database) or die($errormes);
}


?>
