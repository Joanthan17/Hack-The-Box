<?

include("../config.php");

require_login();
//require_priv("admin");
if ($_SESSION['privilege'] != "admin")
{
echo "You do not have permission to access this file";
break;
}
//include "validator.php";

$DOC_TITLE = "$CFG->webname - Torrents";

if (nvl($_REQUEST["mode"]) != "download"||nvl($_POST["mode"]) != "editit")
  include("templates/header.php");
switch (nvl($_REQUEST["mode"])) {

 case "upload" :
   include("../upload.php");
   break;


 case "details" :
   torrent_details($_REQUEST["id"]);
   break;

 case "editit":
   $torrentarray = $_POST;
   torrent_editit($torrentarray);
   break;

 case "editit_news":
   $array = $_POST;
   news_editit($array);
   break;

 case "edit" :
   torrent_edit($_REQUEST["id"]);
   break;

 case "delete" :
   torrent_delete($_REQUEST["id"]);
   break;

 case "delete_comment" :
   comment_delete($_REQUEST["id"]);
   break;

case "ban_ip" :
   ban_ip($_REQUEST["id"]);
   break;

 case "deletenews" :
   news_delete($_REQUEST["id"]);
   break;

 case "download" :
   torrent_download($_REQUEST["id"]);
   break;

 case "remove_ban" :
   remove_banip($_REQUEST["id"]);
   break;

 case "news" :
   print_news();
   break;

 case "ban" :
   print_ban();
   break;

 case "editnews" :
   edit_news($_REQUEST["id"]);
   break;

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
   break;

 case "subcategory" :
   print_torrent_list($_REQUEST["sub"]);
   break;

 case "search" :
   $searchArray = $_POST;
   print_search_list($searchArray);
   break;

 case "dead" :
   print_dead_torrents();
   break;

 case "users" :
   print_users();
   break;

 case "comments" :
   print_comments();
   break;

 case "hack" :
   print_hacks();
   break;

case "listtorrents" :
   printlasttorrents();
   break;

 case "insert_news":
   news_insert();
   break;

 case "insertit_news":
   $array = $_POST;
   news_insertit($array);
   break;

case "add_cat" :
   add_cat();
   break;

case "add_catit" :
   $array = $_POST;
   add_catit($array);
   break;

case "add_subcat" :
   add_subcat();
   break;

case "add_subcatit" :
   $array = $_POST;
   add_subcatit($array);
   break;

case "removecat" :
   remove_cat($_REQUEST["cat"]);
   break;

case "removesubcat" :
   remove_subcat($_REQUEST["sub"]);
   break;

case "list_cat" :
   list_cat();
   break;

case "links" :
   print_links();
   break;

case "deleteuser" :
   user_delete($_REQUEST["id"]);
   break;

 default :
   admin();
   break;
}
if (nvl($_REQUEST["mode"]) != "download")
  include("templates/footer.php");

/******************************************************************************
 * FUNCTIONS
 *****************************************************************************/


