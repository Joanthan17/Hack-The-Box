<?

include "config.php";
switch (nvl($_REQUEST["mode"])) {
case "downloads" :
	    printdownloads(50);
		break;
}
?>