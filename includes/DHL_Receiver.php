<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
 * Authors-Website: http://petschko.org/
 * Date: 28.01.2017
 * Time: 19:17
 * Update: 20.03.2017
 * Version: 1.0.0
 *
 * Notes: Contains the DHL_Receiver class
 */

/**
 * Class DHL_Receiver
 */
class DHL_Receiver extends DHL_SendPerson {
	/**
	 * DHL_Receiver constructor.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		parent::__destruct();
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

		// Communication
		$class->Communication = new StdClass;
		if($this->getPhone() !== null)
			$class->Communication->phone = $this->getPhone();
		if($this->getEmail() !== null)
			$class->Communication->email = $this->getEmail();
		if($this->getContactPerson() !== null)
			$class->Communication->contactPerson = $this->getContactPerson();

		// Address
		$class->Address = new StdClass;
		if($this->getName2() !== null)
			$class->Address->name2 = $this->getName2();
		if($this->getName3() !== null)
			$class->Address->name3 = $this->getName3();
		$class->Address->streetName = $this->getStreetName();
		$class->Address->streetNumber = $this->getStreetNumber();
		if($this->getAddressAddition() !== null)
			$class->Address->addressAddition = $this->getAddressAddition();
		if($this->getDispatchingInfo() !== null)
			$class->Address->dispatchingInformation = $this->getDispatchingInfo();
		$class->Address->zip = $this->getZip();
		$class->Address->city = $this->getLocation();

		// Origin
		if($this->getCountryISOCode() !== null) {
			$class->Address->Origin = new StdClass;
			if($this->getCountry() !== null)
				$class->Address->Origin->country = $this->getCountry();
			$class->Address->Origin->countryISOCode = $this->getCountryISOCode();
			if($this->getState() !== null)
				$class->Address->Origin->state = $this->getState();
		}

		return $class;
	}
}
