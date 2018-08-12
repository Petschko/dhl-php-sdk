<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 26.01.2017
 * Time: 18:17
 * Update: 17.07.2018
 * Version: 0.0.4
 *
 * Notes: Contains SendPerson Class
 */

use stdClass;

/**
 * Class SendPerson
 *
 * @package Petschko\DHL
 */
abstract class SendPerson extends Address {
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
	 * @var string|null $name2 - Name (Part 2) | null for none
	 */
	private $name2 = null;

	/**
	 * Name of SendPerson (Part 3)
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 50
	 *
	 * @var string|null $name3 - Name (Part 3) | null for none
	 */
	private $name3 = null;

	/**
	 * Phone-Number of the SendPerson
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 20
	 *
	 * @var string|null $phone - Phone-Number | null for none
	 */
	private $phone = null;

	/**
	 * E-Mail of the SendPerson
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 70
	 *
	 * @var string|null $email - E-Mail-Address | null for none
	 */
	private $email = null;

	/**
	 * Contact Person of the SendPerson (Mostly used in Companies)
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 50
	 *
	 * @var string|null $contactPerson - Contact Person | null for none
	 */
	private $contactPerson = null;

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
	 * Get the Name
	 *
	 * @return string - Name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Set the Name
	 *
	 * @param string $name - Name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Get the Name2 Field
	 *
	 * @return null|string - Name2 or null if none
	 */
	public function getName2() {
		return $this->name2;
	}

	/**
	 * Set the Name2 Field
	 *
	 * @param null|string $name2 - Name2 or null for none
	 */
	public function setName2($name2) {
		$this->name2 = $name2;
	}

	/**
	 * Get the Name3 Field
	 *
	 * @return null|string - Name3 or null if none
	 */
	public function getName3() {
		return $this->name3;
	}

	/**
	 * Set the Name3 Field
	 *
	 * @param null|string $name3 - Name3 or null for none
	 */
	public function setName3($name3) {
		$this->name3 = $name3;
	}

	/**
	 * Get the Phone
	 *
	 * @return null|string - Phone or null if none
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * Set the Phone
	 *
	 * @param null|string $phone - Phone or null for none
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
	}

	/**
	 * Get the E-Mail
	 *
	 * @return null|string - E-Mail or null if none
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Set the E-Mail
	 *
	 * @param null|string $email - E-Mail or null for none
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Get the Contact-Person
	 *
	 * @return null|string - Contact-Person or null if none
	 */
	public function getContactPerson() {
		return $this->contactPerson;
	}

	/**
	 * Set the Contact-Person
	 *
	 * @param null|string $contactPerson - Contact-Person or null for none
	 */
	public function setContactPerson($contactPerson) {
		$this->contactPerson = $contactPerson;
	}


	/**
	 * Returns a Class for the DHL-SendPerson
	 *
	 * @return StdClass - DHL-SendPerson-class
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	public function getClass_v1() {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		return new StdClass;
	}

	/**
	 * Returns a Class for the DHL-SendPerson
	 *
	 * @return StdClass - DHL-SendPerson-class
	 */
	abstract public function getClass_v2();
}
