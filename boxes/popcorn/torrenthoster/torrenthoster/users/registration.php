<?

include("../config.php");
require_once("../validator.php");





/* form has been submitted, try to create the new user account */
if (match_referer() || (isset($_POST['username']) && isset($_POST['email']))) {



/*************************************************************************/
	$frm = $_POST;
	$errormsg = validate_form($frm, $errors);

	if (empty($errormsg)) {
		insert_user($frm);

		$DOC_TITLE = "$CFG->webname - Registration Successful";
		include("$CFG->templatedir/header.php");
		include("templates/registration_success.php");
		include("$CFG->templatedir/footer.php");
		die;
	}
}


$DOC_TITLE = "$CFG->webname - Registration";
include("$CFG->templatedir/header.php");
include("$CFG->templatedir/form_header.php");
include("templates/signup_form.php");
include("$CFG->templatedir/footer.php");


/******************************************************************************
 * FUNCTIONS
 *****************************************************************************/

function validate_form(&$frm, &$errors) {
/* validate the signup form, and return the error messages in a string.  if
 * the string is empty, then there are no errors */

	//declare new instance of validation class
 	$validator = new Validator();

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


	} elseif (empty($frm["email"])) {
		$errors->email = true;
		$msg .= "-You did not specify your email address";

	}

	elseif (email_exists($frm["email"])) {
		$errors->email = true;
		$msg .= "-The email address <b>" . ov($frm["email"]) ."</b> already exists";

	}


	return $msg;
}

function insert_user(&$frm) {
/* add the new user into the database */

//convert time selection from radio button to generic var

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

?>
