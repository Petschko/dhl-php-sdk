<?php
namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 26.01.2017
 * Time: 18:06
 * Update: 14.07.2018
 * Version: 0.0.2
 *
 * Notes: Contains all stuff for Ident-Check
 */

use stdClass;

/**
 * Class IdentCheck
 */
class IdentCheck {
	/**
	 * Contains the Last-Name of the Person
	 *
	 * @var string $lastName - Last-Name
	 */
	private $lastName;

	/**
	 * Contains the First-Name of the Person
	 *
	 * @var string $firstName - First-Name
	 */
	private $firstName;

	/**
	 * Contains the Birthday of the Person
	 *
	 * Note: ISO-Date-Format (YYYY-MM-DD)
	 *
	 * @var string $birthday - Birthday
	 */
	private $birthday;

	/**
	 * Contains the "minimum age of the person for ident check"
	 *
	 * @var int $minimumAge - "minimum age of the person for ident check"
	 */
	private $minimumAge;

	/**
	 * IdentCheck constructor.
	 *
	 * @param string $lastName - Last-Name
	 * @param string $firstName - First-Name
	 * @param string $birthday - Birthday (Format: YYYY-MM-DD)
	 * @param int $minimumAge - Minimum-Age
	 */
	public function __construct($lastName, $firstName, $birthday, $minimumAge) {
		$this->lastName = $lastName;
		$this->firstName = $firstName;
		$this->birthday = $birthday;
		$this->minimumAge = $minimumAge;
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		unset($this->lastName);
		unset($this->firstName);
		unset($this->birthday);
		unset($this->minimumAge);
	}

	/**
	 * @return stdClass
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	public function getIdentClass_v1() {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		// todo implement v1 method

		return new StdClass;
	}

	/**
	 * Get the Ident-DHL-Class
	 *
	 * @return StdClass - Ident-DHL-Class
	 */
	public function getIdentClass_v2() {
		$class = new StdClass;
		$class->surname = $this->lastName;
		$class->givenName = $this->firstName;
		$class->dateOfBirth = $this->birthday;
		$class->minimumAge = $this->minimumAge;

		return $class;
	}
}
