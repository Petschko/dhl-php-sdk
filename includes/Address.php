<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
 * Authors-Website: http://petschko.org/
 * Date: 15.09.2016
 * Time: 15:23
 * Update: -
 * Version: 0.0.1
 *
 * Notes: -
 */

/**
 * Class Address
 */
class Address {
	/**
	 * Contains the Street Name (without number)
	 *
	 * @var string $street_name - Street Name (without number)
	 */
	protected $street_name = 'Example Street';

	/**
	 * Contains the Street Number (may with extra stuff like a/b/c/d etc)
	 *
	 * @var string $street_number - Street Number (may with extra stuff like a/b/c/d etc)
	 */
	protected $street_number = '4a';

	/**
	 * Contains the ZIP-Code
	 *
	 * @var string $zip - ZIP-Code
	 */
	protected $zip = '21037';

	/**
	 * Contains the City/Location
	 *
	 * @var string $location - Location
	 */
	protected $location = 'Hamburg';

	/**
	 * Contains the Country
	 *
	 * @var string $country - Country
	 */
	protected $country = 'germany';

	/**
	 * Address constructor.
	 */
	public function __construct() {
		// VOID
	}

	/**
	 * Clears the Memory
	 */
	public function __destruct() {
		unset($this->street_name);
		unset($this->street_number);
		unset($this->zip);
		unset($this->location);
		unset($this->country);
	}

	/**
	 * @return string
	 */
	public function getStreetName() {
		return $this->street_name;
	}

	/**
	 * @param string $street_name
	 */
	public function setStreetName($street_name) {
		$this->street_name = $street_name;
	}

	/**
	 * @return string
	 */
	public function getStreetNumber() {
		return $this->street_number;
	}

	/**
	 * @param string $street_number
	 */
	public function setStreetNumber($street_number) {
		$this->street_number = $street_number;
	}

	/**
	 * @return string
	 */
	public function getZip() {
		return $this->zip;
	}

	/**
	 * @param string $zip
	 */
	public function setZip($zip) {
		$this->zip = $zip;
	}

	/**
	 * @return string
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * @param string $location
	 */
	public function setLocation($location) {
		$this->location = $location;
	}

	/**
	 * @return string
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * @param string $country
	 */
	public function setCountry($country) {
		$this->country = mb_strtolower($country);
	}

	/**
	 * Sets Street-Name and Number by Address String
	 *
	 * Found here: https://www.tricd.de/php/php-strassenname-und-hausnummer-mit-php-parsen/
	 *
	 * @param string $street - Address (Street plus number)
	 */
	public function setFullStreet($street) {
		$match = array();

		preg_match('/^([^\d]*[^\d\s]) *(\d.*)$/', $street, $match);

		if(count($match) == 0) return;

		$this->setStreetName($match[1]);
		$this->setStreetNumber($match[2]);
	}
}
