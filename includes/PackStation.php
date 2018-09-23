<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 17.03.2017
 * Time: 12:09
 * Update: 17.07.2018
 * Version: 1.0.5
 *
 * Notes: Contains the PackStation class
 */

use stdClass;

/**
 * Class PackStation
 *
 * @package Petschko\DHL
 */
class PackStation extends Receiver {
	/**
	 * Contains the Post-Number
	 *
	 * Min-Len: 1
	 * Max-Len: 10
	 *
	 * @var string $postNumber - Post-Number
	 */
	private $postNumber = '';

	/**
	 * Contains the Pack-Station-Number
	 *
	 * Min-Len: 3
	 * Max-Len: 3
	 *
	 * @var string $packStationNumber - Pack-Station-Number
	 */
	private $packStationNumber = '';

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		parent::__destruct();
		unset($this->postNumber);
		unset($this->packStationNumber);
	}

	/**
	 * Get the Post-Number
	 *
	 * @return string - Post-Number
	 */
	public function getPostNumber() {
		return $this->postNumber;
	}

	/**
	 * Set the Post-Number
	 *
	 * @param string $postNumber - Post-Number
	 */
	public function setPostNumber($postNumber) {
		$this->postNumber = $postNumber;
	}

	/**
	 * Get the Pack-Station-Number
	 *
	 * @return string - Pack-station-Number
	 */
	public function getPackStationNumber() {
		return $this->packStationNumber;
	}

	/**
	 * Set the Pack-Station-Number
	 *
	 * @param string $packStationNumber - Pack-Station-Number
	 */
	public function setPackStationNumber($packStationNumber) {
		$this->packStationNumber = $packStationNumber;
	}

	/**
	 * Returns a Class for the DHL-SendPerson
	 *
	 * @return StdClass - DHL-SendPerson-class
	 */
	public function getClass_v2() {
		$class = new StdClass;
		$class->name1 = $this->getName();

		$class->Communication = new StdClass;
		if($this->getPhone() !== null)
			$class->Communication->phone = $this->getPhone();
		if($this->getEmail() !== null)
			$class->Communication->email = $this->getEmail();
		if($this->getContactPerson() !== null)
			$class->Communication->contactPerson = $this->getContactPerson();

		$class->Packstation = new StdClass;
		$class->Packstation->postNumber = $this->getPostNumber();
		$class->Packstation->packstationNumber = $this->getPackStationNumber();
		$class->Packstation->zip = $this->getZip();
		$class->Packstation->city = $this->getLocation();

		if($this->getCountryISOCode() !== null) {
			$class->Packstation->Origin = new StdClass;

			if($this->getCountry() !== null)
				$class->Packstation->Origin->country = $this->getCountry();

			$class->Packstation->Origin->countryISOCode = $this->getCountryISOCode();

			if($this->getState() !== null)
				$class->Packstation->Origin->state = $this->getState();
		}

		return $class;
	}
}
