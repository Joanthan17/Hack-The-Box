<?

include("../config.php");
require_login();

/* form has been submitted, check if it the user login information is correct */
if (match_referer() && isset($_POST)) {
	$frm = $_POST;
	$errormsg = validate_form($frm, $errors);

	if (empty($errormsg)) {
		update_password($frm["newpassword"]);
		$noticemsg = "Password change successful";
	}
}

$DOC_TITLE = "Change Password";
include("$CFG->templatedir/header.php");
include("$CFG->templatedir/form_header.php");
include("templates/change_password_form.php");
include("$CFG->templatedir/footer.php");

/******************************************************************************
 * FUNCTIONS
 *****************************************************************************/

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
}

function password_valid($password) {
/* return true if the user's password is valid */

	global $_SESSION;
	
	$username = $_SESSION["userName"];
	$password = md5($password);

	$qid = db_query("SELECT 1 FROM users WHERE username = '$username' AND password = '$password'");
	return db_num_rows($qid);
}

function update_password($newpassword) {
/* set the user's password to the new one */

	global $_SESSION;
	
	$username = $_SESSION["userName"];
	$newpassword = md5($newpassword);

	$qid = db_query("UPDATE users SET password = '$newpassword' WHERE username = '$username'");
}

?>
