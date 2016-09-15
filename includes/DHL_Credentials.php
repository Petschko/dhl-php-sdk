<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
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
	 * Contains the DHL-Intraship Username
	 *
	 * @var string $user - DHL-Intraship Username
	 */
	private $user = '';

	/**
	 * Contains the DHL-Intraship Password
	 *
	 * @var string $signature - DHL-Intraship Password
	 */
	private $signature = '';

	/**
	 * Contains the DHL-Customer ID
	 *
	 * @var string $epk - DHL-Customer ID
	 */
	private $epk = '';

	/**
	 * Contains the App ID from the developer Account
	 *
	 * @var string $api_user - App ID from the developer Account
	 */
	private $api_user = '';

	/**
	 * Contains the App token from the developer Account
	 *
	 * @var string $api_password - Contains the App token from the developer Account
	 */
	private $api_password = '';

	/**
	 * DHL_Credentials constructor.
	 */
	public function __construct() {
		// VOID
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
	 * @param string $user
	 */
	public function setUser($user) {
		$this->user = $user;
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
	 * @return string
	 */
	public function getEpk() {
		return $this->epk;
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
