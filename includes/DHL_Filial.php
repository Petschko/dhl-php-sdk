<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
 * Authors-Website: http://petschko.org/
 * Date: 20.03.2017
 * Time: 13:23
 * Update: -
 * Version: 0.0.1
 *
 * Notes: Contains the DHL_Filial Class
 */

/**
 * Class DHL_Filial
 */
class DHL_Filial extends DHL_Receiver {
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
		unset($this->filialNumber);
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
	public function getFilialNumber() {
		return $this->filialNumber;
	}

	/**
	 * Alias for getFilialNumber
	 *
	 * @return string $filialNumber
	 */
	public function getPostFilialNumber() {
		return $this->filialNumber;
	}

	/**
	 * @param string $filialNumber
	 */
	public function setFilialNumber($filialNumber) {
		$this->filialNumber = $filialNumber;
	}

	/**
	 * Alias for setFilialNumber
	 *
	 * @param string $filialNumber
	 */
	public function setPostFilialNumber($filialNumber) {
		$this->filialNumber = $filialNumber;
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
