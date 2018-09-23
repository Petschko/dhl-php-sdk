<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 15.09.2016
 * Time: 14:26
 * Update: 14.08.2018
 * Version: 0.1.0
 *
 * Notes: Contains the Credentials class - Checkout the original repo: https://github.com/tobias-redmann/dhl-php-sdk
 */

/**
 * Class Credentials
 *
 * @package Petschko\DHL
 */
class Credentials {
	// Test-Type Constants
	/**
	 * DHL-Test-Mode (Normal)
	 */
	const TEST_NORMAL = 'test';

	/**
	 * DHL-Test-Mode (Thermo-Printer)
	 */
	const TEST_THERMO_PRINTER = 'thermo';

	// Test-User Value Constants
	/**
	 * DHL Business-API Test-User (Normal)
	 */
	const DHL_BUSINESS_TEST_USER = '2222222222_01';

	/**
	 * DHL Business-API Test-User (Thermo)
	 */
	const DHL_BUSINESS_TEST_USER_THERMO = '2222222222_03';

	/**
	 * DHL Business-API Test-User-Password
	 */
	const DHL_BUSINESS_TEST_USER_PASSWORD = 'pass';

	/**
	 * DHL Business-API Test-EKP
	 *
	 * @deprecated - Typo in name...
	 */
	const DHL_BUSINESS_TEST_EPK = '2222222222'; // Still in here for backward compatibility

	/**
	 * DHL Business-API Test-EKP
	 */
	const DHL_BUSINESS_TEST_EKP = '2222222222';

	/**
	 * Contains the DHL-Intraship Username
	 *
	 * TEST: Use the Test-User for Business-Shipment - Use in constructor true as 1st param
	 * LIVE: Your DHL-Account same when you Login to the DHL-Business-Customer-Portal
	 * (Same as on this Page: https://www.dhl-geschaeftskundenportal.de/ )
	 *
	 * @var string $user - DHL-Intraship Username
	 */
	private $user = '';

	/**
	 * Contains the DHL-Intraship Password
	 *
	 * TEST: Use the Test-Password for Business-Shipment - Use in constructor true as 1st param
	 * LIVE: Your DHL-Account-Password same when you Login to the DHL-Business-Customer-Portal
	 * (Same as on this Page: https://www.dhl-geschaeftskundenportal.de/ )
	 *
	 * @var string $signature - DHL-Intraship Password
	 */
	private $signature = '';

	/**
	 * Contains the DHL-Customer ID
	 *
	 * TEST: Use the Test-EKP for Business-Shipment - Use in constructor true as 1st param
	 * LIVE: Your DHL-Customer-Number (At least the first 10 Numbers - Can be more)
	 *
	 * @var string $ekp - DHL-Customer ID
	 */
	private $ekp = '';

	/**
	 * Contains the App ID from the developer Account
	 *
	 * TEST: Your-DHL-Developer-Account-Name (Not E-Mail!)
	 * (You can create yourself an Account for free here: https://entwickler.dhl.de/group/ep )
	 *
	 * LIVE: Your Applications-ID
	 * (You can get this here: https://entwickler.dhl.de/group/ep/home?myaction=viewFreigabe )
	 *
	 * @var string $apiUser - App ID from the developer Account
	 */
	private $apiUser = '';

	/**
	 * Contains the App token from the developer Account
	 *
	 * TEST: Your-DHL-Developer-Accounts-Password
	 * (You can create yourself an Account for free here: https://entwickler.dhl.de/group/ep )
	 *
	 * LIVE: Your Applications-Token
	 * (You can get this here: https://entwickler.dhl.de/group/ep/home?myaction=viewFreigabe )
	 *
	 * @var string $apiPassword - Contains the App token from the developer Account
	 */
	private $apiPassword = '';

