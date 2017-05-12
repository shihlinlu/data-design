<?php
require_once(dirname(__DIR__,3) . "/vendor/autoload.php";
require_once(dirname(__DIR__,3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("encrypted-config.php file goes here");

use Edu\Cnm\DataDesign\ {
	Profile,
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

	// mock a logged in user by mocking the session and assigning a specific user to it.
	// this is only for testing purposes and should not be in the live code.
	$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 732);

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	var_dump($method);

	// sanitize the search parameters
	$favoriteProfileId = filter_input(INPUT_GET, "FavoriteProfileId", FILTER_VALIDATE_INT);
	$favoriteItemId = filter_input(INPUT_GET, "favoriteItemId", FILTER_VALIDATE_INT);

	var_dump($favoriteProfileId);
	var_dump($favoriteItemId);

	if($method === "GET") {
		// set XSRF COOKIE
		setXsrfCookie();

		// gets a specific like associated based on its composite key
		if($favoriteProfileId !== null && $favoriteItemId !== null) {
			$favorite = Favorite::getFavoriteByFavoriteProfileIdAndFavoriteItemId($pdo, $favoriteProfileId, $favoriteItemId);

			if($favorite !== null) {
				$reply->data = $favorite;
			}
			// if none of the search parameters are met then throw an exception
		} else if(empty($favoriteProfileId) === false) {
			$favorite = Favorite::getFavoriteByFavoriteProfileId($pdo, $favoriteProfileId)->toArray();

			if($favorite !== null) {
				$reply->data = $favorite;
			}
			// get all the favorites associated with the favoriteId
		} else if(empty($favoriteItemId) === false) {
			$favorite = Favorite::getFavoriteByFavoriteId($pdo, $favoriteItemId)->toArray();

			if($favorite !== null) {
				$reply->data = $favorite;
			}
		} else {
			throw new InvalidArgumentException("incorrect search parameters");
		}

} else if(empty($requestObject->favoriteProfileId) === true) {
		throw(new \InvalidArgumentException("No profile linked to the "))
	}
};
