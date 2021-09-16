<?

include("../config.php");
include "../validator.php";
require_login();
require_priv("admin");

$DOC_TITLE = "$CFG->webname -  Admin";
if (nvl($_REQUEST["mode"]) != "print")
include("templates/header.php");

switch (nvl($_REQUEST["mode"])) {
	case "add" :
		print_add_user_form($something = "");
		break;

	case "edit" :
		print_edit_user_form($_REQUEST["username"]);
		break;

	case "del" :
		delete_user($_REQUEST["username"]);
		print_user_list();
		break; 

	case "insert" :
		$frm = $_POST;
		$errormsg = validate_form($frm, $errors);
		if (empty($errormsg)) {
		insert_user($frm);
		print_user_list();
		}
		else {
		include("$CFG->templatedir/form_header.php");
		print_add_user_form($frm);
		}
		break;

	case "update" :
		update_user($_POST);
		print_user_list();
		break;

	case "resetpw" :
		reset_user_password($_REQUEST["username"]);
		include("templates/user_password_reset.php");
		print_user_list();
		break;
	
	case "search" :
		$searchArray = $_POST;
		printSearchList($searchArray);
		break;
		
	default :
		  print_admin_list();
		break;
}

include("templates/footer.php");

/******************************************************************************
 * FUNCTIONS
 *****************************************************************************/

function print_add_user_form($oldForm) {
/* print a blank user form so we can add a new user */

	global $CFG, $ME;
	

	if($oldForm != ''){	
	$frm["username"]= $oldForm['username'];	
	$frm["email"]= $oldForm['email'];
		
	}//end if statment for passing bogus var
	$frm["newmode"] = "insert";
	$frm["submit_caption"] = "Add User";

	/*Declare sql statments to populate radio buttons and questions from db*/

	include("templates/admin_signup_form.php");
}

function print_edit_user_form($username) {
/* print a user form so we can edit the selected user */

	global $CFG, $ME;

	/* load up the information for the user */
	$qid = db_query("
	SELECT userName, password, privilege, email, joined ,lastconnect
	FROM users
	WHERE userName = '$username'
	");
	$frm = db_fetch_array($qid);
	
	$frm["newmode"] = "update";
	$frm["submit_caption"] = "Save Changes";
	
	
	include("templates/user_form.php");
}

function delete_user($username) {
/* delete the user who's login is $username */

	global $CFG, $ME;

	$qid = db_query("DELETE FROM users WHERE username = '$username'");
	include("templates/user_deleted.php");
}

function insert_user($frm) {
/* add a user into the database, we should really have some good validation
 * routines to check for things like bad passwords, etc., but for the purpose
 * of this tutorial it's left to the reader (you) to add them in :) */

	/* add the new user into the database */

//convert time selection from radio button to generic var

	$qid = db_query("
	INSERT INTO users (userName, password, privilege, email

	) VALUES (
		 '$frm[username]'
		,'" . md5($frm["password"]) ."'
		,'user'
		,'$frm[email]'
			)");
	include("templates/user_created.php");
}

function update_user($frm) {
/* update the user record in the database */

	$qid = db_query("
	UPDATE users SET
		
		userName= '$frm[userName]'
		,privilege = '$frm[privilege]'
		,email = '$frm[email]'
			WHERE userName = '$frm[userName]'
	");
}

function print_user_list() {
/* read all the categories from the database and print them into a table.  we
 * will use a template to display the listings to keep this main script clean */

	global $CFG, $ME;

	$qid = db_query("
	SELECT username, email, FROM users WHERE privilege != 'admin'
  	");

	include("templates/user_list.php");
}

function print_admin_list(){
	global $CFG, $ME;
	$qid = db_query("
	SELECT username, email
	FROM users WHERE privilege = 'admin'
  	");

	include("templates/user_list.php");
}


function validate_form(&$frm, &$errors) {
/* validate the signup form, and return the error messages in a string.  if
 * the string is empty, then there are no errors */
	
	//declare new instance of validation class 	
 	$validator = new Validator();
	
	$errors = new Object;
	$msg = "";

	if (empty($frm["username"])) {
		$errors->username = true;
		$msg .= "<li>You did not specify a username";

	} elseif (username_exists($frm["username"])) {
		$errors->username = true;
		$msg .= "<li>The username <b>" . ov($frm["userName"]) ."</b> already exists";

	} elseif (empty($frm["password"])) {
		$errors->password = true;
		$msg .= "<li>You did not specify a password";

	} elseif (empty($frm["email"])) {
		$errors->email = true;
		$msg .= "<li>You did not specify your email address";

		} 
	
	return $msg;
}

?>

