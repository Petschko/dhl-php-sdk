<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
 * Authors-Website: http://petschko.org/
 * Date: 26.01.2017
 * Time: 18:06
 * Update: -
 * Version: 0.0.1
 *
 * Notes: Contains all stuff for Ident-Check
 */

/**
 * Class DHL_IdentCheck
 */
class DHL_IdentCheck {
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
	 * DHL_IdentCheck constructor.
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
