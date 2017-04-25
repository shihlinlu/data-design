<?php
/**
 * Small Cross Section of a Contempo Design Profile
 *
 * This Item can be treated as a small example of what eCommerce websites like Contempo Design store when profiles are created using Contempo Design.
 *
 * @author Shihlin Lu <slu5@cnm.edu>
 * @version 1.0.0
 **/
class Profile implements \JsonSerializable {
	/**
	 * id for this Profile; this is the primary key
	 * @var int $profileId
	 */
	private $profileId;
	/**
	 * activation token for this Profile
	 * @var string $profileActivationToken
	 */
	private $profileActivationToken;
	/**
	 * email address for this Profile; this is unique
	 * @var string $profileEmail
	 **/
	private $profileEmail;
	/**
	 * hash for this Profile password
	 * @var string $profileHash
	 */
	private $profileHash;
	/**
	 * salt for this Profile password
	 * @var string $profileSalt
	 **/
	private $profileSalt;
	/**
	 * username for this Profile; this is unique
	 * @var string $profileUsername
	 **/
	private $profileUsername;
	/**
	 * location for this Profile
	 * @var string $profileLocation
	 **/
	private $profileLocation;
	/**
	 * constructor for this Profile
	 *
	 * @param int|null $newProfileId id of this Profile or null if a new Profile
	 * @param string $newProfileActivationToken string containing the activation token of this Profile
	 * @param string $newProfileEmail string containing the email address for this Profile
	 * @param string $newProfileHash string containing the hash of the Profile password
	 * @param string $newProfileSalt string containing the salt of the Profile password
	 * @param string $newProfileUsername string containing the username of the Profile
	 * @param string $newProfileLocation string containing the location of the Profile
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers, negative floats)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newProfileId, string $newProfileActivationToken, string $newProfileEmail, string $newProfileHash, string $newProfileSalt, string $newProfileUsername, string $newProfileLocation) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfileSalt($newProfileSalt);
			$this->setProfileUsername($newProfileUsername);
			$this->setProfileLocation($newProfileLocation);
		} // determine what exception was thrown
		catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0 , $exception));
		}
	}
	/**
	 * accessor method for profile id
	 * @return int|null value of profile id
	 */
	public function getProfileId(): ?int {
		return($this->profileId);
	}
	/**
	 * mutator method for profile id
	 *
	 * @param int|null $newProfileId new value of Profile id
	 * * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setProfileId(?int $newProfileId): void {
		// if profile id is null immediately return it
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}
		// verify the profile id is positive
		if($newProfileId <= 0) {
			throw(new \ RangeException("profile id is not positive"));
		}
		// convert and store the profile id
		$this->profileId = $newProfileId;
	}
	/**
	 * accessor method for profile activation token
	 * @return string value of activation token of profile
	 **/
	public function getProfileActivationToken(): string {
		return($this->profileActivationToken);
	}
	/**
	 * mutator method for profile activation token (32 characters)
	 *
	 * @param string $newProfileActivationToken new activation token of profile
	 * @throws \InvalidArgumentException if $newProfileActivationToken is not secure
	 * @throws \RangeException if $newProfileAProfileActivationToken is not 32 characters
	 * @throws \TypeError if $newProfileActivationToken is not a string
	 **/
	public function setProfileActivationToken(string $newProfileActivationToken): void {
		// ensure that the activation token is properly formatted
		$newProfileActivationToken = trim($newProfileActivationToken);
		$newProfileActivationToken = strtolower($newProfileActivationToken);
		if(empty($newProfileActivationToken) === true) {
			throw(new \InvalidArgumentException("user activation token is empty or insecure"));
		}
		// ensure that the activation token is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileActivationToken)) {
			throw(new \InvalidArgumentException("user activation token is not valid"));
		}
		// ensure that the activation token is exactly 32 characters
		if(strlen($newProfileActivationToken) !== 32) {
			throw(new \RangeException("user activation token is not 32 characters"));
		}
		// convert and store the activation token
		$this->profileActivationToken = $newProfileActivationToken;
	}
	/**
	 * accessor method for profile email
	 * @return string value of profile email
	 **/
	public function getProfileEmail(): string {
		return($this->profileEmail);
	}
	/**
	 *  mutator method for profile email
	 *
	 * @param string $newProfileEmail new value of profile email
	 * @throws \InvalidArgumentException if $newProfileEmail is not a string or insecure
	 * @throws \RangeException if $newProfileEmail is not positive
	 * @throws \TypeError if $newProfileEmail is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail): void {
		// verify that the profile email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty, invalid, or insecure"));
		}
		// verify that the email will fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("profile email is too large"));
		}
		// store the profile email
		$this->profileEmail = $newProfileEmail;
	}
	/**
	 * accessor method for hash
	 * @return string value of profile password hash
	 */
	public function getProfileHash(): string {
		return($this->profileHash);
	}
	/**
	 * mutator method for hash
	 *
	 * @param string $newProfileHash new value of profile password hash
	 * @throws \InvalidArgumentException if $newProfileHash is not secure
	 * @throws \RangeException if $newProfileHash is not 128 characters
	 * @throws \TypeError if $newProfileHash is not a string
	 **/
	public function setProfileHash(string $newProfileHash): void {
		// ensure that the hash is properly formatted
		$newProfileHash = trim($newProfileHash);
		$newProfileHash = strtolower($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure "));
		}
		// ensure that the hash is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileHash)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}
		// ensure that the hash is exactly 128 characters
		if(strlen($newProfileHash) !== 128) {
			throw(new \InvalidArgumentException("profile password hash must be 128 characters"));
		}
		// convert and store hash
		$this->profileHash = $newProfileHash;
	}
	/**
	 * accessor method for salt
	 * @return string value of profile password salt
	 **/
	public function getProfileSalt(): string {
		return($this->profileSalt);
	}
	/**
	 * mutator method for salt
	 *
	 * @param string $newProfileSalt new value of profile password salt
	 * @throws \InvalidArgumentException if $newProfileSalt is not secure
	 * @throws \RangeException if $newProfileSalt is not 64 characters
	 * @throws \TypeError if $newProfileSalt is not a string
	 **/
	public function setProfileSalt(string $newProfileSalt): void {
		// ensure that the salt is properly formatted
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = strtolower($newProfileSalt);
		if(empty($newProfileSalt) === true) {
			throw(new \InvalidArgumentException("profile password salt is empty or insecure"));
		}
		// ensure that the salt is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileSalt)) {
			throw(new \InvalidArgumentException("profile password salt is empty or insecure"));
		}
		// ensure that the salt is exactly 64 characters
		if(strlen($newProfileSalt) !== 64) {
			throw(new \InvalidArgumentException("profile password salt must be 64 characters"));
		}
		// convert and store salt
		$this->profileSalt = $newProfileSalt;
	}
	/**
	 * accessor method for profile username
	 * @return string value of profile username
	 **/
	public function getProfileUsername(): string {
		return($this->profileUsername);
	}
	/**
	 * mutator method for profile username
	 *
	 * @param string $newProfileUsername new value of profile username
	 * @throws \InvalidArgumentException if $newProfileUsername is empty or insecure
	 * @throws \RangeException if $newProfileUsername is > 32 characters
	 * @throws \TypeError if $newProfileUsername is not a string
	 **/
	public function setProfileUsername(string $newProfileUsername): void {
		// verify that the username is secure
		$newProfileUsername = trim($newProfileUsername);
		$newProfileUsername = filter_var($newProfileUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileUsername) === true) {
			throw(new \InvalidArgumentException("profile username is empty or insecure"));
		}
		// verify that the username will fit in the database
		if(strlen($newProfileUsername) > 32) {
			throw(new \RangeException("profile username is too large"));
		}
		// convert and store the username
		$this->profileUsername = $newProfileUsername;
	}
	/**
	 * accessor method for profile location
	 * @return string value of profile location
	 **/
	public function getProfileLocation(): string {
		return($this->profileLocation);
	}
	/**
	 * mutator method for profile location
	 *
	 * @param string $newProfileLocation new value of profile location
	 * @throws \InvalidArgumentException if $newProfileLocation is empty or insecure
	 * @throws \RangeException if $newProfileLocation is < 50 characters
	 * @throws \TypeError if $newProfileLocation is not a string
	 **/
	public function setProfileLocation(string $newProfileLocation): void {
		// verify that the location is secure
		$newProfileLocation = trim($newProfileLocation);
		$newProfileLocation = filter_var($newProfileLocation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileLocation) === true) {
			throw(new \InvalidArgumentException("profile location is empty or insecure"));
		}
		// verify that the location will fit in the database
		if(strlen($newProfileLocation) > 50) {
			throw(new \RangeException("profile location is too large"));
		}
		// convert and store the location
		$this->profileLocation = $newProfileLocation;
	}












	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
}