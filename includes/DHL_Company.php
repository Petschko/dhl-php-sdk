<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
 * Authors-Website: http://petschko.org/
 * Date: 15.09.2016
 * Time: 14:13
 * Update: -
 * Version: 0.0.1
 *
 * Notes: Contains DHL_Company class - Checkout the original repo: https://github.com/tobias-redmann/dhl-php-sdk
 */

/**
 * Class DHL_Company
 */
class DHL_Company extends Address {
	/**
	 * Contains Company Name (+type like GmbH, AG etc)
	 *
	 * @var string $company_name - Company Name (+type)
	 */
	private $company_name = 'MyCompany GmbH';

	/**
	 * Contains the Company contact E-Mail Address
	 *
	 * @var string $email - Company contact E-Mail Address
	 */
	private $email = 'myEMail@myCompany.com';

	/**
	 * Contains the Company Phone-Number
	 *
	 * @var string $phone - Company Phone-Number
	 */
	private $phone = '01734534234324';

	/**
	 * Contains the Company Website
	 *
	 * @var string $internet - Company Website
	 */
	private $internet = 'http://my-site.com';

	/**
	 * Contains the Company Contact-Persons Name (First and Last-name)
	 *
	 * @var string $contact_person - Company Contact-Persons Name (First and Last-name)
	 */
	private $contact_person = 'MyFirstName MyLastName';

	/**
	 * DHL_Company constructor.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		unset($this->company_name);
		unset($this->email);
		unset($this->phone);
		unset($this->internet);
		unset($this->contact_person);
		parent::__destruct();
	}

	/**
	 * @return string
	 */
	public function getCompanyName() {
		return $this->company_name;
	}

	/**
	 * @param string $company_name
	 */
	public function setCompanyName($company_name) {
		$this->company_name = $company_name;
	}

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * @param string $phone
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
	}

	/**
	 * @return string
	 */
	public function getInternet() {
		return $this->internet;
	}

	/**
	 * @param string $internet
	 */
	public function setInternet($internet) {
		$this->internet = $internet;
	}

	/**
	 * @return string
	 */
	public function getContactPerson() {
		return $this->contact_person;
	}

	/**
	 * @param string $contact_person
	 */
	public function setContactPerson($contact_person) {
		$this->contact_person = $contact_person;
	}
}
