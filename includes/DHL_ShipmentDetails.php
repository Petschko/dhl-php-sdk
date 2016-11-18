<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
 * Authors-Website: http://petschko.org/
 * Date: 18.11.2016
 * Time: 13:07
 * Update: -
 * Version: 0.0.1
 *
 * Notes: Details for a Shipment (Like size/Weight etc)
 */

/**
 * Class DHL_ShipmentDetails
 */
class DHL_ShipmentDetails {
	/*$s['ShipmentItem'] = array();
			$s['ShipmentItem']['WeightInKG'] = '5';
			$s['ShipmentItem']['LengthInCM'] = '50';
			$s['ShipmentItem']['WidthInCM'] = '50';
			$s['ShipmentItem']['HeightInCM'] = '50';
			$s['ShipmentItem']['PackageType'] = 'PK';*/
	/**
	 * DHL-Package-Type "Palette"
	 */
	const PALETTE = 'PL';

	/**
	 * DHL-Package-Type "Package"
	 */
	const PACKAGE = 'PK';
	// todo add missing package types as const

	/**
	 * Weight of the Shipment-Object in KG
	 *
	 * @var int - Weight in KG
	 */
	private $weight = 5;

	/**
	 * Length of the Shipment-Object in CM
	 *
	 * @var int - Length in CM
	 */
	private $length = 50;

	/**
	 * Width of the Shipment-Object in CM
	 *
	 * @var int - Width in CM
	 */
	private $width = 50;

	/**
	 * Height of the Shipment-Object in CM
	 *
	 * @var int - Height in CM
	 */
	private $height = 50;

	/**
	 * Type of the Package
	 *
	 * @var string - Package-Type
	 */
	private $packageType = self::PACKAGE;

	/**
	 * DHL_ShipmentDetails constructor.
	 */
	public function __construct() {
		// VOID
	}

	/**
	 * Clears the Memory
	 */
	public function __destruct() {
		unset($this->weight);
		unset($this->length);
		unset($this->width);
		unset($this->height);
		unset($this->packageType);
	}

	/**
	 * @return int
	 */
	public function getWeight() {
		return $this->weight;
	}

	/**
	 * @param int $weight
	 */
	public function setWeight($weight) {
		$this->weight = $weight;
	}

	/**
	 * @return int
	 */
	public function getLength() {
		return $this->length;
	}

	/**
	 * @param int $length
	 */
	public function setLength($length) {
		$this->length = $length;
	}

	/**
	 * @return int
	 */
	public function getWidth() {
		return $this->width;
	}

	/**
	 * @param int $width
	 */
	public function setWidth($width) {
		$this->width = $width;
	}

	/**
	 * @return int
	 */
	public function getHeight() {
		return $this->height;
	}

	/**
	 * @param int $height
	 */
	public function setHeight($height) {
		$this->height = $height;
	}

	/**
	 * @return string
	 */
	public function getPackageType() {
		return $this->packageType;
	}

	/**
	 * @param string $packageType
	 */
	public function setPackageType($packageType) {
		$this->packageType = $packageType;
	}
}
