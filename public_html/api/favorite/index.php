<?php
require_once(dirname(__DIR__,3) . "/vender/autoload.php";
require_once(dirname(__DIR__,3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\DataDesign\ {
	Favorite
};
/**
 * api for the Favorite class
 *
 * @author Shihlin Lu <slu5@cnm.edu>
 */

// verify the session; start if it is not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty

