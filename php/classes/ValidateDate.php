<?php
namespace Edu\Cnm\DataDesign;
/**
 * Trait to Validate a mySQL Date
 *
 * This trait will inject a private method to validate a mySQL style date (e.g., 2016-01-15 15:32:48.643216). It will convert a string representation to a DateTime object or throw and exception.
 *
 * @author Shihlin Lu <slu5@cnm.edu>
 * @version 1.0.0
 **/

trait ValidateDate {
	/**
	 *
	 * custom filter for mySQL date
	 *
	 * Converts a string to a DateTime object; this is designed to be used within a mutator method
	 *
	 * @param \DateTime|string $newDate date to validate
	 * @return \DateTime DateTime object containing the validated date
	 * @see http://php.net/manual/en/class.datetime.php PHP's DateTime class
	 * @throws \InvalidArgumentException if the date is an invalid format
	 * @throws \RangeException if the date is not a Gregorian date
	 * @throws \TypeError when type hints fail
	 **/
	private function validateDate($newDate) : \DateTime {
		// base case: if the date is a DateTime object, there's no work to be done
		if(is_object($newDate) === true && get_class($newDate) === "DateTime") {
			return ($newDate);
		}
		// treat the date as a mySQL date string: Y-m-d
		$newDate = trim($newDate);
		if((preg_match("/^(\d{4}")-(\d{2})-(\d{2})$)/" )

	}
}
