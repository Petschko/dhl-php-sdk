<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 15.09.2016
 * Time: 15:23
 * Update: -
 * Version: 0.0.1
 *
 * Notes: Contains the DHL-Address Class
 */

/**
 * Class Address
 */
abstract class Address {
	/**
	 * Contains the Street Name (without number)
	 *
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string $street_name - Street Name (without number)
	 */
	private $street_name = '';

	/**
	 * Contains the Street Number (may with extra stuff like a/b/c/d etc)
	 *
	 * Min-Len: -
	 * Max-Len: 5
	 *
	 * @var string $street_number - Street Number (may with extra stuff like a/b/c/d etc)
	 */
	private $street_number = '';

	/**
	 * Contains other Info about the Address like if its hard to find or where it is exactly located
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $address_addition - Address-Addition
	 */
	private $address_addition = null;

	/**
	 * Contains Optional Dispatching Info
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $dispatchingInfo - Optional Dispatching Info
	 */
	private $dispatchingInfo = null;

	/**
	 * Contains the ZIP-Code
	 *
	 * Min-Len: -
	 * Max-Len: 10
	 *
	 * @var string $zip - ZIP-Code
	 */
	private $zip = '';

	/**
	 * Contains the City/Location
	 *
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string $location - Location
	 */
	private $location = '';

	/**
	 * Contains the Country
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 30
	 *
	 * @var string|null $country - Country
	 */
	private $country = null;

	/**
	 * Contains the country ISO-Code
	 *
	 * Note: Optional
	 * Min-Len: 2
	 * Max-Len: 2
	 *
	 * @var string|null $countryISOCode - Country-ISO-Code
	 */
	private $countryISOCode = null;

	/**
	 * Contains the Name of the State
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 30
	 *
	 * @var string|null $state - Name of the State
	 */
	private $state = null;

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
		unset($this->address_addition);
		unset($this->dispatchingInfo);
		unset($this->zip);
		unset($this->location);
		unset($this->country);
		unset($this->countryISOCode);
		unset($this->state);
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
	 * @return null|string
	 */
	public function getAddressAddition() {
		return $this->address_addition;
	}

	/**
	 * @param null|string $address_addition
	 */
	public function setAddressAddition($address_addition) {
		$this->address_addition = $address_addition;
	}

	/**
	 * @return null|string
	 */
	public function getDispatchingInfo() {
		return $this->dispatchingInfo;
	}

	/**
	 * @param null|string $dispatchingInfo
	 */
	public function setDispatchingInfo($dispatchingInfo) {
		$this->dispatchingInfo = $dispatchingInfo;
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
	 * Alias for getLocation
	 *
	 * @return string
	 */
	public function getCity() {
		return $this->location;
	}

	/**
	 * Alias for setLocation
	 *
	 * @param string $city
	 */
	public function setCity($city) {
		$this->location = $city;
	}

	/**
	 * @return string|null
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * @param string|null $country
	 */
	public final function setCountry($country) {
		if($country !== null)
			$this->country = mb_strtolower($country);
		else
			$this->country = null;
	}

	/**
	 * @return string|null
	 */
	public function getCountryISOCode() {
		return $this->countryISOCode;
	}

	/**
	 * @param string|null $countryISOCode
	 */
	public final function setCountryISOCode($countryISOCode) {
		if($countryISOCode !== null)
			$this->countryISOCode = mb_strtoupper($countryISOCode);
		else
			$this->countryISOCode = null;
	}

	/**
	 * @return null|string
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * @param null|string $state
	 */
	public function setState($state) {
		$this->state = $state;
	}

	/**
	 * Sets Street-Name and Number by Address String
	 *
	 * Found here: https://www.tricd.de/php/php-strassenname-und-hausnummer-mit-php-parsen/
	 *
	 * @param string $street - Address (Street plus number)
	 */
	public final function setFullStreet($street) {
		$match = array();

		preg_match('/^([^\d]*[^\d\s]) *(\d.*)$/', $street, $match);

		if(count($match) == 0) return;

		$this->setStreetName($match[1]);
		$this->setStreetNumber($match[2]);
	}
}
