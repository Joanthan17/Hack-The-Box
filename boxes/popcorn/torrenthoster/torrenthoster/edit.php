<? include("config.php");
include "validator.php";



switch (nvl($_REQUEST["mode"])) {

	case "edit" :
	   		torrent_edit($_REQUEST["id"]);
  		break;

  	  	case "editit":
			$torrentarray = $_POST;
			torrent_editit($torrentarray);
   		break;
}

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
  redirect("$CFG->wwwroot/edit.php?mode=edit&id=$id","Updating Torrent",1);

}//end torrent_editit