<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 15.09.2016
 * Time: 15:23
 * Update: 14.07.2018
 * Version: 0.0.2
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
	 * @var string|null $addressAddition - Address-Addition
	 */
	private $addressAddition = null;

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
	 * @return string
	 */
	public function getStreetName() {
		return $this->streetName;
	}

	/**
	 * @param string $streetName
	 */
	public function setStreetName($streetName) {
		$this->streetName = $streetName;
	}

	/**
	 * @return string
	 */
	public function getStreetNumber() {
		return $this->streetNumber;
	}

	/**
	 * @param string $streetNumber
	 */
	public function setStreetNumber($streetNumber) {
		$this->streetNumber = $streetNumber;
	}

	/**
	 * @return null|string
	 */
	public function getAddressAddition() {
		return $this->addressAddition;
	}

	/**
	 * @param null|string $addressAddition
	 */
	public function setAddressAddition($addressAddition) {
		$this->addressAddition = $addressAddition;
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
	 *
	 * @deprecated - Buggy on some addresses, please separate the number and street by yourself
	 */
	public final function setFullStreet($street) {
		trigger_error('Called deprecated method ' . __METHOD__ . ': Buggy on some addresses, please separate the number and street by yourself', E_USER_DEPRECATED);

		$match = array();

		preg_match('/^([^\d]*[^\d\s]) *(\d.*)$/', $street, $match);

		if(count($match) == 0) return;

		$this->setStreetName($match[1]);
		$this->setStreetNumber($match[2]);
	}
}
