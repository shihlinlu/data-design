<?php
namespace Edu\Cnm\DataDesign;
require_once("autoload.php");
/**
 * Small Cross Section of a Contempo Design favorite Product
 *
 * This Item can be treated as a small example of what eCommerce websites like Contempo Design store when products are favorited using Contempo Design. This can follow suit for more features of Contempo Design.
 *
 * @author Shihlin Lu <slu5@cnm.edu>
 * @version 1.0.0
 **/
class Item implements \JsonSerializable {
	/**
	 * id for this Item; this is the primary key
	 * @var int $itemId
	 **/
	private $itemId;
	/**
	 * id of the profile that saved this Item; this is a foreign key
	 * @var int $itemProfileId
	 **/
	private $itemProfileId;
	/**
	 * actual content in text format that describes this Item
	 * @var string $itemDescription
	 **/
	private $itemDescription;
	/**
	 * category or type in text format for this Item
	 * @var string $itemType
	 */
	private $itemType;
	/**
	 * name of this Item
	 * @var string $itemName
	 */
	private $itemName;
	/**
	 * Actual cost of this Item
	 * @var float $itemCost
	 **/
	private $itemCost;

	/**
	 * constructor for this Item
	 *
	 * @param int|null $newItemId id of this Item or null if a new Item
	 * @param int $newItemProfileId id of the Profile that saved this Item
	 * @param string $newItemDescription string containing actual content data
	 * @param string $newItemType string containing the type data
	 * @param string $newItemName string containing the name of the Item
	 * @param float $newItemCost float containing cost data of the Item
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers, negative floats)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newItemId, int $newItemProfileId, string $newItemDescription, string $newItemType, string $newItemName, float $newItemCost) {
		try {
			$this->setItemId($newItemId);
			$this->setItemProfileId($newItemProfileId);
			$this->setItemDescription($newItemDescription);
			$this->setItemType($newItemType);
			$this->setItemName($newItemName);
			$this->setItemCost($newItemCost);
		} // determine what exception was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for item id
	 * @return int|null value of item id
	 **/
	public function getItemId(): ?int {
		return($this->itemId);
	}

