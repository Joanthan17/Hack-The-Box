<?
/*
		Project : T-Xore    version      0.0.4      released     on 06/2006   By  Bogaa
		This piece of software is free to use by anyone and may be redistributed
		and modified by anyone in any way. We   can't be held   liable for damage
		or copyright infringement claims. Read the documentation!

		Bogaa's Homepage : http://www.meganova.org
		Project Homepage  : http://www.devnova.org
*/

include "config.php";
include "$CFG->templatedir/header.php";

$cat[] = 1;
$cat[] = 2;
$cat[] = 3;
$cat[] = 4;
$cat[] = 5;
$cat[] = 6;
$cat[] = 7;


connect ($dbhost, $dbuser, $dbpass, $database);
stheader ('Browse all categories');

foreach ($cat as $val)
{
// the query to fetch the cat details
$result = mysql_query("SELECT * FROM categories WHERE id='".$val."' ORDER BY name ASC") or die (mysql_error());
$result_catname = mysql_query("SELECT * FROM categories WHERE id='".$val."'") or die (mysql_error());

// the catname
$namerow =  mysql_fetch_row($result_catname);

// print out everything else


echo '<br /><h2>'.$name.'</h2>';

echo '<table class="tor" width="100%" cellpadding="0" cellspacing="0" border="0"><tr><th>Category</th><th>Torrents</th><th>Rss</th></tr>';

while ($row = mysql_fetch_array($result))
{
extract($row);
echo '<tr>';
echo '<td width="15%">';
echo $torrents;
echo '</td>';
echo '</td>';
echo '<td><a href="subcat.php?id='.$subid.'">'.$name.' &raquo; ';
echo $subname;
echo '</a></td>';
echo '</td>';
echo '<td width="10%">';
echo '<a href="rss.php?type=cat&amp;id='.$subid.'"><img src="images/rss.gif" alt="rss"/></a>';
echo '</td>';

echo '</tr>';
}
echo '</table>';
}
include "$CFG->templatedir/footer.php";

?>