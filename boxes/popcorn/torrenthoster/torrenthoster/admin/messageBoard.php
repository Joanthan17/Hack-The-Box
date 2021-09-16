<?
include("../config.php");
require_login();
require_priv("admin");

$DOC_TITLE = "$CFG->webname Admin";
include("templates/header.php");

if($_POST){

if(isset($_POST['message']))
$message = $_POST['message'];
else
$message = 'No new message';
$message2 = jstring($message);
updateMessageBoard($message2);
echo "<h1>Message Updated</h1>";
}

include "templates/messageForm.php";


include "templates/footer.php";
/*functions*/


?>
