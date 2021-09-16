<?
#This file will handle the errors on the form

if (!empty($errormsg)) {
	echo "<h2 style=\"color: #ff0000\">Errors</h2>";
	echo "<div class=\"normal\" id=\"news\">";
	echo $errormsg;
	echo "</div>";
}
?>

<?
if (!empty($noticemsg)) {
	echo "<div id=\"news\" class=\"notice\">";
	echo $noticemsg;
	echo "</div>";
}
?>
