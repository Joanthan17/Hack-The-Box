<?
/* check if file is being accessed directly */
if (eregi("footer.php",$_SERVER['PHP_SELF']))
{
Header("Location: /index.php");
die();
}
?>
<?

global $time_begin;
global $time_end;
$time_end = get_micro_time();

echo "</td></tr>";
echo "
    <tr>
        <td bgcolor=\"white\" valign=\"bottom\" width=\"100%\" height=\"100%\" style=\"border-width:0px; border-color:rgb(204,204,204); border-style:solid;\">

";



/* Please DO NOT REMOVE "Powered by Torrent Hoster" link as you give credit to the developers. */


echo "<div id=\"footer\"><p>Rendertime: ".round($time_end-$time_begin, 3)."<br></p>";

echo "<font color=\"#3589E3\"><p>Copyright © 2007 TorrentHoster.com. All rights reserved.<br>Powered by <a href=\"http://www.myanmartorrents.com/\" target=\"_blank\">Torrent Hoster.</p></font></div>
    </td>
    </tr>
</table>

</body>
</html>
";




?>

