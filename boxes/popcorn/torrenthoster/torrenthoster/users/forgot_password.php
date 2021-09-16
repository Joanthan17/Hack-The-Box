<?

include("../config.php");
require_once("../validator.php");


/* form has been submitted, check if it the user login information is correct */
if (/*match_referer() && */isset($_POST['email'])) {
	$frm = $_POST;
	$errormsg = validate_form($frm, $errors);

	if (empty($errormsg)) {
		$username = get_username($_POST["email"]);
		reset_user_password($username);

		$DOC_TITLE = "$CFG->webname Password Recovery";
		include("$CFG->templatedir/header.php");
		include("templates/forgot_password_success.php");
		include("$CFG->templatedir/footer.php");
		die;
	}
}
	
include("$CFG->templatedir/header.php");
include("templates/forgot_password_form.php");
include("$CFG->templatedir/footer.php");
/******************************************************************************
 * FUNCTIONS
 *****************************************************************************/

function validate_form(&$frm, &$errors) {
/* validate the forgot password form, and return the error messages in a string.
 * if the string is empty, then there are no errors */

	$errors = new Object;
	$msg = "";

	if (empty($frm["email"])) {
		$errors->email = true;
		$msg .= "You did not specify your email address";

	} elseif (! email_exists($frm["email"])) {
		$errors->email = true;
		$msg .= "The specified email address is not on file";
	}

	return $msg;
}

function get_username($email) {
/* get the username based on an email address */

	$qid = db_query("SELECT userName FROM users WHERE email = '$email'");
	$user = db_fetch_object($qid);

	return $user->userName;
}

?>
