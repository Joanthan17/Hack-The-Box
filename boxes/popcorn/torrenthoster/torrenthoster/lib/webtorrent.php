<?php
/*This file will contain any functions that were written for the WTcom project*/

function is_logged_in() {
/* this function will return true if the user has logged in.  a user is logged
 * in if the $USER["user"] is set (by the login.php page) and also if the
 * remote IP address matches what we saved in the session ($USER["ip"])
 * from login.php -- this is not a robust or secure check by any means, but it
 * will do for now */

	global $_SESSION;

	return isset($_SESSION['userName'])
		&& !empty($_SESSION['password'])
		&& nvl($_SESSION["ip"]) == $_SERVER["REMOTE_ADDR"];
}

function require_login() {
/* this function checks to see if the user is logged in.  if not, it will show
 * the login screen before allowing the user to continue */

	global $CFG, $_SESSION;

	if (! is_logged_in()) {
		$_SESSION["wantsurl"] = qualified_me();
		redirect("$CFG->wwwroot/login.php");
	}
}
function require_priv($priv) {
/* this function checks to see if the user has the privilege $priv.  if not,
 * it will display an Insufficient Privileges page and stop */

	global $_SESSION;

	if ($_SESSION["privilege"] != $priv) {
		include("$CFG->templatedir/insufficient_privileges.php");
		die;
	}
}

function has_priv($priv) {
 /*returns true if the user has the privilege $priv*/

	global $_SESSION;

	return $_SESSION["privilege"] == $priv;
}
function err(&$errorvar) {
/* if $errorvar is set, then print an error marker << */

	if (isset($errorvar)) {
		echo "<font color=#ff0000>&lt;&lt;</font>";
	}
}

function err2(&$errorvar) {
/* like err(), but prints the marker >> */

	if (isset($errorvar)) {
		echo "<font color=#ff0000>&gt;&gt;</font>";
	}
}

function verifyTorrent($hash)
{
    $query = "SELECT COUNT(*) FROM summary where info_hash=\"$hash\"";
    $results = mysql_query($query);

    $res = mysql_result($results,0,0);

    if ($res == 1)
        return true;

    if ($GLOBALS["dynamic_torrents"])
        return makeTorrent($hash);

    return false;
}

function verifyHash($input)
{
    if (strlen($input) === 40 && preg_match('/^[0-9a-f]+$/', $input))
        return true;
    else
        return false;
}

function updatedata() {

    require_once("getscrape.php");

    global $update_interval;

    if ((0+$update_interval)==0)
       return;

    $now = time();


    $res = @mysql_query("SELECT last_time FROM tasks WHERE task='update'");
    $row = @mysql_fetch_array($res);
    if (!$row) {
        mysql_query("INSERT INTO tasks (task, last_time) VALUES ('update',$now)");
//die("INSERT INTO tasks (task, last_time) VALUES ('update',$now)");
        return;
    }
    $ts = $row[0];
    if ($ts + $update_interval > $now)
        return;


    mysql_query("UPDATE tasks SET last_time=$now WHERE task='update' AND last_time = $ts");
    if (!mysql_affected_rows())
        return;

    $res = mysql_query("SELECT * FROM namemap ORDER BY lastupdate ASC");
    if (!$res)
       return;
    $row = mysql_fetch_array($res);

    scrape($row["announce_url"],$row["info_hash"]);


}


function username_exists($username) {
/* returns the true if the username exists */

	$qid = db_query("SELECT 1 FROM users WHERE userName = '$username'");
	return db_num_rows($qid);
}

function email_exists($email) {
/* returns true the email address exists */

	$qid = db_query("SELECT 1 FROM users WHERE email = '$email'");
	return db_num_rows($qid);
}
function generate_password($maxlen=10) {
/* generate a random password thats thats at most $maxlen characters long
 * by putting 2 vowels after a consenant until into a password until we've
 * reached or surpassed $maxlen.  finally, trim the password and replace
 * one of the characters with a number.  note, we don't include 1 or 0
 * in the number so it doesn't get confused with I or O's
 */

	$C = "bcdfghjkmnpqrstvwxz";
	$V = "aeiouy";
	$totalC = strlen($C)-1;
	$totalV = strlen($V)-1;

	$pw = "";
	while (strlen($pw) < $maxlen) {
		$pw .= substr($C, rand(0, $totalC), 1)
			. substr($V, rand(0, $totalV), 1)
			. substr($V, rand(0, $totalV), 1);
	}

	$pw = substr($pw, 0, $maxlen);
	$pw[rand(0, strlen($pw) - 1)] = rand(2, 9);
	return $pw;
}
function reset_user_password($username) {
/* resets the password for the user with the username $username, and sends it
 * to him/her via email */

	global $CFG;

	/* load up the user record */
	$qid = db_query("SELECT id, userName, privilege, joined, lastconnect, email FROM users WHERE userName = '$username'");
	$user = db_fetch_object($qid);

	/* reset the password */
	$newpassword = generate_password();
	$qid = db_query("UPDATE users SET password = '" . md5($newpassword) ."' WHERE userName = '$username'");

	/* email the user with the new account information */
	$var = new Object;
	$var->username = $user->userName;
	$var->newpassword = $newpassword;
	$var->support = $CFG->support;

	$emailbody = read_template("$CFG->templatedir/email/reset_password.php", $var);

	mail(
		"$var->username <$user->email>",
		"Login Information",
		$emailbody,
		"From: $var->support");
}
function dateDropBox($query,$name){

	echo "<select name=\"".$name."\">";
	while($lb = db_fetch_object($query)){
	echo "<option>".$lb->fsDate."</option>";
	echo "<option>".$lb->ssDate."</option>";
	echo "<option>".$lb->tsDate."</option>";
	}//end while loop

	echo "</select>";

	}//end dateDropBox function

