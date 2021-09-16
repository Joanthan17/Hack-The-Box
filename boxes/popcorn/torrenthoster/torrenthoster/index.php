<?

include "config.php";



$DOC_TITLE = "$CFG->webname";



include "$CFG->templatedir/header.php";

switch (nvl($_REQUEST["mode"])) {

	case "faq" :
		include("$CFG->templatedir/faq.php");
		break;

	case "stats" :
		echo "<div class=\"navbar\"><h2>".$CFG->webname." stats</h2></div>";

		global_stats();
		break;

	case "about" :
		include("$CFG->templatedir/about.php");
		break;

	case "directory" :
	   list_cat();
   		break;

	case "news" :
	    printnews(50);
		break;

	case "downloads" :
	    printdownloads(50);
		break;

	case "latesttorrents" :
		echo "<div class=\"navbar\"><h3>Latest Torrents</h3></div>";
		printlasttorrents("$CFG->maintorrents");
		echo "<div class=\"navbar\"><h3>Most Download Torrents</h3></div>";
		printmosttorrents("$CFG->maintorrents");
		break;

	case "report" :
		require_login();
		include("$CFG->templatedir/report_form.php");
		break;

	default :

	if ("$CFG->mainnews" != 0)
		echo "<h2><b>L</b>atest News</h2>";
		printnews2("$CFG->mainnews");
		break;
}
include "$CFG->templatedir/footer.php";


function global_stats()
{
global $ME,$CFG;

$qid=db_query("SELECT SUM(seeds) AS seeds, SUM(leechers) AS leechers,SUM(finished) AS finished,COUNT(DISTINCT announce_url) AS trackers, COUNT(*) AS torrents, SUM(size) AS size FROM namemap");

include("$CFG->templatedir/stats.php");

}//end of global_stats


function list_cat(){
  global $CFG, $ME;


  $qid= db_query("SELECT * FROM categories ORDER BY weight, name ASC");
  include ("$CFG->templatedir/directory.php");

}

?>

