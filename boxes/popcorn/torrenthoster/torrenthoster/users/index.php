<?

include("../config.php");

if (nvl($_REQUEST["mode"]) != "register")
require_login();
//require_priv("user", "admin");

//include "validator.php";

$DOC_TITLE = "$CFG->webname - Users";
$side=true;
include("$CFG->templatedir/header.php");
switch (nvl($_REQUEST["mode"])) {

	case "changepassword" :
		if (match_referer() && isset($_POST)) {
		$frm =$_POST;
		$errormsg = validate_form($frm, $errors);
		 if (empty($errormsg)) {
                update_password($frm["newpassword"]);
                $noticemsg = "Password change successful";
		}	}
		include("$CFG->templatedir/form_header.php");
		include("templates/change_password_form.php");
		break;

	case "userinfo" :
		user_torrents($_REQUEST["username"]);
		break;

	case "insert" :
		$frm = $_POST;
		$errormsg = validate_form($frm, $errors);
		if (empty($errormsg)) {
		insert_torrent($frm);
		print_torrent_list();
		}
		else {
		include("$CFG->templatedir/form_header.php");
		print_add_torrent_form($frm);
		}
		break;


	case "register":

		require_once("../validator.php");
		/* form has been submitted, try to create the new user account */
		if (match_referer() || (isset($_POST['username']) && isset($_POST['email']))){
		$frm = $_POST;
		$errormsg = validate_formr($frm, $errors);
		if (empty($errormsg)) {
		insert_user($frm);
		include("templates/registration_success.php");
		break;}	}
		include("$CFG->templatedir/form_header.php");
		include("templates/signup_form.php");
		/* include("templates/signup_form.php"); */

		break;

	default :
		$userUpload = $_SESSION["userName"];
		print_user_menu();
		user_torrents($userUpload);
		break;

}
//if (nvl($_REQUEST["mode"]) != "download")
include("$CFG->templatedir/footer.php");

/******************************************************************************
 * FUNCTIONS
 *****************************************************************************/
//makes sure that everything is under control
function print_user_menu(){


}//end print_user_menu

function user_torrents($username){
global $CFG, $ME;

$qid= db_query("SELECT namemap.info_hash as hash, namemap.seeds, namemap.leechers,
         format( namemap.finished, 0  ) as finished,  namemap.filename,          namemap.url, namemap.info, DATE_FORMAT(namemap.data,'%Y-%m-%d') as added, categories.image,categories.name as cname, namemap.category as catid, namemap.subcategory, namemap.size,namemap.uploader FROM namemap LEFT  JOIN categories ON categories.id = namemap.category WHERE namemap.uploader = '$username' ORDER BY added ASC");
	echo "<div id=\"news\">Torrents Uploaded by $username</div>";
include ("$CFG->templatedir/torrents_list_date.php");

}//end users_torrents



function validate_form(&$frm, &$errors) {
/* validate the forgot password form, and return the error messages in a string.
 * if the string is empty, then there are no errors */

        $errors = new Object;
        $msg = "";

        if (empty($frm["oldpassword"])) {
                $errors->oldpassword = true;
                $msg .= "You did not specify your old password";

        } elseif (! password_valid($frm["oldpassword"])) {
                $errors->oldpassword = true;
                $msg .= "Your old password is invalid";

        } elseif (empty($frm["newpassword"])) {
                $errors->newpassword = true;
		 $msg .= "You did not specify your new password";

        } elseif (empty($frm["newpassword2"])) {
                $errors->newpassword2 = true;
                $msg .= "You did not confirm your new password";

        } elseif ($frm["newpassword"] != $frm["newpassword2"]) {
                $errors->newpassword = true;
                $errors->newpassword2 = true;
                $msg .= "Your new passwords do not match";
        }

        return $msg;
}//end validate_form




function password_valid($password) {
/* return true if the user's password is valid */

        global $_SESSION;

        $username = $_SESSION["userName"];
        $password = md5($password);

        $qid = db_query("SELECT 1 FROM users WHERE userName = '$username' AND password = '$password'");
        return db_num_rows($qid);
}
function update_password($newpassword) {
/* set the user's password to the new one */

        global $_SESSION;

        $username = $_SESSION["userName"];
        $newpassword = md5($newpassword);

        $qid = db_query("UPDATE users SET password = '$newpassword' WHERE userName = '$username'");
}//end update_password



/* validate the signup form, and return the error messages in a string.  if
 * the string is empty, then there are no errors */
function validate_formr(&$frm, &$errors) {

//declare new instance of validation class
        $validator = new Validator();

        $key=substr($_SESSION['key'],0,5);
		      $number = $_REQUEST['number'];

$errors = new Object;
        $msg = "";

        if (empty($frm["username"])) {
                $errors->username = true;
                $msg .= "-You did not specify a username";

        } elseif (username_exists($frm["username"])) {
                $errors->username = true;
                $msg .= "-The username <b>" . ov($frm["username"]) ."</b> already exists";

        } elseif (empty($frm["password"])) {
                $errors->password = true;
                $msg .= "-You did not specify a password";

	} elseif ($frm["password"] != $frm["password2"]) {
                $errors->password = true;
                $errors->password2 = true;
                $msg .= "Your passwords do not match";

        } elseif (empty($frm["email"])) {
                $errors->email = true;
		$msg .= "-You did not specify your email address";

        }

        elseif (email_exists($frm["email"])) {
                $errors->email = true;
                $msg .= "-The email address <b>" . ov($frm["email"]) ."</b> already exists";

        }

        elseif ($number!=$key){
		          $errors->code = true;
		$msg .= "-Your Code is invalid";

		}


        return $msg;
}//end validate


function insert_user(&$frm) {
/* add the new user into the database */

        $qid = db_query("
        INSERT INTO users (userName, password,privilege , email ,joined ,lastconnect
        ) VALUES (
                '$frm[username]'
                ,'" . md5($frm["password"]) ."'
                ,'user'
                ,'$frm[email]'
                ,NOW()
                ,NOW()
        )");
}

//function connect ($dbhost, $dbuser, $dbpass, $database)
//{
//$errormes = 'The sql server has encountered a problem, we are trying to fix it as soon as possible';
//@$connection = mysql_connect($dbhost, $dbuser, $dbpass);
//@mysql_select_db($database) or die($errormes);
//}

?>