	/**
 	* mutator method for item id
	 * @param int|null $newItemId new value of Item id
 	* @throws \RangeException if $newItemId is not positive
	 * @throws \TypeError if $newItemId is not an integer
	 **/
	public function setItemId(?int $newItemId): void {
		// if item id is null immediately return it
		if($newItemId === null) {
		$this->itemId = null;
		return;
		}
		// verify the item id is positive
		if($newItemId <= 0) {
		throw(new \RangeException("item id is not positive"));
		}
		//convert and store the item id
		$this->itemId = $newItemId;
	}
/**
 * accessor method for item profile id
 *
 * @return int value of item profile id
 **/
	public function getItemProfileId() : int {
		return($this->itemProfileId);
	}
	/**
	 * mutator method for item profile id
	 *
	 * @param int $newItemProfileId new value of item profile id
 	* @throws \RangeException if $newProfileId is not positive
 	* @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setItemProfileId(int $newItemProfileId) : void {
		// verify the profile id is positive
		if($newItemProfileId <= 0) {
			throw(new \RangeException("item profile id is not positive"));
		}
		// convert and store the profile id
		$this->itemProfileId = $newItemProfileId;
	}
	/**
	 * accessor method for item description
	 *
	 * @return string value of item description
	 **/
	public function getItemDescription() : string {
		return($this->itemDescription);
	}
	/**
	 * mutator method for item description
	 *
	 * @param string $newItemDescription new description of item
	 * @throws \InvalidArgumentException if $newItemDescription is not a string or insecure
	 * @throws \RangeException if $newItemDescription is > 200 characters
	 * @throws \TypeError if $newItemDescription is not a string
	 **/
	public function setItemDescription(string $newItemDescription) : void{
		// verify that the item description is secure
		$newItemDescription = trim($newItemDescription);
		$newItemDescription = filter_var($newItemDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
		if(empty($newItemDescription) === true) {
			throw(new \InvalidArgumentException("item description is empty or insecure"));
		}
		// verify that the item description will fit in the database
		if(strlen($newItemDescription) >200) {
			throw(new \RangeException("item description is too long"));
		}
		// store the item description
		$this->itemDescription = $newItemDescription;
	}
	/**
	 * accessor method for item type
	 *
	 * @return string value of item type
	 **/
	public function getItemType() : string {
		return($this->itemType);
	}
	/**
	 * mutator method for item type
	 *
	 * @param string $newItemType new type of item
	 * @throws \InvalidArgumentException if $newItemType is not a string or insecure
	 * @throws \RangeException if $newItemType is > 32 characters
	 * @throws \TypeError if $newItemType is not a string
	 **/
	public function setItemType(string $newItemType) : void {
		// verify that the item type is secure
		$newItemType = trim($newItemType);
		$newItemType = filter_var($newItemType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newItemType) === true) {
			throw(new \InvalidArgumentException("item type is empty or insecure"));
		}
		// verify that the item description will fit in the database
		if(strlen($newItemType) > 32) {
			throw(new \RangeException("item type is too long"));
		}
		// store the item type
		$this->itemType = $newItemType;
	}
	/**
	 * accessor method for item name
	 *
	 * @return string value of item name
	 **/
	public function getItemName() : string {
		return($this->itemName);
	}
	/**
	 * mutator method for item name

	 * @param string $newItemName new name of item
	 * @throws \InvalidArgumentException if $newItem name is not a string or insecure
	 * @throws \RangeException if $newItemName is > 500 characters
	 * @throws \TypeError if $newItemName is not a string
	 */
	public function setItemName(string $newItemName) : void {
		// verify that the item name is secure
		$newItemName = trim($newItemName);
		$newItemName = filter_var($newItemName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newItemName) === true) {
			throw(new \InvalidArgumentException("item name is empty or insecure"));
		}
		// verify that the item name will fit in the database
		if(strlen($newItemName) > 500) {
			throw(new \RangeException("item name is too long"));
		}
		// store the item name
		$this->itemName = $newItemName;
	}
	/**
	 * accessor method for item cost
	 *
	 * @return float value of item cost
	 */
	public function getItemCost() : float {
		return($this->itemCost);
	}
	/**
	 * mutator method for item cost
	 *
	 * @param float $newItemCost new cost of item
	 * @throws \InvalidArgumentException if $newItemCost is empty insecure
	 * @throws \RangeException if $newItemCost > 11 digits
	 * @throws \TypeError if $newItemCost is not a float
	 **/
	public function setItemCost(float $newItemCost) : void {
		// verify that the item cost is secure
		$newItemCost = filter_var($newItemCost, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
		if(empty($newItemCost) === true) {
			throw(new \InvalidArgumentException("item is empty or insecure"));
		}

		// verify price is > 0
		if($newItemCost > 0) {
			throw(new \RangeException("item cost is not positive"));
		}

		// verify that the item cost will fit in the database (> 11 digits)

		// check decimal precision???

		// if ok, set itemCost
		$this->itemCost = $newItemCost;
	}
	/**
	 * inserts this Item into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// enforce the itemId is null (i.e., don't insert an item that already exists)
		if($this->itemId !== null) {
			throw(new \PDOException("not a new item"));
		}
		// create query template
		$query = "INSERT INTO item(itemProfileId, itemDescription, itemName, itemType, itemCost) VALUES(:itemProfileId, :itemDescription, :itemName, :itemType, :itemCost)";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["itemProfileId" => $this->itemProfileId, "itemDescription" => $this->itemDescription, "itemName" => $this->itemName, "itemType" => $this->itemType, "itemCost" => $this->itemCost];
		$statement->execute($parameters);
		// update the null itemId with what mySQL just gave us
		$this->itemId = intval($pdo->lastInsertId());
	}
	/**
	 * deletes this Item from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// enforce the itemId is not null (i.e., don't delete an item that hasn't been inserted)
		if(@$this->itemId === null) {
			throw(new \PDOException("unable to delete an item that does not exist"));
		}
		// create query template
		$query = "DELETE FROM item WHERE itemId = :itemId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["itemId" => $this->itemId];
		$statement->execute($parameters);
	}
	/**
	 *
	 * updates this item in mySQL
	 *
	 *@param \PDO $pdo PDO connection object
	 *@throws \PDOException when mySQL related errors occur
	 *@throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// enforce the itemId is not null (i.e., don't update an item that hasn't been inserted)
		if($this->itemId === null) {
			throw(new \PDOException("unable to update an item that does not exist"));
		}
		// create query template
		$query = "UPDATE item SET itemProfileId = :itemProfileId, itemDescription = :itemDescription, itemName = :itemName, itemType = :itemType, itemCost = :itemCost WHERE itemId = :itemId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["itemProfileId" => $this->itemProfileId, "itemDescription" => $this->itemDescription, "itemName" => $this->itemName, "itemType" => $this->itemType, "itemCost" => $this->itemCost];
		$statement->execute($parameters);
	}
	/**
	 * gets an item by itemId
	 * @param \PDO $pdo PDO connection object
	 * @param int $itemId item id to search for
	 * @return Item | null Item found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getItemByItemId(\PDO $pdo, int $itemId) : ?Item {
		// sanitize the itemId before searching
		if($itemId <= 0)  {
			throw(new \PDOException("item id is not positive"));
		}
		// create query template
		$query = "SELECT itemId, itemProfileId, itemDescription, itemName, itemType, itemCost FROM item WHERE itemId = :itemId";
		$statement = $pdo->prepare($query);
		// bind the item id to the place holder in the template
		$parameters = ["itemId" => $itemId];
		$statement->execute($parameters);
		// grab the item from mySQL
		try {
			$item = null;

			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$item = new Item($row["itemId"], $row["itemProfileId"], $row["itemDescription"], $row["itemName"], $row["itemType"], $row["itemCost"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($item);
	}
	/**
	 *
	 * gets Items by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $itemProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of Items found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getItemsByItemProfileId(\PDO $pdo, int $itemProfileId) : \SplFixedArray {
		// sanitize the profile id before searching
		if($itemProfileId <= 0) {
			throw(new \RangeException("item profile id must be positive"));
		}
		// create query template
		$query = "SELECT itemId, itemProfileId, itemDescription, itemName, itemType, itemCost FROM item WHERE itemProfileId = :itemProfileId";
		$statement = $pdo->prepare($query);
		// bind the item profile id to the place holder in the template
		$parameters = ["itemProfileId" => $itemProfileId];
		$statement->execute($parameters);
		// build an array of items
		$items = new \SPLFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$item = new Item($row["itemId"], $row["itemProfileId"], $row["itemDescription"], $row["itemName"], $row["itemType"], $row["itemCost"]);
				$items[$items->key()] = $item;
				$items->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($items);
	}
	/**
	 *
	 * gets Items by description
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $itemDescription item description to search for
	 * @return \SplFixedArray SplFixedArray of Items found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getItemsByItemDescription(\PDO $pdo, string $itemDescription) : \SplFixedArray {
		// sanitize the description before searching
		$itemDescription = trim($itemDescription);
		$itemDescription = filter_var($itemDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($itemDescription) === true) {
			throw(new \PDOException("item description is invalid"));
		}
		// create query template
		$query = "SELECT itemId, itemProfileId, itemDescription, itemName, itemType, itemCost FROM item WHERE itemDescription LIKE : itemDescription";
		$statement = $pdo->prepare($query);
		// bind the item description to the place holder in the template
		$itemDescription = "%itemDescription%";
		$parameters = ["itemDescription" => $itemDescription];
		$statement->execute($parameters);
		// build an array of items
		$items = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$item = new Item($row["itemId"], $row["itemProfileId"], $row["itemDescription"], $row["itemName"], $row["itemType"], $row["itemCost"]);
				$items[$items->key()] = $item;
				$items->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($items);
	}
	/**
	 * get Items by name
	 * @param \PDO $pdo PDO connection object
	 * @param string $itemName item name to search for
	 * @return \SplFixedArray SplFixedArray of Items found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getItemsByItemName(\PDO $pdo, string $itemName) : \SplFixedArray {
		// sanitize the name before searching
		$itemName = trim($itemName);
		$itemName = filter_var($itemName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($itemName) === true) {
			throw(new \PDOException("item name is invalid"));
		}
		// create query template
		$query = "SELECT itemId, itemProfileId, itemDescription, itemName, itemType, itemCost FROM item WHERE itemName LIKE : itemName";
		$statement = $pdo->prepare($query);
		// bind the item name to the place holder in the template
		$itemName = "%itemName%";
		$parameters = ["itemName" => $itemName];
		$statement->execute($parameters);
		// build an array of items
		$items = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$item = new Item($row["itemId"], $row["itemProfileId"], $row["itemDescription"], $row["itemName"], $row["itemType"], $row["itemCost"]);
				$items[$items->key()] = $item;
				$items->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($items);
	}
	/**
	 *
	 * get Items by type
	 * @param \PDO $pdo PDO connection object
	 * @param string $itemType item type to search for
	 * @return \SplFixedArray SplFixedArray of Items found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getItemsByItemType(\PDO $pdo, string $itemType) : \SplFixedArray {
		//sanitize the type before searching
		$itemType = trim($itemType);
		$itemType = filter_var($itemType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($itemType) === true) {
			throw(new \PDOException("item type is invalid"));
		}
		// create query template
		$query = "SELECT itemId, itemProfileId, itemDescription, itemName, itemType, itemCost FROM item WHERE itemType LIKE : itemType";
		$statement = $pdo->prepare($query);
		// bind the item type to the place holder in the template
		$itemType = "%itemType%";
		$parameters = ["itemType" => $itemType];
		$statement->execute($parameters);
		// build an array of items
		$items = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$item = new Item($row["itemId"], $row["itemProfileId"], $row["itemDescription"], $row["itemName"], $row["itemType"], $row["itemCost"]);
				$items[$items->key()] = $item;
				$items->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($items);
	}

	/**
	 * get Items by cost
	 * @param \PDO $pdo PDO connection object
	 * @param float $itemCost item cost to search for
	 * @return \SplFixedArray SplFixedArray of Items found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getItemsByItemCost(\PDO $pdo, float $itemCost) : \SplFixedArray {
		// sanitize the cost before searching
		$itemCost = filter_var($itemCost, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
		if(empty($itemCost) === true) {
			throw(new \PDOException("item cost is invalid"));
		}
		// create query template
		$query = "SELECT itemId, itemProfileId, itemDescription, itemName, itemType, itemCost FROM item WHERE itemCost = :itemCost";
		$statement = $pdo->prepare($query);
		// bind the item cost to the place holder in the template
		$parameters = ["itemCost" => $itemCost];
		$statement->execute($parameters);
		// build an array of items
		$items = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$item = new Item($row["itemId"], $row["itemProfileId"], $row["itemDescription"], $row["itemName"], $row["itemType"], $row["itemCost"]);
				$items[$items->key()] = $item;
				$items->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($items);
	}

	/**
	 *gets all Items
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of items found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data
	 **/
	public static function getAllItems(\PDO $pdo) : \SplFixedArray {
		// create query template
		$query = "SELECT itemId, itemProfileId, itemDescription, itemName, itemType, itemCost FROM item";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of items
		$items = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$item = new Item($row["itemId"], $row["itemProfileId"], $row["itemDescription"], $row["itemName"], $row["itemType"], $row["itemCost"]);
				$items[$items->key()] = $item;
				$items->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($items);
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

