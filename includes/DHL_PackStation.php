<?php
/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 17.03.2017
 * Time: 12:09
 * Update: 20.03.2017
 * Version: 1.0.2
 *
 * Notes: Contains the DHL_PackStation class
 */

/**
 * Class DHL_PackStation
 */
class DHL_PackStation extends DHL_Receiver {
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
	 * DHL_PackStation constructor.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		parent::__destruct();
		unset($this->postNumber);
		unset($this->packStationNumber);
	}

	/**
	 * @return string
	 */
	public function getPostNumber() {
		return $this->postNumber;
	}

	/**
	 * @param string $postNumber
	 */
	public function setPostNumber($postNumber) {
		$this->postNumber = $postNumber;
	}

	/**
	 * @return string
	 */
	public function getPackStationNumber() {
		return $this->packStationNumber;
	}

	/**
	 * @param string $packStationNumber
	 */
	public function setPackStationNumber($packStationNumber) {
		$this->packStationNumber = $packStationNumber;
	}

	/**
	 * Returns a Class for the DHL-SendPerson
	 *
	 * @return StdClass - DHL-SendPerson-class
	 */
	public function getClass_v1() {
		// TODO: Implement getClass_v1() method.

		return new StdClass;
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
