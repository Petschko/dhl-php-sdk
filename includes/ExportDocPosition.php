<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 10.04.2017
 * Time: 12:48
 * Update: 06.08.2018
 * Version: 0.0.5
 *
 * Notes: Contains the ExportDocPosition class
 */

use stdClass;

/**
 * Class ExportDocPosition
 *
 * @package Petschko\DHL
 *
 * Note: If min 1 value is filled out, all other values are required (else none is required)
 */
class ExportDocPosition {
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
	 * @var string|null $customsTariffNumber - Customs tariff number of the unit / position (HS-code) or null for none
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
	 * ExportDocPosition constructor.
	 *
	 * @param string $description - Description of the unit / position
	 * @param string $countryCodeOrigin - Origin Country-ISO-Code
	 * @param string|null $customsTariffNumber - Customs tariff number of the unit / position (HS-code) or null for none
	 * @param int $amount - Quantity of the unit / position
	 * @param int|float $netWeightInKG - Net weight of the unit / position
	 * @param int|float $customsValue - Customs value amount of the unit / position
	 */
	public function __construct($description, $countryCodeOrigin, $customsTariffNumber, $amount, $netWeightInKG, $customsValue) {
		if(! $description || ! $countryCodeOrigin || ! $amount || ! $netWeightInKG || ! $customsValue) {
			trigger_error('PHP-DHL-API: ' . __CLASS__ . '->' . __FUNCTION__ .
				': All values must be filled out! (Not null, Not false, Not 0, Not "", Not empty) - Ignore this function for this call now', E_USER_WARNING);
			error_log('PHP-DHL-API: ' . __CLASS__ . '->' . __FUNCTION__ .
				': All values must be filled out! (Not null, Not false, Not 0, Not "", Not empty) - Ignore this function for this call now', E_USER_WARNING);
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
	 * Get the Description
	 *
	 * @return string|null - Description or null on failure
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Set the Description
	 *
	 * @param string $description - Description
	 */
	private function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Get the Country Code Origin
	 *
	 * @return string|null - Country Code Origin or null on failure
	 */
	public function getCountryCodeOrigin() {
		return $this->countryCodeOrigin;
	}

	/**
	 * Set the Country Code Origin
	 *
	 * @param string $countryCodeOrigin - Country Code Origin
	 */
	private function setCountryCodeOrigin($countryCodeOrigin) {
		$this->countryCodeOrigin = $countryCodeOrigin;
	}

	/**
	 * Get the Custom Tariff Number
	 *
	 * @return float|int|string|null - Custom Tariff Number or null for none
	 */
	public function getCustomsTariffNumber() {
		return $this->customsTariffNumber;
	}

	/**
	 * Set the Custom Tariff Number
	 *
	 * @param float|int|string|null $customsTariffNumber - Custom Tariff Number or null for none
	 */
	private function setCustomsTariffNumber($customsTariffNumber) {
		$this->customsTariffNumber = $customsTariffNumber;
	}

	/**
	 * Get the Amount
	 *
	 * @return int|null - Amount or null on failure
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * Set the Amount
	 *
	 * @param int $amount - Amount
	 */
	private function setAmount($amount) {
		$this->amount = $amount;
	}

	/**
	 * Get the Weight in KG
	 *
	 * @return float|null - Weight in KG or null on failure
	 */
	public function getNetWeightInKG() {
		return $this->netWeightInKG;
	}

	/**
	 * Set the Weight in KG
	 *
	 * @param float $netWeightInKG - Weight in KG
	 */
	private function setNetWeightInKG($netWeightInKG) {
		$this->netWeightInKG = $netWeightInKG;
	}

	/**
	 * Get the Customs Value for the Unit / Package
	 *
	 * @return float|null - Custom Value for the Unit / Package or null on failure
	 */
	public function getCustomsValue() {
		return $this->customsValue;
	}

	/**
	 * Sets the Customs Value for the Unit / Package
	 *
	 * @param float $customsValue - Customs Value for the Unit / Package
	 */
	private function setCustomsValue($customsValue) {
		$this->customsValue = $customsValue;
	}

	/**
	 * Returns a Class for ExportDocPosition
	 *
	 * @return StdClass - DHL-ExportDocPosition-Class
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	protected function getExportDocPositionClass_v1() {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		$class = new StdClass;

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
