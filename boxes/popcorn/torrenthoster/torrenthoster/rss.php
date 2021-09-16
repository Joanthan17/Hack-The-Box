<? header('Content-type: text/xml'); ?>
<?
require "config.php";
echo "<?xml version=\"1.0\"?>
<rss version=\"2.0\">
<channel>
<title> $CFG->webname </title>
<link> $CFG->wwwroot </link>
<description>Latest Torrents</description>
<language>en-us</language>";

/*get data from sql server*/

if (isset($cat))
{
$result = db_query ("SELECT namemap.info_hash as hash, namemap.seeds as seeds, namemap.leechers as peers,
 format( namemap.finished, 0  ) as finished,  namemap.filename as filename, subcategories.name as scname,
 namemap.url, namemap.info, UNIX_TIMESTAMP( namemap.data ) as added, categories.image, 
 categories.name as cname, namemap.category as catid, namemap.size as size, namemap.uploader FROM namemap LEFT JOIN categories ON categories.id =  namemap.category LEFT JOIN subcategories ON subcategories.id = namemap.subcategory WHERE namemap.category = $cat ORDER BY namemap.data DESC LIMIT $CFG->rssnum");
}
elseif(isset($subcat))
{
$result = db_query ("SELECT namemap.info_hash as hash, namemap.seeds as seeds, namemap.leechers as peers,
 format( namemap.finished, 0  ) as finished,  namemap.filename as filename, subcategories.name as scname,
 namemap.url, namemap.info, UNIX_TIMESTAMP( namemap.data ) as added, categories.image, 
 categories.name as cname, namemap.category as catid, namemap.size as size, namemap.uploader FROM namemap LEFT JOIN categories ON categories.id =  namemap.category LEFT JOIN subcategories ON subcategories.id = namemap.subcategory WHERE namemap.subcategory = $subcat ORDER BY namemap.data DESC LIMIT $CFG->rssnum");
}
else
{
$result= db_query("SELECT namemap.info_hash as hash, namemap.seeds as seeds, namemap.leechers as peers,
 format( namemap.finished, 0  ) as finished,  namemap.filename as filename, subcategories.name as scname,
 namemap.url, namemap.info,   DATE_FORMAT(namemap.data,'%a, %d %b %Y %T') as added, categories.image, 
 categories.name as cname, namemap.category as catid, namemap.size as size, namemap.uploader FROM namemap LEFT JOIN categories ON categories.id =  namemap.category LEFT JOIN subcategories ON subcategories.id = namemap.subcategory ORDER BY namemap.data DESC LIMIT $CFG->rssnum");
}
while($row= db_fetch_array($result, MYSQL_BOTH))
{
extract ($row);
$size = makesize($size);
$hash = strip_tags($hash);
$filename = strip_tags($filename);
$amp = "/&/";
$ampand = " ";
$pubDate = mysql_timestamp($added,"D,j F Y"); 
$filename = preg_replace($amp, $ampand, $filename);
echo "
<item>\n
<title> $filename [ $cname - $scname]</title>\n
<link>$CFG->wwwroot/torrents.php?mode=download&amp;id=$hash</link>\n
<description>Seeds: $seeds Peers: $peers Filesize: $size mb</description>\n
<pubDate>$added CDT</pubDate>\n
<guid>$CFG->wwwroot/torrents.php?mode=download&amp;id=$hash</guid>\n
<enclosure url=\"$CFG->wwwroot/torrents.php?mode=download&amp;id=$hash\"  length=\"91104\" type=\"application/x-bittorrent\"/>
</item>\n";
}
echo "</channel>\n</rss>\n";

/**
function mysql_timestamp($stamp, $format) {
   $pattern = "/^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})$/i";
   if(preg_match($pattern, $stamp, $st) && checkdate($st[2], $st[3], $st[1])) {
      return date($format, mktime($st[4], $st[5], $st[6], $st[2], $st[3], $st[1]));
   }
   return $stamp;
}

**/

?>

