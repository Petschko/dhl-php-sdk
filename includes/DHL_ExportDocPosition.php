<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
 * Authors-Website: http://petschko.org/
 * Date: 10.04.2017
 * Time: 12:48
 * Update: 10.04.2017
 * Version: 0.0.2
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
	 * DHL_ExportDocPosition constructor.
	 *
	 * @param string $description - Description of the unit / position
	 * @param string $countryCodeOrigin - Origin Country-ISO-Code
	 * @param float|int|string $customsTariffNumber - Customs tariff number of the unit / position
	 * @param int $amount - Quantity of the unit / position
	 * @param int|float $netWeightInKG - Net weight of the unit / position
	 * @param int|float $customsValue - Customs value amount of the unit / position
	 */
	public function __construct($description, $countryCodeOrigin, $customsTariffNumber, $amount, $netWeightInKG, $customsValue) {
		if(! $description || ! $countryCodeOrigin || ! $customsTariffNumber || ! $amount || ! $netWeightInKG || ! $customsValue) {
			error_log('PHP-DHL-API: ' . __CLASS__ . '->' . __FUNCTION__ .
				': All values must be filled out! (Not null, Not false, Not 0, Not "", Not empty) - Ignore this function for this call now');
			return;
		}

		$this->setDescription($description);
		$this->setCountryCodeOrigin($countryCodeOrigin);
		$this->setCustomsTariffNumber($customsTariffNumber);
		$this->setAmount($amount);
		$this->setNetWeightInKG((float) $netWeightInKG);
		$this->setCustomsValue((float) $customsValue);
	}

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
	 * @param string|null $description
	 */
	private function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return string|null
	 */
	public function getCountryCodeOrigin() {
		return $this->countryCodeOrigin;
	}

	/**
	 * @param string|null $countryCodeOrigin
	 */
	private function setCountryCodeOrigin($countryCodeOrigin) {
		$this->countryCodeOrigin = $countryCodeOrigin;
	}

	/**
	 * @return float|int|string|null
	 */
	public function getCustomsTariffNumber() {
		return $this->customsTariffNumber;
	}

	/**
	 * @param float|int|string|null $customsTariffNumber
	 */
	private function setCustomsTariffNumber($customsTariffNumber) {
		$this->customsTariffNumber = $customsTariffNumber;
	}

	/**
	 * @return int|null
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * @param int|null $amount
	 */
	private function setAmount($amount) {
		$this->amount = $amount;
	}

	/**
	 * @return float|null
	 */
	public function getNetWeightInKG() {
		return $this->netWeightInKG;
	}

	/**
	 * @param float|null $netWeightInKG
	 */
	private function setNetWeightInKG($netWeightInKG) {
		$this->netWeightInKG = $netWeightInKG;
	}

	/**
	 * @return float|null
	 */
	public function getCustomsValue() {
		return $this->customsValue;
	}

	/**
	 * @param float|null $customsValue
	 */
	private function setCustomsValue($customsValue) {
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
	 * Returns a Class for ExportDocPosition
	 *
	 * @return StdClass - DHL-ExportDocPosition-Class
	 */
	public function getExportDocPositionClass_v2() {
		$class = new StdClass;

		$class->description = $this->getDescription();
		$class->countryCodeOrigin = $this->getCountryCodeOrigin();
		$class->customsTariffNumber = $this->getCustomsTariffNumber();
		$class->amount = $this->getAmount();
		$class->netWeightInKG = $this->getNetWeightInKG();
		$class->customsValue = $this->getCustomsValue();

		return $class;
	}
}
