<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
 * Authors-Website: http://petschko.org/
 * Date: 15.09.2016
 * Time: 14:23
 * Update: -
 * Version: 0.0.1
 *
 * Notes: Contains the DHL_Receiver class - Checkout the original repo: https://github.com/tobias-redmann/dhl-php-sdk
 */

/**
 * Class DHL_Receiver
 */
class DHL_Receiver extends Address {
	/**
	 * Contains the Receivers First Name
	 *
	 * @var string - Receivers First Name
	 */
	private $first_name = 'Peter';

	/**
	 * Contains the Receivers Last Name
	 *
	 * @var string - Receivers Last Name
	 */
	private $last_name = 'Dragicevic';

	/**
	 * todo what is that
	 *
	 * @var string - unknown leave it empty
	 */
	private $c_o = '';

	/**
	 * DHL_Receiver constructor.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		unset($this->first_name);
		unset($this->last_name);
		unset($this->c_o);
		parent::__destruct();
	}

	/**
	 * @return string
	 */
	public function getFirstName() {
		return $this->first_name;
	}

	/**
	 * @param string $first_name
	 */
	public function setFirstName($first_name) {
		$this->first_name = $first_name;
	}

	/**
	 * @return string
	 */
	public function getLastName() {
		return $this->last_name;
	}

	/**
	 * @param string $last_name
	 */
	public function setLastName($last_name) {
		$this->last_name = $last_name;
	}

	/**
	 * @return string
	 */
	public function getCO() {
		return $this->c_o;
	}

	/**
	 * @param string $c_o
	 */
	public function setCO($c_o) {
		$this->c_o = $c_o;
	}
}
