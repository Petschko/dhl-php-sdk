<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: https://petschko.org/
 * Date: 15.09.2016
 * Time: 15:23
 *
 * Notes: Contains the DHL-Address Class
 */

use stdClass;

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
	 * Max-Len: 50 (since 3.0)
	 *
	 * @var string $streetName - Street Name (without number)
	 */
	private $streetName = '';

	/**
	 * Contains the Street Number (may with extra stuff like a/b/c/d etc)
	 *
	 * Min-Len: -
	 * Max-Len: 5
	 * Max-Len: 10 (since 3.0)
	 *
	 * @var string $streetNumber - Street Number (may with extra stuff like a/b/c/d etc)
	 */
	private $streetNumber = '';

	/**
	 * Contains other Info about the Address like if its hard to find or where it is exactly located
	 *
	 * Note: Optional
	 *
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
	 *
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
	 * Max-Len: 17 (since 3.0)
	 *
	 * @var string $zip - ZIP-Code
	 */
	private $zip = '';

	/**
	 * Contains the City/Location
	 *
	 * Min-Len: -
	 * Max-Len: 35
	 * Max-Len: 50 (since 3.0)
	 *
	 * @var string $location - Location
	 */
	private $location = '';

	/**
	 * Contains the Province Name
	 *
	 * Note: Optional
	 *
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $province - Province Name
	 * @since 3.0
	 */
	private $province = null;

	/**
	 * Contains the Country
	 *
	 * Note: Optional
	 *
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
	 *
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
	 * Max-Len: 35 (since 3.0)
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
	 * Get the Name of the Province
	 *
	 * @return string|null - Name of the Province or null if none
	 * @since 3.0
	 */
	public function getProvince(): ?string {
		return $this->province;
	}

	/**
	 * Set the Name of the Province
	 *
	 * @param string|null $province - Name of the Province or null for none
	 * @since 3.0
	 */
	public function setProvince(?string $province): void {
		$this->province = $province;
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
		Deprecated::methodIsDeprecated(__METHOD__, __CLASS__);

		$match = array();

		preg_match('/^([^\d]*[^\d\s]) *(\d.*)$/', $street, $match);

		if(count($match) == 0) return;

		$this->setStreetName($match[1]);
		$this->setStreetNumber($match[2]);
	}

	/**
	 * Returns the Origin Class
	 *
	 * @return StdClass - Origin Class
	 * @since 2.0
	 */
	protected function getOriginClass_v2() {
		$class = new StdClass;

		if($this->getCountry() !== null)
			$class->country = $this->getCountry();

		$class->countryISOCode = $this->getCountryISOCode();

		if($this->getState() !== null)
			$class->state = $this->getState();

		return $class;
	}

	/**
	 * Returns the Origin Class
	 *
	 * @return StdClass - Origin Class
	 * @since 3.0
	 */
	protected function getOriginClass_v3() {
		return $this->getOriginClass_v2();
	}
}
