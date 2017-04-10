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
	 * @var string $description - Description of the unit / position
	 */
	private $description;

	/**
	 * Origin Country-ISO-Code
	 *
	 * Min-Len: 2
	 * Max-Len: 2
	 *
	 * @var string $countryCodeOrigin - Origin Country-ISO-Code
	 */
	private $countryCodeOrigin;

	/**
	 * Customs tariff number of the unit / position
	 *
	 * Min-Len: -
	 * Max-Len: 10
	 *
	 * // todo/fixme: is this just an int or float?
	 * @var int|float|string $customsTariffNumber - Customs tariff number of the unit / position
	 */
	private $customsTariffNumber;

	/**
	 * Quantity of the unit / position
	 *
	 * @var int $amount - Quantity of the unit / position
	 */
	private $amount;

	/**
	 * Net weight of the unit / position
	 *
	 * @var float $netWeightInKG - Net weight of the unit / position
	 */
	private $netWeightInKG;

	/**
	 * Customs value amount of the unit / position
	 *
	 * @var float $customsValue - Customs value amount of the unit / position
	 */
	private $customsValue;

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