function timeDropBox($query,$name){
	echo "<select name=\"".$name."\">";
	while($lb = db_fetch_object($query)){
	echo "<option>".$lb->fsTime."</option>";
	echo "<option>".$lb->ssTime."</option>";
	echo "<option>".$lb->tsTime."</option>";
	}//end while loop

	echo "</select>";

	}//end timeDropBox function

function bulkMail($qs){

	$qid = db_query($qs);
	if($qid){
	$counter = 1;
	while($r=db_fetch_object($qid)){

	if($counter == 1){
	 $to = $r->email;
	 $counter++;
	}//end if statement with counter
	else{
	 $to .= ",".$r->email;
	}//end else
	}//end while
	}//end if
	else
	echo "something went wrong";

	if(isset($to))
	return $to;
	else{
	$to = 'No emails in list';
	return $to;
	}

}


function getMessageToUpdate(){
	$qs = "SELECT message FROM messageBoard";
	$qid = db_query($qs);
	$messageToUpdate = db_fetch_array($qid);
	return $messageToUpdate['message'];
}

function updateMessageBoard($message){
$qs = "SELECT * FROM messageBoard";
$qid = db_query($qs);
if(db_num_rows($qid) == 0){
$qs = "INSERT INTO messageBoard VALUES($message)";
$qid = db_query($qs);
}else{
$qs = "UPDATE messageBoard SET message = '$message';";
$qid = db_query($qs);
}
}//end function updateMessageBoard

function genrelist() {

    $ret = array();
    $res = mysql_query("SELECT * FROM categories ORDER BY sort_index, id");

    while ($row = mysql_fetch_array($res))
        $ret[] = $row;

    return $ret;

}

function makesize($bytes) {
  if ($bytes < 1000 * 1024)
    return number_format($bytes / 1024, 2) . " KB";
  if ($bytes < 1000 * 1048576)
    return number_format($bytes / 1048576, 2) . " MB";
  if ($bytes < 1000 * 1073741824)
    return number_format($bytes / 1073741824, 2) . " GB";
  return number_format($bytes / 1099511627776, 2) . " TB";
}

function printlasttorrents(){
	global $CFG, $ME;
	/*connect($CFG->host, $CFG->dbUserName, $CFG->dbPassword, $CFG->dbName);*/
	$qid=db_query("SELECT namemap.info_hash as hash, namemap.seeds, namemap.leechers, namemap.download,
	format( namemap.finished, 0  ) as finished, namemap.filename, namemap.filename2, namemap.url, namemap.registration as reg, namemap.info, UNIX_TIMESTAMP( namemap.data ) as added, categories.image, categories.name as cname, namemap.category as catid, namemap.size, namemap.uploader FROM namemap LEFT  JOIN categories ON categories.id = namemap.category ORDER BY namemap.data DESC");
	include("templates/torrents_list.php");
}


function printmosttorrents($limit){
	global $CFG, $ME;
	$qid=db_query("SELECT namemap.info_hash as hash, namemap.seeds, namemap.leechers, namemap.download,
	format( namemap.finished, 0  ) as finished, namemap.filename, namemap.filename2, namemap.url, namemap.registration as reg, namemap.info, UNIX_TIMESTAMP( namemap.data ) as added, categories.image, categories.name as cname, namemap.category as catid, namemap.size, namemap.uploader FROM namemap LEFT  JOIN categories ON categories.id = namemap.category ORDER BY download DESC LIMIT $limit");
	include("templates/torrents_list.php");
}


function printnews($limit){
global $CFG, $ME;

	$qid=db_query("SELECT news_id, title, content, author, email, DATE_FORMAT(date, '%d/%m/%y') AS date, TIME_FORMAT(time, '%k:%i:%S %p') AS time FROM news ORDER BY news_id DESC LIMIT $limit");

	include("templates/news.php");
}

function printnews2($limit){
global $CFG, $ME;

	$qid=db_query("SELECT news_id, title, content, author, email, DATE_FORMAT(date, '%d/%m/%y') AS date, TIME_FORMAT(time, '%k:%i:%S %p') AS time FROM news ORDER BY news_id DESC LIMIT $limit");

	include("templates/news2.php");
}

function printdownloads($limit){
global $CFG, $ME;

	$qid=db_query("SELECT * FROM downloads ORDER BY id DESC LIMIT $limit");

	include("templates/downloads.php");
}




?>
