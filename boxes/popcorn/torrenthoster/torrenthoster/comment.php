<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="stylesheet.css" type="text/css" />
</head>

<body>

<?php

$username = $_SESSION['userName'];

	$ip=$_SERVER['REMOTE_ADDR'];
	if(isset($_POST['submitted']))
	{
	$commentid = strip_tags(trim($_GET['id']));
	$name = $_SESSION['userName'];
	$comment = trim($_POST['comment']);

	$date = date('YmdHis');
	if ($comment == '')
		{
	stheader('Comment failed!');
	echo '<div id="commeror" class="fade-FFBFBF" style="padding:.2em"><br /><h3>Error. Please check again.</h3></div>';
	echo "</div><div id=\"footer\"><p>Rendertime: 0</p>";
	echo "<p><a href=\"http://www.gnu.org/copyleft/gpl.html\"><img alt=\"GPL License\" src=\"$CFG->imagedir/gpl.png\"/></a> <a href=\"http://validator.w3.org/check?uri=referer\"><img alt=\"Valid XHTML 1.1!\" src=\"$CFG->imagedir/xhtml.gif\"/></a> <a href=\"http://jigsaw.w3.org/css-validator/check/referer\"><img alt=\"Valid CSS!\" src=\"$CFG->imagedir/css.gif\"/></a> <a href=\"http://www.spreadfirefox.com/?q=affiliates&amp;id=61312&amp;t=85\"><img alt=\"Get FireFox\" src=\"$CFG->imagedir/logo-firefox.png\"/></a></p>";
	echo "<p>© Copyright 2006 TorrentHoster. All rights reserved.</a></p></div></body>
	</html>
	";

  	die;
		}

	stheader('Comment submitted');
	mysql_query("INSERT INTO comments (id,ip,date,name,post) VALUES ('$commentid','$ip','$date','$name','$comment')");
	echo '<div id="commplete" class="fade-DAFF9F" style="padding:.2em"><br /><h3>Comment posted! Thanks.</h3></div>';
}


// Fetch comments from sql
$result = mysql_query("SELECT * FROM comments WHERE id ='".strip_tags(trim($_GET['id']))."'");
$comment_count = mysql_num_rows($result);

// div colors
$color1 = 'class="light"';
$color2 = 'class="dark"';
$row_count = 0;

echo '<br /><br /><h3>Comments ('.$comment_count.')</h3>';
if (!$comment_count == 0)
{
echo '<div class="commentwrapper">';
while ($row = mysql_fetch_array($result))

{
extract($row);
$row_color = ($row_count % 2) ? $color1 : $color2;
echo '<div '.$row_color.'><strong>'.htmlentities($name).'</strong> On <strong>'.$date.'</strong><br /><br />'.nl2br(htmlentities($post)).'</div><br /><br />';
$row_count++;
}
}


if (is_logged_in()) {

$result = mysql_query("SELECT * FROM ban WHERE ip = '$_SERVER[REMOTE_ADDR]'");

if (mysql_num_rows($result) == 1)
{
echo '<br /><br /><h3>You cant add any comments!</h3>You cant add any comments because you where banned for some reason.';
die;
}

echo '<br /><form id="comment" action="torrents.php?mode=details&id='.strip_tags(trim($_GET['id'])).'" method="post">';
//echo '<input name="user" value="$username" onclick=\'value=""\' /><br /><br />';
echo '<textarea name="comment" value="Comment" cols="50" rows="7"></textarea><br />';
echo '<input type="submit" class="button" name="submitted" value="submit" /></form>';
echo "<br>Please do not flood your comments. Your IP Address is being logged.<br></div>";
}
?>

</body></html>