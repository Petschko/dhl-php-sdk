<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
 * Authors-Website: http://petschko.org/
 * Date: 10.04.2017
 * Time: 12:48
 * Update: -
 * Version: 0.0.1
 *
 * Notes: Contains the DHL_ExportDocPosition class
 * ToDo: Please edit/add more details to the doc comments if you know more about them
 */

/**
 * Class DHL_ExportDocPosition
 *
 * Note: If min 1 value is filled out, all other values are required (else none is required)
 */
class DHL_ExportDocPosition {
	/**
	 * Description of the unit / position
	 *
	 * Min-Len: -
	 * Max-Len: 256
	 *
	 * @var string|null $description - Description of the unit / position
	 */
	private $description = null;

	/**
	 * Origin Country-ISO-Code
	 *
	 * Min-Len: 2
	 * Max-Len: 2
	 *
	 * @var string|null $countryCodeOrigin - Origin Country-ISO-Code
	 */
	private $countryCodeOrigin = null;

	/**
	 * Customs tariff number of the unit / position
	 *
	 * Min-Len: -
	 * Max-Len: 10
	 *
	 * // todo/fixme: is this just an int or float?
	 * @var int|float|string|null $customsTariffNumber - Customs tariff number of the unit / position
	 */
	private $customsTariffNumber = null;

	/**
	 * Quantity of the unit / position
	 *
	 * @var int|null $amount - Quantity of the unit / position
	 */
	private $amount = null;

	/**
	 * Net weight of the unit / position
	 *
	 * @var float|null $netWeightInKG - Net weight of the unit / position
	 */
	private $netWeightInKG = null;

	/**
	 * Customs value amount of the unit / position
	 *
	 * @var float|null $customsValue - Customs value amount of the unit / position
	 */
	private $customsValue = null;

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		unset($this->description);
		unset($this->countryCodeOrigin);
		unset($this->customsTariffNumber);
		unset($this->amount);
		unset($this->netWeightInKG);
		unset($this->customsValue);
	}

	/**
	 * @return string|null
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	protected function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return string|null
	 */
	public function getCountryCodeOrigin() {
		return $this->countryCodeOrigin;
	}

	/**
	 * @param string $countryCodeOrigin
	 */
	protected function setCountryCodeOrigin($countryCodeOrigin) {
		$this->countryCodeOrigin = $countryCodeOrigin;
	}

	/**
	 * @return float|int|string|null
	 */
	public function getCustomsTariffNumber() {
		return $this->customsTariffNumber;
	}

	/**
	 * @param float|int|string $customsTariffNumber
	 */
	protected function setCustomsTariffNumber($customsTariffNumber) {
		$this->customsTariffNumber = $customsTariffNumber;
	}

	/**
	 * @return int|null
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * @param int $amount
	 */
	protected function setAmount($amount) {
		$this->amount = $amount;
	}

	/**
	 * @return float|null
	 */
	public function getNetWeightInKG() {
		return $this->netWeightInKG;
	}

	/**
	 * @param float $netWeightInKG
	 */
	protected function setNetWeightInKG($netWeightInKG) {
		$this->netWeightInKG = $netWeightInKG;
	}

	/**
	 * @return float|null
	 */
	public function getCustomsValue() {
		return $this->customsValue;
	}

	/**
	 * @param float $customsValue
	 */
	protected function setCustomsValue($customsValue) {
		$this->customsValue = $customsValue;
	}

	/**
	 * @return StdClass
	 */
	protected function getExportDocPositionClass_v1() {
		$class = new StdClass;

		// todo implement

		return $class;
	}

	/**
	 * @return StdClass
	 */
	protected function getExportDocPositionClass_v2() {
		$class = new StdClass;

		// todo implement

		return $class;
	}
}
