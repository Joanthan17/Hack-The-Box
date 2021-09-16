<?
include("../config.php");
require_login();
require_priv("admin");

$DOC_TITLE = "$CFG->webname - Admin";
include("templates/header.php");
?>


<a title="Send Bulk Email" href="mailto:<? 
$queryString = "SELECT email FROM users WHERE privilege != 'admin'";
$list = bulkMail($queryString);
echo $list;
?>">Send email to all users</a>
<br><br>


<?
include("templates/footer.php");
?>
