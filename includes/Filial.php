<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 20.03.2017
 * Time: 13:23
 * Update: 16.07.2018
 * Version: 0.0.4
 *
 * Notes: Contains the Filial Class
 */

use stdClass;

/**
 * Class Filial
 *
 * @package Petschko\DHL
 */
class Filial extends Receiver {
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
	 * Contains the Post-Filial-Number
	 *
	 * Min-Len: 3
	 * Max-Len: 3
	 *
	 * @var string $filialNumber - Post-Filial-Number
	 */
	private $filialNumber = '';

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		parent::__destruct();
		unset($this->postNumber);
		unset($this->filialNumber);
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
	 * Get the Filial-Number
	 *
	 * @return string - Filial-Number
	 */
	public function getFilialNumber() {
		return $this->filialNumber;
	}

	/**
	 * Alias for $this->getFilialNumber
	 *
	 * @return string $filialNumber - Filial-Number
	 */
	public function getPostFilialNumber() {
		return $this->filialNumber;
	}

	/**
	 * Set the Filial-Number
	 *
	 * @param string $filialNumber - Filial-Number
	 */
	public function setFilialNumber($filialNumber) {
		$this->filialNumber = $filialNumber;
	}

	/**
	 * Alias for $this->setFilialNumber
	 *
	 * @param string $filialNumber - Filial-Number
	 */
	public function setPostFilialNumber($filialNumber) {
		$this->filialNumber = $filialNumber;
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

		$class->Postfiliale = new StdClass;
		$class->Postfiliale->postfilialNumber = $this->getFilialNumber();
		$class->Postfiliale->postNumber = $this->getPostNumber();
		$class->Postfiliale->zip = $this->getZip();
		$class->Postfiliale->city = $this->getLocation();

		if($this->getCountryISOCode() !== null) {
			$class->Postfiliale->Origin = new StdClass;

			if($this->getCountry() !== null)
				$class->Postfiliale->Origin->country = $this->getCountry();

			$class->Postfiliale->Origin->countryISOCode = $this->getCountryISOCode();

			if($this->getState() !== null)
				$class->Postfiliale->Origin->state = $this->getState();
		}

		return $class;
	}
}
