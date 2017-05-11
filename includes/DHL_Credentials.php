<?php
/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 15.09.2016
 * Time: 14:26
 * Update: -
 * Version: 0.0.1
 *
 * Notes: Contains the DHL_Credentials class - Checkout the original repo: https://github.com/tobias-redmann/dhl-php-sdk
 */

/**
 * Class DHL_Credentials
 */
class DHL_Credentials {
	/**
	 * DHL Business-API Test-User
	 */
	const DHL_BUSINESS_TEST_USER = '2222222222_01';

	/**
	 * DHL Business-API Test-User-Password
	 */
	const DHL_BUSINESS_TEST_USER_PASSWORD = 'pass';

	/**
	 * DHL Business-API Test-EPK
	 */
	const DHL_BUSINESS_TEST_EPK = '2222222222';

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
	 * TEST: Use the Test-EPK for Business-Shipment - Use in constructor true as 1st param
	 * LIVE: Your DHL-Customer-Number (At least the first 10 Numbers - Can be more)
	 *
	 * @var string $epk - DHL-Customer ID
	 */
	private $epk = '';

	/**
	 * Contains the App ID from the developer Account
	 *
	 * TEST: Your-DHL-Developer-Account-Name (Not E-Mail!)
	 * (You can create yourself an Account for free here: https://entwickler.dhl.de/group/ep )
	 *
	 * LIVE: Your Applications-ID
	 * (You can get this here: https://entwickler.dhl.de/group/ep/home?myaction=viewFreigabe )
	 *
	 * @var string $api_user - App ID from the developer Account
	 */
	private $api_user = '';

	/**
	 * Contains the App token from the developer Account
	 *
	 * TEST: Your-DHL-Developer-Accounts-Password
	 * (You can create yourself an Account for free here: https://entwickler.dhl.de/group/ep )
	 *
	 * LIVE: Your Applications-Token
	 * (You can get this here: https://entwickler.dhl.de/group/ep/home?myaction=viewFreigabe )
	 *
	 * @var string $api_password - Contains the App token from the developer Account
	 */
	private $api_password = '';

	/**
	 * DHL_Credentials constructor.
	 *
	 * If Test-Modus is true it will set Test-User, Test-Signature, Test-EPK for you!
	 *
	 * @param bool $useTest - Use Test-Modus or Live Modus (true = test | false = live)
	 */
	public function __construct($useTest = false) {
		if($useTest) {
			$this->setUser(self::DHL_BUSINESS_TEST_USER);
			$this->setSignature(self::DHL_BUSINESS_TEST_USER_PASSWORD);
			$this->setEpk(self::DHL_BUSINESS_TEST_EPK);
		}
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		unset($this->user);
		unset($this->signature);
		unset($this->epk);
		unset($this->api_user);
		unset($this->api_password);
	}

	/**
	 * @return string
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Sets the User in lower case
	 *
	 * @param string $user - Username
	 */
	public function setUser($user) {
		$this->user = mb_strtolower($user);
	}

	/**
	 * @return string
	 */
	public function getSignature() {
		return $this->signature;
	}

	/**
	 * @param string $signature
	 */
	public function setSignature($signature) {
		$this->signature = $signature;
	}

	/**
	 * Get the first 10 Digits of the EPK
	 *
	 * @param null|int $len - Max-Chars to get from this String or null for all
	 * @return string - EPK-Number with x Chars
	 */
	public function getEpk($len = null) {
		return mb_substr($this->epk, 0, $len);
	}

	/**
	 * @param string $epk
	 */
	public function setEpk($epk) {
		$this->epk = $epk;
	}

	/**
	 * @return string
	 */
	public function getApiUser() {
		return $this->api_user;
	}

	/**
	 * @param string $api_user
	 */
	public function setApiUser($api_user) {
		$this->api_user = $api_user;
	}

	/**
	 * @return string
	 */
	public function getApiPassword() {
		return $this->api_password;
	}

	/**
	 * @param string $api_password
	 */
	public function setApiPassword($api_password) {
		$this->api_password = $api_password;
	}
}
