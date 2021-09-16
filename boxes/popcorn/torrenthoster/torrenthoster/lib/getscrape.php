<?

include_once("BDecode.php");


function escapeURL($info)
{
    $ret = "";
    $i=0;
    while (strlen($info) > $i)
    {
        $ret .= "%".$info[$i].$info[$i + 1];
        $i+=2;
    }
    return $ret;
}

function scrape($url,$infohash="")
{
if (isset($url))
{
   $u = urldecode($url);
   $extannunce = str_replace("announce","scrape",$u);

   //die($extannunce);
//die($extannunce."?info_hash=".escapeURL($infohash));
set_time_limit(10);
if ($infohash!="")
   $fd = @fopen($extannunce."?info_hash=".escapeURL($infohash), "rb");
else
    $fd = @fopen($extannunce, "rb");
//$fd = fsockopen($extannunce, 0, $errno, $errstr, 30);
if ($fd)
   {

     $stream = "";
     while (!feof($fd))
     {
          $stream .= fgets($fd, 4096);
          if (strlen($stream) > 100000)
             {
             //die ("File too large to download.</BODY></HTML>");
             return;
             }
     }
   }
   else
       //die("no file handle!");
       return;

@fclose($fd);

//die($stream);

    $array = BDecode($stream);

        $files = $array["files"];
    if ($array == false || !isset($array["files"])||!is_array($files))
    {
        $ret = mysql_query("UPDATE namemap SET lastupdate=NOW(),namemap.seeds = 0, namemap.leechers= 0 WHERE announce_url = \"$url\"".($infohash=="" ? "" : " AND namemap.info_hash='$infohash'"));
        return;
     }

     //update time
        $ret = mysql_query("UPDATE namemap SET lastupdate=NOW() WHERE announce_url = \"$url\"".($infohash=="" ? "" : " AND namemap.info_hash='$infohash'"));

	foreach ($files as $hash => $data)
        {
          $seeders = $data["complete"];
	  //echo "completed: $seeders \n";
          $leechers = $data["incomplete"];
	  //echo "incompleted: $leechers \n";
          if (isset($data["downloaded"]))
             $completed = $data["downloaded"];
          else
              $completed = "0";

//	echo "the URL: $url \n";

          #$ret = mysql_query("UPDATE summary INNER JOIN namemap ON namemap.info_hash=summary.info_hash SET summary.seeds = $seeders, summary.leechers = $leechers, summary.finished= $completed  WHERE summary.info_hash = '" . bin2hex(stripslashes($hash)). "'" . " AND namemap.announce_url = \"$url\"");
           $ret = mysql_query("UPDATE namemap SET namemap.seeds = $seeders, namemap.leechers = $leechers, namemap.finished= $completed  WHERE namemap.info_hash = '" . bin2hex(stripslashes($hash)). "'");
       }
}
}
?>
