<?php
/*This file destroys all $_SESSION superglobals and redirects to the main page*/

//include config file
include "config.php";

//reinitialize the $_SESSION superglobal
$_SESSION = array();
//destroy session
session_destroy();

//redirect to homepage after destoying session
redirect("$CFG->wwwroot", "Logging Out", 1);


?>