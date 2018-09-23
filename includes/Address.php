<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 15.09.2016
 * Time: 15:23
 * Update: 16.07.2018
 * Version: 0.0.5
 *
 * Notes: Contains the DHL-Address Class
 */

/**
 * Class Address
 *
 * @package Petschko\DHL
 */
abstract class Address {
	/**
	 * Contains the Street Name (without number)
	 *
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string $streetName - Street Name (without number)
	 */
	private $streetName = '';

	/**
	 * Contains the Street Number (may with extra stuff like a/b/c/d etc)
	 *
	 * Min-Len: -
	 * Max-Len: 5
	 *
	 * @var string $streetNumber - Street Number (may with extra stuff like a/b/c/d etc)
	 */
	private $streetNumber = '';

	/**
	 * Contains other Info about the Address like if its hard to find or where it is exactly located
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $addressAddition - Address-Addition | null for none
	 */
	private $addressAddition = null;

	/**
	 * Contains Optional Dispatching Info
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $dispatchingInfo - Optional Dispatching Info | null for none
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
	 * @var string|null $country - Country | null for none
	 */
	private $country = null;

	/**
	 * Contains the country ISO-Code
	 *
	 * Note: Optional
	 * Min-Len: 2
	 * Max-Len: 2
	 *
	 * @var string|null $countryISOCode - Country-ISO-Code | null for none
	 */
	private $countryISOCode = null;

	/**
	 * Contains the Name of the State (Geo-Location)
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 30
	 *
	 * @var string|null $state - Name of the State (Geo-Location) | null for none
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
		unset($this->streetName);
		unset($this->streetNumber);
		unset($this->addressAddition);
		unset($this->dispatchingInfo);
		unset($this->zip);
		unset($this->location);
		unset($this->country);
		unset($this->countryISOCode);
		unset($this->state);
	}

	/**
	 * Get the Street name
	 *
	 * @return string - Street name
	 */
	public function getStreetName() {
		return $this->streetName;
	}

	/**
	 * Set the Street name
	 *
	 * @param string $streetName - Street name
	 */
	public function setStreetName($streetName) {
		$this->streetName = $streetName;
	}

	/**
	 * Get the Street number
	 *
	 * @return string - Street Number
	 */
	public function getStreetNumber() {
		return $this->streetNumber;
	}

	/**
	 * Set the Street number
	 *
	 * @param string $streetNumber - Street Number
	 */
	public function setStreetNumber($streetNumber) {
		$this->streetNumber = $streetNumber;
	}

	/**
	 * Get the Address addition
	 *
	 * @return null|string - Address addition or null for none
	 */
	public function getAddressAddition() {
		return $this->addressAddition;
	}

	/**
	 * Set the Address addition
	 *
	 * @param null|string $addressAddition - Address addition or null for none
	 */
	public function setAddressAddition($addressAddition) {
		$this->addressAddition = $addressAddition;
	}

	/**
	 * Get the Dispatching-Info
	 *
	 * @return null|string - Dispatching-Info or null for none
	 */
	public function getDispatchingInfo() {
		return $this->dispatchingInfo;
	}

	/**
	 * Set the Dispatching-Info
	 *
	 * @param null|string $dispatchingInfo - Dispatching-Info or null for none
	 */
	public function setDispatchingInfo($dispatchingInfo) {
		$this->dispatchingInfo = $dispatchingInfo;
	}

	/**
	 * Get the ZIP
	 *
	 * @return string - ZIP
	 */
	public function getZip() {
		return $this->zip;
	}

	/**
	 * Set the ZIP
	 *
	 * @param string $zip - ZIP
	 */
	public function setZip($zip) {
		$this->zip = $zip;
	}

	/**
	 * Get the Location
	 *
	 * @return string - Location
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * Set the Location
	 *
	 * @param string $location - Location
	 */
	public function setLocation($location) {
		$this->location = $location;
	}

	/**
	 * Alias for $this->getLocation
	 *
	 * @return string - Location
	 */
	public function getCity() {
		return $this->location;
	}

	/**
	 * Alias for $this->setLocation
	 *
	 * @param string $city - Location
	 */
	public function setCity($city) {
		$this->location = $city;
	}

	/**
	 * Get the Country
	 *
	 * @return string|null - Country or null for none
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * Set the Country
	 *
	 * @param string|null $country - Country or null for none
	 */
	public final function setCountry($country) {
		if($country !== null)
			$this->country = mb_strtolower($country);
		else
			$this->country = null;
	}

	/**
	 * Get the Country-ISO-Code
	 *
	 * @return string|null - Country-ISO-Code or null for none
	 */
	public function getCountryISOCode() {
		return $this->countryISOCode;
	}

	/**
	 * Set the Country-ISO-Code
	 *
	 * @param string|null $countryISOCode - Country-ISO-Code or null for none
	 */
	public final function setCountryISOCode($countryISOCode) {
		if($countryISOCode !== null)
			$this->countryISOCode = mb_strtoupper($countryISOCode);
		else
			$this->countryISOCode = null;
	}

	/**
	 * Get the State (Geo-Location)
	 *
	 * @return null|string - State (Geo-Location) or null for none
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * Set the State (Geo-Location)
	 *
	 * @param null|string $state - State (Geo-Location) or null for none
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
	 *
	 * @deprecated - Buggy on some addresses, please separate the number and street by yourself
	 */
	public final function setFullStreet($street) {
		trigger_error('[DHL-PHP-SDK]: Called deprecated method ' . __METHOD__ . ': Buggy on some addresses, please separate the number and street by yourself. This method will removed in the future!', E_USER_DEPRECATED);

		$match = array();

		preg_match('/^([^\d]*[^\d\s]) *(\d.*)$/', $street, $match);

		if(count($match) == 0) return;

		$this->setStreetName($match[1]);
		$this->setStreetNumber($match[2]);
	}
}
