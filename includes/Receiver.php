<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: https://petschko.org/
 * Date: 28.01.2017
 * Time: 19:17
 *
 * Notes: Contains the Receiver class
 */

use stdClass;

/**
 * Class Receiver
 *
 * @package Petschko\DHL
 */
class Receiver extends SendPerson {
	/**
	 * Returns a Class for the DHL-SendPerson
	 *
	 * @return StdClass - DHL-SendPerson-class
	 * @since 2.0
	 */
	public function getClass_v2() {
		$class = new StdClass;

		$class->name1 = $this->getName();

		// Communication
		$class->Communication = $this->getCommunicationClass_v2();

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
		if($this->getCountryISOCode() !== null)
			$class->Address->Origin = $this->getOriginClass_v2();

		return $class;
	}

	/**
	 * Returns a Class for the DHL-SendPerson
	 *
	 * @return StdClass - DHL-SendPerson-class
	 * @since 3.0
	 */
	public function getClass_v3() {
		$class = new StdClass;

		$class->name1 = $this->getName();

		// Communication
		$class->Communication = $this->getCommunicationClass_v3();

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
		if($this->getProvince() !== null)
			$class->Address->province = $this->getProvince();

		// Origin
		if($this->getCountryISOCode() !== null)
			$class->Address->Origin = $this->getOriginClass_v3();

		return $class;
	}
}
