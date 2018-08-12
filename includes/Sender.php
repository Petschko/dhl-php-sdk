<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 28.01.2017
 * Time: 19:15
 * Update: 14.07.2018
 * Version: 0.0.2
 *
 * Notes: Contains the Sender Class
 */

use stdClass;

/**
 * Class Sender
 *
 * @package Petschko\DHL
 */
class Sender extends SendPerson {
	/**
	 * Returns a Class for the DHL-SendPerson
	 *
	 * @return StdClass - DHL-SendPerson-class
	 */
	public function getClass_v2() {
		$class = new StdClass;

		// Set Name
		$class->Name = new StdClass;
		$class->Name->name1 = $this->getName();
		if($this->getName2() !== null)
			$class->Name->name2 = $this->getName2();
		if($this->getName3() !== null)
			$class->Name->name3 = $this->getName3();

		// Address
		$class->Address = new StdClass;
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

		// Communication
		$class->Communication = new StdClass;
		if($this->getPhone() !== null)
			$class->Communication->phone = $this->getPhone();
		if($this->getEmail() !== null)
			$class->Communication->email = $this->getEmail();
		if($this->getContactPerson() !== null)
			$class->Communication->contactPerson = $this->getContactPerson();

		return $class;
	}
}
