<?
function hex2bin ($input, $assume_safe=true)
{
    if ($assume_safe !== true && ! ((strlen($input) % 2) === 0 || preg_match ('/^[0-9a-f]+$/i', $input)))
        return "";
    return pack('H*', $input );
}
function setdefault(&$var, $default="") {
/* if $var is undefined, set it to $default.  otherwise leave it alone */

	if (! isset($var)) {
		$var = $default;
	}
}

function nvl(&$var, $default="") {
/* if $var is undefined, return $default, otherwise return $var */

	return isset($var) ? $var : $default;
}

function evl(&$var, $default="") {
/* if $var is empty, return $default, otherwise return $var */

	return empty($var) ? $var : $default;
}

function ov(&$var) {
/* returns $var with the HTML characters (like "<", ">", etc.) properly quoted,
 * or if $var is undefined, will return an empty string.  note this function
 * must be called with a variable, for normal strings or functions use o() */

	return o(nvl($var));
}

function pv(&$var) {
/* prints $var with the HTML characters (like "<", ">", etc.) properly quoted,
 * or if $var is undefined, will print an empty string.  note this function
 * must be called with a variable, for normal strings or functions use p() */

	p(nvl($var));
}

function o($var) {
/* returns $var with HTML characters (like "<", ">", etc.) properly quoted,
 * or if $var is empty, will return an empty string. */

	return empty($var) ? "" : htmlSpecialChars(stripslashes($var));
}

function p($var) {
/* prints $var with HTML characters (like "<", ">", etc.) properly quoted,
 * or if $var is empty, will print an empty string. */

	echo o($var);
}

function jstring($var) {
/* returns string that is quoted for javascript */

	return addslashes($var);
}

function db_query_loop($query, $prefix, $suffix, $found_str, $default="") {
/* this is an internal function and normally isn't called by the user.  it
 * loops through the results of a select query $query and prints HTML
 * around it, for use by things like listboxes and radio selections
 *
 * NOTE: this function uses dblib.php */

	$output = "";
	$result = db_query($query);
	while (list($val, $label) = db_fetch_row($result)) {
		if (is_array($default))
			$selected = empty($default[$val]) ? "" : $found_str;
		else
			$selected = $val == $default ? $found_str : "";

		$output .= "$prefix value='$val' $selected>$label$suffix";
	}

	return $output;
}

function db_listbox($query, $default="", $suffix="\n") {
/* generate the <option> statements for a <select> listbox, based on the
 * results of a SELECT query ($query).  any results that match $default
 * are pre-selected, $default can be a string or an array in the case of
 * multi-select listboxes.  $suffix is printed at the end of each <option>
 * statement, and normally is just a line break */

	return db_query_loop($query, "<option", $suffix, "selected", $default);
}

function strip_querystring($url) {
/* takes a URL and returns it without the querystring portion */

	if ($commapos = strpos($url, '?')) {
		return substr($url, 0, $commapos);
	} else {
		return $url;
	}
}

function get_referer() {
/* returns the URL of the HTTP_REFERER, less the querystring portion */

	return strip_querystring(nvl($_SERVER["HTTP_REFERER"]));
}

function me() {
/* returns the name of the current script, without the querystring portion.
 * this function is necessary because PHP_SELF and REQUEST_URI and PATH_INFO
 * return different things depending on a lot of things like your OS, Web
 * server, and the way PHP is compiled (ie. as a CGI, module, ISAPI, etc.) */

	if (isset($_SERVER["REQUEST_URI"])) {
		$me = $_SERVER["REQUEST_URI"];

	} elseif ($_SERVER["PATH_INFO"]) {
		$me = $_SERVER["PATH_INFO"];

	} elseif ($_SERVER["PHP_SELF"]) {
		$me = $_SERVER["PHP_SELF"];
	}

	return strip_querystring($me);
}

function qualified_me() {
/* like me() but returns a fully URL */

	$protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "https://" : "http://";
	$url_prefix = "$protocol$_SERVER[HTTP_HOST]";
	return $url_prefix . me();
}

function match_referer($good_referer = "") {
/* returns true if the referer is the same as the good_referer.  If
 * good_refer is not specified, use qualified_me as the good_referer */

	if ($good_referer == "") { $good_referer = qualified_me(); }
	return $good_referer == get_referer();
}

function redirect($url, $message="", $delay=0) {
/* redirects to a new URL using meta tags */
	echo "<meta http-equiv='Refresh' content='$delay; url=$url'>";
	if (!empty($message)) echo "<br><br><br><br><br><div style='font-family: Arial, Sans-serif; font-size: 20pt;' align=center>$message</div>";
	die;
}

function read_template($filename, &$var) {
/* return a (big) string containing the contents of a template file with all
 * the variables interpolated.  all the variables must be in the $var[] array or
 * object (whatever you decide to use).
 *
 * WARNING: do not use this on big files!! */

	$temp = str_replace("\\", "\\\\", implode(file($filename), ""));
	$temp = str_replace('"', '\"', $temp);
	eval("\$template = \"$temp\";");
	return $template;
}

function checked(&$var, $set_value = 1, $unset_value = 0) {
/* if variable is set, set it to the set_value otherwise set it to the
 * unset_value.  used to handle checkboxes when you are expecting them from
 * a form */

	if (empty($var)) {
		$var = $unset_value;
	} else {
		$var = $set_value;
	}
}

function frmchecked(&$var, $true_value = "checked", $false_value = "") {
/* prints the word "checked" if a variable is true, otherwise prints nothing,
 * used for printing the word "checked" in a checkbox form input */

	if ($var) {
		echo $true_value;
	} else {
		echo $false_value;
	}
}

function mysql_timestamp($dt, $blank="") {
/* returns formatted MySQL timestamp, or $blank if it's blank */

	if (empty($dt)) return $blank;

	$yr = strval(substr($dt,0,4));
	$mo = strval(substr($dt,4,2));
	$da = strval(substr($dt,6,2));
	$hr = strval(substr($dt,8,2));
	$mi = strval(substr($dt,10,2));

	return date("m/d/Y", mktime($hr,$mi,0,$mo,$da,$yr));
}
function quote_smart($value)
{
   // Stripslashes
   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }
   // Quote if not integer
   if (!is_numeric($value)) {
       $value = "'" . mysql_real_escape_string($value) . "'";
   }
   return $value;
}

?>