function print_admin_list(){
  global $CFG, $ME;
  $qid = db_query("
	SELECT id, userName, privilage, email, joined, lastconnect
	FROM users WHERE privilege = 'admin'
  	");

  include("templates/user_list.php");
}


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


	  $qid = db_query ("SELECT namemap.info_hash as hash, namemap.seeds, namemap.leechers,
 format( namemap.finished, 0  ) as finished, namemap.filename, namemap.url, namemap.info,UNIX_TIMESTAMP( namemap.data ) as added, categories.image, categories.name as cname, namemap.category as catid, namemap.size, namemap.uploader FROM namemap LEFT  JOIN categories ON categories.id =
 namemap.category WHERE namemap.filename LIKE '%$search_term%' ORDER BY namemap.data DESC");


	  include ("templates/torrents_list.php");

	}
}
//end of print_search_list function
function torrent_details($tid)
{
  global $CFG,$ME;
  $qid = db_query("SELECT namemap.info_hash AS hash, namemap.seeds, namemap.leechers, format( namemap.finished, 0 ) AS finished, namemap.filename, namemap.url, namemap.info, namemap.data , namemap.lastupdate, namemap.announce_url as announce, categories.image, categories.name AS cname, namemap.category AS catid, namemap.size, namemap.uploader,namemap.comment
FROM namemap LEFT JOIN categories ON categories.id = namemap.category
WHERE namemap.info_hash = '$tid'");
  include ("templates/torrent_details.php");
}//end of torrent_details funtion

function torrent_edit($tid)
{
  global $CFG,$ME;
  $qid = db_query("SELECT namemap.info_hash AS hash, namemap.seeds, namemap.leechers, format( namemap.finished, 0 ) AS finished, namemap.filename, namemap.url, namemap.info, namemap.data , namemap.lastupdate, namemap.announce_url as announce, categories.image, categories.name AS cname, namemap.category AS catid, namemap.size, namemap.uploader,namemap.comment
FROM namemap LEFT JOIN categories ON categories.id = namemap.category
WHERE namemap.info_hash = '$tid'");
  include ("templates/modify.php");
}//end of torrent_edit funtion

function torrent_editit($array)
{
  global $CFG,$ME;
  $id = $array['id'];
  $name = $array['torrent'];
  $cat = $array['type'];
  if ($CFG->usesub == "yes") {
  $subcat = $array['subtype'];
  }
  $text = $array['comment'];
  $reg = $array['registration'];
  if ($CFG->usesub == "yes") {
  $qid = db_query("UPDATE namemap SET filename='$name', filename2='$name', registration ='$reg', category='$cat', subcategory='$subcat', comment='$text' WHERE info_hash='$id'");
  } else {
  $qid = db_query("UPDATE namemap SET filename='$name', filename2='$name', registration ='$reg', category='$cat', comment='$text' WHERE info_hash='$id'");
  }
  redirect("$CFG->wwwroot/admin/index.php?mode=details&id=$id","updating Torrent",2);

}//end torrent_editit

function torrent_download($infohash)
{
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

		header("Content-Disposition: attachment; filename=\"$f\"");
		header("Content-type: application/x-bittorrent");
		readfile($filepath);

	  }

}//end of download function

function print_torrent_list($sub){
  global $CFG, $ME;


  $qid= db_query("SELECT namemap.info_hash as hash, namemap.seeds, namemap.leechers,
         format( namemap.finished, 0  ) as finished,  namemap.filename,
         namemap.url, namemap.info, DATE_FORMAT(namemap.data,'%Y-%m-%d') as added, categories.image,categories.name as cname, namemap.category as catid, namemap.subcategory, namemap.size, namemap.uploader FROM namemap LEFT  JOIN categories ON categories.id = namemap.category WHERE namemap.subcategory = '$sub' ORDER BY added ASC");
  include ("templates/torrents_list_date.php");
}

function print_comments(){
  global $CFG, $ME;


  $qid= db_query("SELECT * FROM comments ORDER BY id ASC");
  include ("templates/comments_list.php");
}


function print_hacks(){

$date = date('YmdHis');
  global $CFG, $ME;


  $qid= db_query("SELECT * FROM log ORDER BY date ASC");
  include ("templates/hack_list.php");
}


function print_ban(){

  global $CFG, $ME;

    $qid= db_query("SELECT * FROM ban ORDER BY ip");
  include ("templates/ban_list.php");

}//end show banned IP function


function print_dead_torrents(){
  global $CFG, $ME;


  $qid= db_query("SELECT namemap.info_hash as hash, namemap.seeds, namemap.leechers,
         format( namemap.finished, 0  ) as finished,  namemap.filename,
         namemap.url, namemap.info, DATE_FORMAT(namemap.data,'%Y-%m-%d') as added, categories.image,categories.name as cname, namemap.category as catid, namemap.subcategory, namemap.size, namemap.uploader FROM namemap LEFT  JOIN categories ON categories.id = namemap.category WHERE namemap.seeds  = 0 and namemap.leechers = 0 ORDER BY added ASC");
  include ("templates/torrents_list_date.php");
}


function print_users(){

  global $CFG, $ME;

  $qid= db_query("SELECT id, userName, Email, Privilege, joined, lastconnect
         FROM users;");
  include ("templates/list_users.php");
}


function print_torrent_subcategory($cat)
{	global $CFG, $ME;
 $qid= db_query("SELECT * FROM subcategories WHERE catid = $cat ORDER BY name ASC");
 include("templates/subcategories.php");


}

function torrent_delete($id)
{
  global $CFG, $ME;
  $qid= db_query("DELETE FROM namemap WHERE info_hash=\"$id\"");
  if ($qid)
	{$qid= db_query("DELETE FROM comments WHERE id=\"$id\"");
	unlink($CFG->torrents."/$id.btf");
	redirect("$CFG->wwwroot/admin/index.php?mode=listtorrents","Torrent Deleted",2);
	}
  else
	echo "<div class=\"warning\">Torrent does not Exist</div>";

}//end torrent delete function


function comment_delete($id)
{
  global $CFG, $ME;
  $qid= db_query("DELETE FROM comments WHERE post=\"$id\"");
  if ($qid)
	{# $qid= db_query("DELETE FROM comments WHERE id=\"$id\"");
	#unlink($CFG->torrents."/$id.btf");
	redirect("$CFG->wwwroot/admin/index.php?mode=comments","Comment Deleted",2);
	}
  else
	echo "<div class=\"warning\">Comment does not Exist</div>";

}//end comment delete function


function remove_banip($id)
{
  global $CFG, $ME;
  $qid= db_query("DELETE FROM ban WHERE ip=\"$id\"");
  if ($qid)
	{#$qid= db_query("DELETE FROM comments WHERE id=\"$id\"");
	#unlink($CFG->torrents."/$id.btf");
	redirect("$CFG->wwwroot/admin/index.php?mode=ban","Removed Ban IP",2);
	}
  else
	echo "<div class=\"warning\">IP does not Exist</div>";

}//end remove ban function


function ban_ip($id)
{
  global $CFG, $ME;
  $qid= db_query("INSERT INTO `ban` VALUES ('$id', '')");
	if ($qid)
	{
	redirect("$CFG->wwwroot/admin/index.php?mode=comments","IP Banned",2);
	}
  else
	echo "<div class=\"warning\">IP does not Exist</div>";

}//end IP ban function



function print_news()
{
  global $CFG, $ME;
  $qid=db_query("SELECT
news_id as id, title, content, author, email, DATE_FORMAT(date, '%d/%m/%y') AS date,
 TIME_FORMAT(time, '%k:%i:%S %p') AS time
FROM news ORDER BY news_id DESC");

  include("templates/news.php");

}//end print news

function edit_news($id)
{
  global $CFG, $ME;
  $qid=db_query("SELECT
news_id as id, title, content, author, email, DATE_FORMAT(date, '%d/%m/%y') AS date,
 TIME_FORMAT(time, '%k:%i:%S %p') AS time
FROM news WHERE news_id = $id");

  include("templates/edit_news.php");

}//end edit
function news_editit($array)
{
  global $CFG,$ME;
  $id = $array['id'];
  $title = $array['title'];
  $author = $array['author'];
  $content = $array['content'];
  //playing around with the date to learn stuff...
  $date = $array['date'];
  list( $day,$month,$year ) = split( "/", $date );
  $datex = date("Y-m-d",mktime( $hour, $minute, $second, $month, $day, $year ));
  $qid = db_query("UPDATE news SET title='$title', content ='$content', author='$author',
                   date='$datex'
                   WHERE news_id = '$id'");

    redirect("$CFG->wwwroot/admin/index.php?mode=news","Updating News Item",2);

}//end torrent_editit


function news_insert()
{
  global $CFG,$ME;

  $author = $_SESSION["userName"];
  include("templates/insert_news.php");

}//end torrent_editit

function news_insertit($array)
{
  global $CFG,$ME;
  $id = $array['id'];
  $title = $array['title'];
  $author = $_SESSION["userName"];
  $content = $array['content'];
  $date = date("Y-m-d");
  $qid = db_query("INSERT INTO news (title,content,author,date) VALUES('$title', '$content','$author',
                   '$date')");

    redirect("$CFG->wwwroot/admin/index.php?mode=news","Inserting News Item",2);

}//end news_editit

function news_delete($id)
{
  global $CFG, $ME;
  $qid= db_query("DELETE FROM news WHERE news_id =\"$id\"");
  if ($qid)
	{
	  redirect("$CFG->wwwroot/admin/index.php","News Item Deleted",2);
	}
  else
	echo "<div class=\"warning\">News Item does not Exist</div>";

}//end news delete function


function admin(){
  include ("admin.php");
}


function add_cat()
{
  global $CFG,$ME;
  include("templates/add_cat.php");

}


function add_catit($array)
{
  global $CFG,$ME;
  $name = $array['name'];
  $weight = $array['weight'];
  $qid = db_query("INSERT INTO categories (name, weight) VALUES('$name', '$weight')");

    redirect("$CFG->wwwroot/admin/index.php?mode=list_cat","Inserting New Category",2);

}


function list_cat(){
  global $CFG, $ME;


  $qid= db_query("SELECT * FROM categories ORDER BY weight, name ASC");
  include ("templates/list_cat.php");
}

function remove_cat($cat)
{
  global $CFG, $ME;
  $qid= db_query("DELETE FROM categories WHERE id =\"$cat\"");
  $qid2= db_query("DELETE FROM subcategories WHERE catid =\"$cat\"");
  if ($qid)
	{
	  redirect("$CFG->wwwroot/admin/index.php?mode=list_cat","Category Deleted",2);
	}
  else
	echo "<div class=\"warning\">Category Item does not Exist.</div>";

}

function remove_subcat($sub)
{
  global $CFG, $ME;
  $qid= db_query("DELETE FROM subcategories WHERE id =\"$sub\"");
  if ($qid)
	{
	  redirect("$CFG->wwwroot/admin/index.php?mode=list_cat","Subcategory Deleted",2);
	}
  else
	echo "<div class=\"warning\">Subcategory Item does not Exist.</div>";

}


function add_subcat()
{
  global $CFG,$ME;
  include("templates/add_subcat.php");

}


function add_subcatit($array)
{
  global $CFG,$ME;
  $subname = $array['subname'];
  $catid = $array['cat'];

  $qid = db_query("INSERT INTO subcategories (name,catid) VALUES('$subname','$catid')");

  redirect("$CFG->wwwroot/admin/index.php?mode=list_cat","Inserting New Subcategory",2);

}


function print_links(){
  global $CFG, $ME;


  $qid= db_query("SELECT * FROM links ORDER BY id ASC");
  include ("templates/list_link.php");
}


function user_delete($id)
{
  global $CFG, $ME;
  $qid= db_query("DELETE FROM users WHERE id =\"$id\"");
  if ($qid)
	{
	  redirect("$CFG->wwwroot/admin/index.php?mode=users","User Deleted",1);
	}
  else
	echo "<div class=\"warning\">User does not Exist</div>";

}//end user delete function


?>

