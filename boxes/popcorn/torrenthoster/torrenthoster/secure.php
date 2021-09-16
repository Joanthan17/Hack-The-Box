<?php
/*
		Project : T-Xore    version     0.0.4      released     on 06/2006   By  Bogaa
		This piece of software is free to use by anyone and may be redistributed
		and modified by anyone in any way. We   can't be held   liable for damage
		or copyright infringement claims. Read the documentation!

		Bogaa's Homepage : http://www.meganova.org
		Project Homepage  : http://www.devnova.org
*/

global $_SESSION;

if( ($_SESSION['userName'] == "admin") || ($_SESSION['privilege'] == "admin") ) {

	include_once("login.php");
	exit;
}else{?>


<?php }?>