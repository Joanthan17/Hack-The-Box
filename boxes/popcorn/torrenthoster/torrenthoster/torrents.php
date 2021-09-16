<?php



include("config.php");
include "validator.php";

switch (nvl($_REQUEST["mode"])) {
	case "addone" :
		add_one($_REQUEST["path"],$_REQUEST["name"]);
		break;
}

$DOC_TITLE = "$CFG->webname - Torrents";

if (nvl($_REQUEST["mode"]) != "download")
include("$CFG->templatedir/header.php");
switch (nvl($_REQUEST["mode"])) {

	case "upload" :
	if ($CFG->regupload  == "yes"){
	require_login();
	$userUpload = $_SESSION["userName"];
		include("upload.php");
		break;
	} else {
		$userUpload = $_SESSION["userName"];
		include("upload.php");

//		print_add_torrent_form($something = "");
		break;
		}

	case "details" :
		torrent_details($_REQUEST["id"]);
		break;

	case "download" :
	if ($CFG->regdownload  == "yes"){
	require_login();
	torrent_download($_REQUEST["id"]);
		break;
	} else {
		torrent_download($_REQUEST["id"]);
		break;
	}

	case "insert" :
		$frm = $_POST;
		$errormsg = validate_form($frm, $errors);
		if (empty($errormsg)) {
		insert_torrent($frm);
		print_torrent_list();
		}
		else {
		include("$CFG->templatedir/form_header.php");
		print_add_torrent_form($frm);
		}
		break;


	case "category" :
		print_torrent_subcategory($_REQUEST["cat"]);

		//include("templates/user_password_reset.php");
		//print_user_list();
		break;
	case "subcategory" :
		print_torrent_list($_REQUEST["sub"]);

		//include("templates/user_password_reset.php");
		//print_user_list();
		break;

	case "search" :
		$searchArray = $_POST;
		print_search_list($searchArray);
		break;




	default :
//		torrent_download('d1f43eb23b8b24e0d404ec94c188ad11b2e0619f');
//		include("upload.php");

		if(isset($_GET['priv']))
		  print_admin_list();
		else
		  redirect("./index.php?mode=directory");
		break;
}
if (nvl($_REQUEST["mode"]) != "download")
include("templates/footer.php");

/******************************************************************************
 * FUNCTIONS
 *****************************************************************************/


