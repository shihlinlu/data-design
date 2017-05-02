<?php
require_once(dirname(__DIR__,3) . "/vendor/autoload.php";
require_once(dirname(__DIR__,3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("encrypted-config.php file goes here");

use Edu\Cnm\DataDesign\ {
	Profile
};
/**
 * api for the Profile class
 *
 * @author Shihlin Lu <slu5@cnm.edu>
 */

// verify the session; start if it is not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data= null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL(".ini file goes here");

	// mock a logged in user by mocking the session and assigning a specific user to it.
	// this is only for testing purposes and should not be used in live code
	//$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 732);

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$profileUsername = filter_input(INPUT_GET, "profileUsername", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_EMAIL);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_VALIDATE_EMAIL);

	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id <0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	//handle GET request - if id is present, that profile is returned
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		// get a specific profile
		if(empty($id) === false) {
			$profile = Profile::getProfileByProfileId($pdo, $id);

			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($profileUsername) === false) {
			$profile = Profile::getProfileByProfileUsername($pdo, $profileUsername);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($profileEmail) === false) {
			$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
			if($profile !== null) {
				$reply->data = $profile;
			}
		}
	} elseif($method === "PUT") {
		// enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}

		// decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// retrieve the profile to be updated
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist", 404));
		}

		if(empty($requestObject->newPassword) === true) {

			// enforce that the XSRF token is present in the header
			verifyXsrf();

			//profile username
			if(empty($requestObject->profileUsername) === true) {
				throw(new \InvalidArgumentException("No profile username", 405));
			}

			//profile email is a required field
			if(empty($requestObject->profileEmail) === true) {
				throw(new \InvalidArgumentException("No profile email present", 405));
			}

			$profile->setProfileUserName($requestObject->profileUsername);
			$profile->setProfileEmail($requestObject->profileEmail);
			$profile->setProfileLocation($requestObject->profileLocation);
			$profile->setProfileHash($requestObject->profileHash);
			$profile->setProfileSalt($requestObject->profileSalt);
			$profile->update($pdo);

			// update reply
			$reply->message = "Profile information updated";
		}

		/**
		 * update the password if requested
		 **/
		// enforce that the current password is present and confirmed
		if(empty($requestObject->ProfilePassword) === false && empty($requestObject-profileConfirmPassword) === false && empty($requestContent->ConfirmPassword) === false) {
			// make sure the new password and confirm password exist
			if($requestObject->newProfilePassword !== $requestObject->profileConfirmPassword) {
				throw(new RuntimeException("New passwords do not match", 401));
			}

			// hash the previous password
			$currentPasswordHash = hash_pbkdf2("sha512", $requestObject->currentProfilePassword, $profile->getProfileSalt(), 262144);

			// make sure the hash given by the end user matches what is in the database
			if($currentPasswordHash !== $profile->getProfileHash()) {
				throw(new \RuntimeException("Old password is incorrect", 401));
			}

			// salt and hash the new password and update the profile object
			$newPasswordSalt = bin2hex(random_bytes(16));
			$newPasswordHash = hash_pbkdf2("sha512", $requestObject->newProfilePassword, $newPasswordSalt, 262144);
			$profile->setProfileHash($newPasswordHash);
			$profile->setProfileSalt($newProfileSalt);
		}

		// perform the actual update to the database and update the message
		$profile->update($pdo);
		$reply->message = "profile password successfully updated";

	} elseif($method === "DELETE") {

		// verify the XSRF Token
		verifyXsrf();

		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist"));
		}

		// enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}

		// delete the post from the database
		$profile->delete($pdo);
		$reply->message = "Profile Deleted";

	} else {
		throw(new InvalidArgumentException("Invalid HTTP request", 400));
	}
	// catch any exceptions that were thrown and update the status and message state variable fields
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to the front end caller
echo json_encode($reply);