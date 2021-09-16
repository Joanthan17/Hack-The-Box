<?

/*
I still need to make this one faster
If you know a way let me know
*/
//include ("./x/include/functions.php");




include ("config.php");
include ("./lib/getscrape.php");
include("$CFG->templatedir/header.php");

require_login();
require_priv("admin");

$result= db_query("SELECT * FROM namemap ORDER BY data DESC");

while($row= db_fetch_array($result))
{
extract ($row);
scrape(urldecode($announce_url),$info_hash);
echo "<br>$announce_url done<br>";
}

include("$CFG->templatedir/footer.php");

?>