function print_search_list($searchArray){

	global $CFG, $ME;
	$search_term = $searchArray['name'];

	$num_term_chars= strlen($search_term);

	if ($num_term_chars == "")
	{
	echo "Use at least 3 characters";
	}

	elseif ($num_term_chars < 3)
	{
	echo "Use at least 3 characters";
	}

	else
	{


	$qid = db_query ("SELECT namemap.info_hash as hash, namemap.seeds, namemap.leechers, namemap.download, namemap.filename2,
	format( namemap.finished, 0  ) as finished, namemap.registration as reg, namemap.anonymous as anon, namemap.filename, namemap.url, namemap.info,UNIX_TIMESTAMP( namemap.data ) as added, categories.image, categories.name as cname, namemap.category as catid, namemap.size, namemap.uploader
	FROM namemap LEFT  JOIN categories ON categories.id =
 namemap.category WHERE namemap.filename LIKE '%$search_term%' ORDER BY namemap.data DESC");


	include ("templates/torrents_list.php");

}
}
//end of print_search_list function
function torrent_details($tid)
{
global $CFG,$ME;
$qid = db_query("SELECT namemap.screenshot as screenshot, namemap.info_hash AS hash, namemap.seeds, namemap.leechers, format( namemap.finished, 0 ) AS finished, namemap.filename, namemap.url, namemap.info, namemap.data , namemap.lastupdate, namemap.announce_url as announce, categories.image, categories.name AS cname, namemap.category AS catid, namemap.size,  namemap.uploader as uploader,namemap.comment, namemap.registration as reg, namemap.anonymous as anon,namemap.download as download
FROM namemap LEFT JOIN categories ON categories.id = namemap.category
WHERE namemap.info_hash = '$tid'");
	include ("templates/torrent_details.php");




// Handle posted comment
include("comment.php");



}







//end of torrent_details funtion




function torrent_download($infohash)
{
	//if (nvl($_REQUEST["mode"]) != "register")


	global $CFG,$ME;


//if(ini_get('zlib.output_compression'))
//  ini_set('zlib.output_compression','Off');

$filepath=$CFG->torrents."/".$infohash.".btf";

if (!is_file($filepath) || !is_readable($filepath))
   {
 	include("$CFG->templatedir/header.php");
     	echo "Can't find torrent file!";
	include("$CFG->templatedir/footer.php");
    }else
{

$result=db_query("SELECT * FROM namemap WHERE info_hash='$infohash'");
$row = mysql_fetch_array($result);
extract($row);
$f=$filename;
$torrent = ".torrent";
$f = $f.$torrent;
$adddownload=db_query("UPDATE namemap SET download=download+1 WHERE info_hash='$infohash'");

   header("Content-Disposition: attachment; filename=\"$f\"");
   header("Content-type: application/x-bittorrent");
   readfile($filepath);
   die;

}

}//end of download function

function print_torrent_list($sub){
if (is_numeric($sub))
{
global $CFG, $ME;


	$qid= db_query("SELECT namemap.info_hash as hash, namemap.seeds, namemap.leechers,
         format( namemap.finished, 0  ) as finished,  namemap.filename,namemap.anonymous as anon,
         namemap.registration as reg, namemap.url, namemap.info, DATE_FORMAT(namemap.data,'%Y-%m-%d') as added, categories.image,categories.name as cname, namemap.category as catid, namemap.subcategory as subcat, subcategories.name as subname, namemap.size,namemap.uploader FROM subcategories, namemap LEFT  JOIN categories ON categories.id = namemap.category WHERE namemap.subcategory = subcategories.id AND namemap.subcategory = '$sub' ORDER BY added ASC");
	include ("templates/torrents_list_date.php");
}
else
{
global $CFG, $ME;
$date = date('YmdHis');
$qid= db_query("INSERT INTO log (ip,date) VALUES ('$_SERVER[REMOTE_ADDR]','$date')");
include("templates/hack.php");
}
}


function print_torrent_subcategory($cat) {
if (is_numeric($cat))
{	global $CFG, $ME;

if ($CFG->usesub == "yes") {
	$qid= db_query("SELECT * FROM subcategories WHERE catid = $cat ORDER BY name ASC");
	include("templates/subcategories.php");
	} else {
	$qid= db_query("SELECT namemap.info_hash as hash, namemap.seeds, namemap.leechers,
    format( namemap.finished, 0  ) as finished,  namemap.filename,namemap.anonymous as anon,
    namemap.registration as reg, namemap.url, namemap.info, DATE_FORMAT(namemap.data,'%Y-%m-%d') as added, categories.image,categories.name as cname, namemap.category as catid, namemap.subcategory, namemap.size,namemap.uploader
    FROM namemap LEFT  JOIN categories ON categories.id = namemap.category WHERE namemap.category = '$cat' ORDER BY added ASC");
	include ("templates/torrents_list_date.php");
}

}
else
{
global $CFG, $ME;
$date = date('YmdHis');
$qid= db_query("INSERT INTO log (ip,date) VALUES ('$_SERVER[REMOTE_ADDR]','$date')");
include("templates/hack.php");
}
}

function add_one($path,$name)

{
global $CFG, $ME;

	$qid=db_query("UPDATE downloads SET count=count+1 WHERE name='$name'");
	$file = $path;
	header('Content-Description: File Transfer');
	header('Content-Type: application/force-download');
	//header('Content-Length: ' . filesize($file));
	header('Content-Disposition: attachment; filename=' . basename($file));
	readfile($file);
	header("Location: $CFG->forumroot");


}


?>

