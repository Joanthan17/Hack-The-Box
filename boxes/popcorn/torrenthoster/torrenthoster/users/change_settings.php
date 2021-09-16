<?

include("../config.php");
require_login();

/* form has been submitted, check if it the user login information is correct */
if (match_referer() && isset($_POST)) {
	$frm = $_POST;
	$errormsg = validate_form($frm, $errors);

	if (empty($errormsg)) {
		update_settings($frm);
		$noticemsg = "Settings change successful";
	}
} else {
	$frm = load_user_profile();
}

$DOC_TITLE = "Change Settings";
include("$CFG->templatedir/header.php");
include("$CFG->templatedir/form_header.php");
include("templates/change_settings_form.php");
include("$CFG->templatedir/footer.php");

/******************************************************************************
 * FUNCTIONS
 *****************************************************************************/

function load_user_profile() {
/* load up the user's details */

	global $_SESSION;
	
	$username = $_SESSION["userName"];
	$qid = db_query("SELECT id_level , email , joined , lastconnect 
	                 FROM users WHERE username = '$username'");
	return db_fetch_array($qid);
}

function validate_form(&$frm, &$errors) {
/* validate the signup form, and return the error messages in a string.  if
 * the string is empty, then there are no errors */

	$errors = new Object;
	$msg = "";

	
	if (empty($frm["name"])) {
		$errors->name = true;
		$msg .= "<li>You did not specify your Name";

	} elseif (empty($frm["email"])) {
		$errors->email = true;
		$msg .= "<li>You did not specify your email address";

	       	}
	return $msg;
}

function update_settings(&$frm) {
/* set the user's settings to the new ones */

	global $_SESSION;
	
	$username = $_SESSION["userName"];
	
	$qid = db_query("
	UPDATE users SET
		 name = '$frm[name]'
		 ,email = '$frm[email]'
	WHERE username = '$username'
	");
}

?>
