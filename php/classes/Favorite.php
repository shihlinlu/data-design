<?php
namespace Edu\Cnm\DataDesign;
require_once("autoload.php");
/**
 * Cross Section of a ContempoDesign Favorite
 *
 * This is a cross section of what occurs when a user favorites an Item. It is an intersection table (weak entity) of a m-to-n relationship between Profile and Item.
 *
 * @author Shihlin Lu <slu5@cnm.edu>
 * @version 1.0.0
 */
class Favorite implements \JsonSerializable {
	use ValidateDate;

	/**
	 * id of the Profile who favorited; this is a component of a composite primary key (and a foreign key)
	 * @var int $favoriteProfileId
	 */
	private $favoriteProfileId;

	/**
	 * id of the item being favorited; this is a component of a composite primary key (and a foreign key)
	 * @var int $favoriteItemId
	 **/
	private $favoriteItemId;

	/**
	 * date and time the item was favorited
	 * @var \DateTime favoriteDate
	 **/
	private $favoriteDate;

	/**
	 * constructor for this favorite
	 *
	 * @param int $newFavoriteProfileId id of the parent Profile
	 * @param int $newFavoriteItemId id of the parent Item
	 * @param \DateTime|null $newFavoriteDate date the item was favorited (or null for current time)
	 * @throws \Exception if some other exception occurs
	 * @throws \TypeError if data types violate type hints
	 * @documentation https://php.net/manual/en/language.oop5.decon.php
	 */
	public function __construct(int $newFavoriteProfileId, int $newFavoriteItemId, $newFavoriteDate = null) {
		try {
			$this->setFavoriteProfileId($newFavoriteProfileId);
			$this->setFavoriteItemId($newFavoriteItemId);
			$this->setFavoriteDate($newFavoriteDate);
		} // determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for favorite profile id
	 * @return int value of favorite profile id
	 **/
	public function getFavoriteProfileId(): int {
		return($this->favoriteProfileId);
	}
	/**
	 * mutator method for favorite profile id
	 *
	 * @param int $newFavoriteProfileId new value of profile id
	 * @throws \RangeException if $newFavoriteProfileId is not positive
	 * @throws \TypeError if $newFavoriteProfileId is not an integer
	 **/
	public function setFavoriteProfileId(int $newFavoriteProfileId): void {
		// verify that the profile id is positive
		if($newFavoriteProfileId <= 0) {
			throw(new \RangeException("profile id is not positive"));
		}
		// convert and store the favorite profile id
		$this->favoriteProfileId = $newFavoriteProfileId;
	}
	/**
	 * accessor method for favorite item id
	 * @return int value of favorite item id
	 **/
	public function getFavoriteItemId(): int {
		return($this->favoriteItemId);
	}
	/**
	 * mutator method for favorite item id
	 *
	 * @param int $newFavoriteItemId new value of item id
	 * @throws \RangeException if $newFavoriteItemId is not positive
	 * @throws \TypeError if $newFavoriteItemId is not an integer
	 **/
	public function setFavoriteItemId(int $newFavoriteItemId): void {
		// verify that the item id is positive
		if($newFavoriteItemId === null) {
			throw(new \RangeException("item id is not positive"));
		}
		// convert and store the item id
		$this->favoriteItemId = $newFavoriteItemId;
	}
	/**
	 * accessor method for favorite date
	 * @return \DateTime value of favorite date
	 **/
	public function getFavoriteDate() : \DateTime {
		return($this->favoriteDate);
	}
	/**
	 * mutator method for favorite date
	 *
	 * @param \DateTime|string|null $newFavoriteDate favorite date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newFavoriteDate is not a valid object or string
	 * @throws \RangeException if $newFavoriteDate is a nonexistent date
	 **/
	public function setFavoriteDate($newFavoriteDate) : void{
		// base case: if the date is null, use the current date and time
		if($newFavoriteDate === null) {
			$this->favoriteDate = new \DateTime();
			return;
		}
		// store the favorite date using ValidateDate trait
		try {
			$newFavoriteDate = self::validateDateTime($newFavoriteDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// store new favorite date
		$this->favoriteDate = $newFavoriteDate;
	}
	/**
	 * inserts this favorite into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	// ensure that the favorite object exists before inserting
	public function insert(\PDO $pdo) : void {
		if($this->favoriteProfileId === null || $this->favoriteItemId === null) {
			throw(new \PDOException("not a valid favorite"));
		}
		// create query template
		$query = "INSERT INTO favorite(favoriteProfileId, favoriteItemId, favoriteDate) VALUES(:favoriteProfileId, :favoriteItemId, :favoriteDate)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->favoriteDate->format("Y-m-d H:i:s.u");
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId, "favoriteItemId" => $this->favoriteItemId, "favoriteDate" => $formattedDate];
		$statement->execute($parameters);
	}
	/**
	 * deletes this favorite into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 **/
	public function delete(\PDO $pdo) : void {
		// ensure the favorite object exists before deleting
		if($this->favoriteProfileId === null || $this->favoriteItemId === null) {
			throw(new \PDOException("not a valid favorite"));
		}
		// create query template
		$query = "DELETE FROM favorite WHERE favoriteProfileId = :favoriteProfileId and favoriteItemId = :favoriteItemId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId, "favoriteItemId" => $this->favoriteItemId];
		$statement->execute($parameters);
	}
	/**
	 * gets the Favorite by item id and profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteProfileId profile id to search for
	 * @param int $favoriteItemId item id to search for
	 * @return Favorite|null Favorite found or null if not found
	 **/
	public static function getFavoriteByFavoriteProfileIdAndFavoriteItemId(\PDO $pdo, int $favoriteProfileId, int $favoriteItemId) : ?Favorite {
		// sanitize the profile id and item id before searching
		if($favoriteProfileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}
		if($favoriteItemId <= 0) {
			throw(new \PDOException("item id is not positive"));
		}
		// create the query template
		$query = "SELECT favoriteProfileId, favoriteItemId, favoriteDate FROM favorite WHERE favoriteProfileId = :favoriteProfileId AND favoriteItemId = :favoriteItemId";
		$statement = $pdo->prepare($query);
		// bind the item id and profile id to the place holder in the template
		$parameters = ["favoriteProfileId" => $favoriteProfileId, "favoriteItemId" => $favoriteItemId];
		$statement->execute($parameters);
		// grav the favorite from mySQL
		try {
			$favorite = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteItemId"], $row["favoriteDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($favorite);
	}
	/**
	 *  gets the Favorite by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteProfileId id to search for
	 * @return \SplFixedArray SplFixedArray of Favorites found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFavoriteByFavoriteProfileId(\PDO $pdo, int $favoriteProfileId) : \SplFixedArray {
		// sanitize the profile id
		if($favoriteProfileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}
		// create query template
		$query = "SELECT favoriteProfileId, favoriteItemId, favoriteDate FROM favorite WHERE favoriteProfileId = :favoriteProfileId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["favoriteProfileId" => $favoriteProfileId];
		$statement->execute($parameters);
		// build an array of favorites
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteItemId"], $row["favoriteDate"]);
				$favorites[$favorites->key()] = $favorite;
				$favorites->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($favorites);
	}
	/**
	 * gets the Favorite by item id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteItemId item id to search for
	 * @return \SplFixedArray SplFixedArray of Favorites found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFavoritesByFavoriteItemId(\PDO $pdo, int $favoriteItemId) : \SplFixedArray {
		// sanitize the item id
		if($favoriteItemId <= 0) {
			throw(new \PDOException("item id is not positive"));
		}
		// create query template
		$query = "SELECT favoriteProfileId, favoriteItemId, favoriteDate FROM favorite WHERE favoriteItemId = :favoriteItemId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["favoriteItemId" => $favoriteItemId];
		$statement->execute($parameters);
		// build an array of favorites
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while($row = $statement->fetch() !== false) {
			try {
				$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteItemId"], $row["favoriteDate"]);
				$favorites[$favorites->key()] = $favorite;
				$favorites->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		} return($favorites);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		//format the date so that the front end can consume it
		$fields["favoriteDate"] = round(floatval($this->favoriteDate->format("U.u")) * 1000);
		return ($fields);
	}

}