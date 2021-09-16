<?

/*
I still need to make this one faster
If you know a way let me know
*/
//include ("./x/include/functions.php");


include ("config.php");
include ("./lib/getscrape.php");
include("$CFG->templatedir/header.php");


switch (nvl($_REQUEST["mode"])) {
	case "addone" :
		add_one($_REQUEST["path"],$_REQUEST["name"]);
		break;
}




require_login();
//require_priv("admin");

switch (nvl($_REQUEST["mode"])) {


case "update" :
		update($_REQUEST["hash"]);
		break;

}



function update($hash) {

$result= db_query("SELECT * FROM namemap WHERE namemap.info_hash = '$hash'");

while($row= db_fetch_array($result))
{
extract ($row);
scrape(urldecode($announce_url),$info_hash);
echo "<br>$announce_url done<br><br>
<a href = \"torrents.php?mode=details&id=$hash\" style=\"text-decoration: none;\"><img src=\"images/back.gif\" width=\"49\" height=\"20\" border=\"0\"></a><br><br>
";
}
}

include("$CFG->templatedir/footer.php");

?>
