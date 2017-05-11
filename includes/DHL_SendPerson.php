<?php
/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 26.01.2017
 * Time: 18:17
 * Update: -
 * Version: 0.0.1
 *
 * Notes: Contains DHL_SendPerson Class
 */

/**
 * Class DHL_SendPerson
 */
abstract class DHL_SendPerson extends DHL_Address {
	/**
	 * Name of the SendPerson (Can be a Company-Name too!)
	 *
	 * Min-Len: -
	 * Max-Len: 50
	 *
	 * @var string $name - Name
	 */
	private $name;

	/**
	 * Name of SendPerson (Part 2)
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 50
	 *
	 * @var string|null $name2 - Name (Part 2)
	 */
	private $name2 = null;

	/**
	 * Name of SendPerson (Part 3)
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 50
	 *
	 * @var string|null $name3 - Name (Part 3)
	 */
	private $name3 = null;

	/**
	 * Phone-Number of the SendPerson
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 20
	 *
	 * @var string|null $phone - Phone-Number
	 */
	private $phone = null;

	/**
	 * E-Mail of the SendPerson
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 70
	 *
	 * @var string|null $email - E-Mail-Address
	 */
	private $email = null;

	/**
	 * Contact Person of the SendPerson (Mostly used in Companies)
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 50
	 *
	 * @var string|null $contactPerson - Contact Person
	 */
	private $contactPerson = null;

	/**
	 * DHL_SendPerson constructor.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		parent::__destruct();
		unset($this->name);
		unset($this->name2);
		unset($this->name3);
		unset($this->phone);
		unset($this->email);
		unset($this->contactPerson);
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return null|string
	 */
	public function getName2() {
		return $this->name2;
	}

	/**
	 * @param null|string $name2
	 */
	public function setName2($name2) {
		$this->name2 = $name2;
	}

	/**
	 * @return null|string
	 */
	public function getName3() {
		return $this->name3;
	}

	/**
	 * @param null|string $name3
	 */
	public function setName3($name3) {
		$this->name3 = $name3;
	}

	/**
	 * @return null|string
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * @param null|string $phone
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
	}

	/**
	 * @return null|string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param null|string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @return null|string
	 */
	public function getContactPerson() {
		return $this->contactPerson;
	}

	/**
	 * @param null|string $contactPerson
	 */
	public function setContactPerson($contactPerson) {
		$this->contactPerson = $contactPerson;
	}


	/**
	 * Returns a Class for the DHL-SendPerson
	 *
	 * @return StdClass - DHL-SendPerson-class
	 */
	abstract public function getClass_v1();

	/**
	 * Returns a Class for the DHL-SendPerson
	 *
	 * @return StdClass - DHL-SendPerson-class
	 */
	abstract public function getClass_v2();
}
