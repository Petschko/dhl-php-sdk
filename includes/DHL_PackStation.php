<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
 * Authors-Website: http://petschko.org/
 * Date: 17.03.2017
 * Time: 12:09
 * Update: 20.03.2017
 * Version: 1.0.2
 *
 * Notes: Contains the DHL_PackStation class
 */

/**
 * Class DHL_PackStation
 */
class DHL_PackStation extends DHL_Receiver {
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
	 * Contains the Pack-Station-Number
	 *
	 * Min-Len: 3
	 * Max-Len: 3
	 *
	 * @var string $packStationNumber - Pack-Station-Number
	 */
	private $packStationNumber = '';

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
		unset($this->packStationNumber);
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
	public function getPackStationNumber() {
		return $this->packStationNumber;
	}

	/**
	 * @param string $packStationNumber
	 */
	public function setPackStationNumber($packStationNumber) {
		$this->packStationNumber = $packStationNumber;
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

		if($this->getPostNumber() !== null)
			$class->postNumber = $this->getPostNumber();
		$class->packstationNumber = $this->getPackStationNumber();
		$class->zip = $this->getZip();
		$class->city = $this->getLocation();

		if($this->getCountryISOCode() !== null) {
			$class->Origin = new StdClass;

			if($this->getCountry() !== null)
				$class->Origin->country = $this->getCountry();

			$class->Origin->countryISOCode = $this->getCountryISOCode();

			if($this->getState() !== null)
				$class->Origin->state = $this->getState();
		}

		return $class;
	}
}
