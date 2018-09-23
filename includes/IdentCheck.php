<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 26.01.2017
 * Time: 18:06
 * Update: 17.07.2018
 * Version: 0.0.3
 *
 * Notes: Contains all stuff for Ident-Check
 */

use stdClass;

/**
 * Class IdentCheck
 *
 * @package Petschko\DHL
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
		$this->setLastName($lastName);
		$this->setFirstName($firstName);
		$this->setBirthday($birthday);
		$this->setMinimumAge($minimumAge);
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
	 * Get the Last-Name
	 *
	 * @return string - Last-Name
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * Set the Last-Name
	 *
	 * @param string $lastName - Last-Name
	 */
	private function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	/**
	 * Get the First-Name
	 *
	 * @return string - First-Name
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * Set the First-Name
	 *
	 * @param string $firstName - First-Name
	 */
	private function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	/**
	 * Get the Birthday
	 *
	 * @return string - Birthday
	 */
	public function getBirthday() {
		return $this->birthday;
	}

	/**
	 * Set the Birthday
	 *
	 * @param string $birthday - Birthday
	 */
	private function setBirthday($birthday) {
		$this->birthday = $birthday;
	}

	/**
	 * Get the minimum Age
	 *
	 * @return int - Minimum Age
	 */
	public function getMinimumAge() {
		return $this->minimumAge;
	}

	/**
	 * Set the minimum Age
	 *
	 * @param int $minimumAge - Minimum Age
	 */
	private function setMinimumAge($minimumAge) {
		$this->minimumAge = $minimumAge;
	}

	/**
	 * Get the Ident-DHL-Class
	 *
	 * @return stdClass - Ident-DHL-Class
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	public function getIdentClass_v1() {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		return new StdClass;
	}

	/**
	 * Get the Ident-DHL-Class
	 *
	 * @return StdClass - Ident-DHL-Class
	 */
	public function getIdentClass_v2() {
		$class = new StdClass;
		$class->surname = $this->getLastName();
		$class->givenName = $this->getFirstName();
		$class->dateOfBirth = $this->getBirthday();
		$class->minimumAge = $this->getMinimumAge();

		return $class;
	}
}