	/**
	 * Credentials constructor.
	 *
	 * If Test-Modus is true it will set Test-User, Test-Signature, Test-EKP for you!
	 *
	 * @param bool|string $testMode - Use a specific Test-Mode or Live Mode
	 * 					Test-Mode (Normal): Credentials::TEST_NORMAL, 'test', true
	 * 					Test-Mode (Thermo-Printer): Credentials::TEST_THERMO_PRINTER, 'thermo'
	 * 					Live (No-Test-Mode): false - default
	 */
	public function __construct($testMode = false) {
		if($testMode) {
			switch($testMode) {
				case self::TEST_THERMO_PRINTER:
					$this->setUser(self::DHL_BUSINESS_TEST_USER_THERMO);
					break;
				case self::TEST_NORMAL:
				case true:
				default:
					$this->setUser(self::DHL_BUSINESS_TEST_USER);
			}

			$this->setSignature(self::DHL_BUSINESS_TEST_USER_PASSWORD);
			$this->setEkp(self::DHL_BUSINESS_TEST_EKP);
		}
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		unset($this->user);
		unset($this->signature);
		unset($this->ekp);
		unset($this->apiUser);
		unset($this->apiPassword);
	}

	/**
	 * Get the DHL-Intraship Username
	 *
	 * @return string - DHL-Intraship Username
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Sets the DHL-Intraship Username in lower case
	 *
	 * @param string $user - DHL-Intraship Username
	 */
	public function setUser($user) {
		$this->user = mb_strtolower($user);
	}

	/**
	 * Get the DHL-Intraship Password
	 *
	 * @return string - DHL-Intraship Password
	 */
	public function getSignature() {
		return $this->signature;
	}

	/**
	 * Set the DHL-Intraship Password
	 *
	 * @param string $signature - DHL-Intraship Password
	 */
	public function setSignature($signature) {
		$this->signature = $signature;
	}

	/**
	 * Get the (x first Digits of the) EKP
	 *
	 * @param null|int $len - Max-Chars to get from this String or null for all
	 * @return string - EKP-Number with x Chars
	 */
	public function getEkp($len = null) {
		return mb_substr($this->ekp, 0, $len);
	}

	/**
	 * Alias for $this->getEkp
	 *
	 * @param null|int $len - Max-Chars to get from this String or null for all
	 * @return string - EKP-Number with x Chars
	 *
	 * @deprecated - Invalid name of the function
	 */
	public function getEpk($len = null) {
		trigger_error('Called deprecated method ' . __METHOD__ . ': Use getEkp() instead, this method will removed in the future!', E_USER_DEPRECATED);

		return $this->getEkp($len);
	}

	/**
	 * Set the EKP-Number
	 *
	 * @param string $ekp - EKP-Number
	 */
	public function setEkp($ekp) {
		$this->ekp = $ekp;
	}

	/**
	 * Alias for $this->setEkp
	 *
	 * @param string $ekp - EKP-Number
	 *
	 * @deprecated - Invalid name of the function
	 */
	public function setEpk($ekp) {
		trigger_error('Called deprecated method ' . __METHOD__ . ': Use setEkp() instead, this method will removed in the future!', E_USER_DEPRECATED);

		$this->setEkp($ekp);
	}

	/**
	 * Get the API-User
	 *
	 * @return string - API-User
	 */
	public function getApiUser() {
		return $this->apiUser;
	}

	/**
	 * Set the API-User
	 *
	 * @param string $apiUser - API-User
	 */
	public function setApiUser($apiUser) {
		$this->apiUser = $apiUser;
	}

	/**
	 * Get the API-Password/Key
	 *
	 * @return string - API-Password/Key
	 */
	public function getApiPassword() {
		return $this->apiPassword;
	}

	/**
	 * Alias for $this->getApiPassword
	 *
	 * @return string - API-Password/Key
	 */
	public function getApiKey() {
		return $this->getApiPassword();
	}

	/**
	 * Set the API-Password/Key
	 *
	 * @param string $apiPassword - API-Password/Key
	 */
	public function setApiPassword($apiPassword) {
		$this->apiPassword = $apiPassword;
	}

	/**
	 * Alias for $this->setApiPassword
	 *
	 * @param string $apiKey - API-Password/Key
	 */
	public function setApiKey($apiKey) {
		$this->setApiPassword($apiKey);
	}
}
