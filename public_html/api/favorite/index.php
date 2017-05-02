<?php
require_once(dirname(__DIR__,3) . "/vendor/autoload.php";
require_once(dirname(__DIR__,3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("encrypted-config.php file goes here");

use Edu\Cnm\DataDesign\ {
	Favorite
};
/**
 * api for the Favorite class
 *
 * @author Shihlin Lu <slu5@cnm.edu>
 * @version 1.0
 */

// verify the session; start if it is not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try{
	// grab the mySQL connection
	$pdo = connectToEncryptedMySql(".ini file goes here");

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$profile
}
};
