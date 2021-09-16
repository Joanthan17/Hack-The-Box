<?

/******************************************************************************
 * MAIN
 *****************************************************************************/

include("config.php");

/* form has been submitted, check if it the user login information is correct */
if (/*match_referer() && */isset($_POST["username"]) && isset($_POST["password"])) {
	$user = verify_login($_POST["username"], $_POST["password"]);

	if ($user) {
		$_SESSION["userName"] = $user->userName;
		$_SESSION["password"] = $user->password;
		$_SESSION["privilege"] = $user->privilege;
		$_SESSION["email"] = $user->email;
		$_SESSION["ip"] = $_SERVER["REMOTE_ADDR"];

		/* if wantsurl is set, that means we came from a page that required
		 * log in, so let's go back there.  otherwise go back to the main page */
		$goto = empty($_SESSION["wantsurl"]) ? $CFG->wwwroot : $_SESSION["wantsurl"];
		header("Location: $goto");
		die;

	} else {
		$errormsg = "Invalid login, please try again";
		$frm["username"] = $_POST["username"];
	}
}
include("$CFG->templatedir/header.php");
include("$CFG->templatedir/login_form.php");
include("$CFG->templatedir/footer.php");
/******************************************************************************
 * FUNCTIONS
 *****************************************************************************/

function verify_login($username, $password) {
/* verify the username and password.  if it is a valid login, return an array
 * with the username, firstname, lastname, and email address of the user */

	if (empty($username) || empty($password)) return false;

	$qid = db_query("
	SELECT userName, password, privilege, email
	FROM users
	WHERE userName = '$username' AND password = '" . md5($password) . "'
	");

	return db_fetch_object($qid);
}

?>
