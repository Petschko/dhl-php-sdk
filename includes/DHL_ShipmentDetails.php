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
	/**
	 * DHL-Package-Type "Palette"
	 */
	const PALETTE = 'PL';

	/**
	 * DHL-Package-Type "Package"
	 */
	const PACKAGE = 'PK';

	/**
	 * Product-Types
	 */
	const PRODUCT_TYPE_NATIONAL_PACKAGE = 'V01PAK';
	const PRODUCT_TYPE_INTERNATIONAL_PACKAGE = 'V53WPAK';
	const PRODUCT_TYPE_EUROPA_PACKAGE = 'V54EPAK';
	const PRODUCT_TYPE_SAME_DAY_PACKAGE = 'V06PAK';
	const PRODUCT_TYPE_SAME_DAY_MESSENGER = 'V06TG';
	const PRODUCT_TYPE_WISH_TIME_MESSENGER = 'V06WZ';
	const PRODUCT_TYPE_AUSTRIA_PACKAGE = 'V86PARCEL';
	const PRODUCT_TYPE_AUSTRIA_INTERNATIONAL_PACKAGE = 'V82PARCEL';
	const PRODUCT_TYPE_CONNECT_PACKAGE = 'V87PARCEL';

	/**
	 * @var string $product
	 */
	private $product = self::PRODUCT_TYPE_NATIONAL_PACKAGE;

	/**
	 * Min-Len: 14
	 * Max-Len: 14
	 *
	 * @var string $accountNumber
	 */
	private $accountNumber;

	/**
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $customerReference
	 */
	private $customerReference = null;

	/**
	 * Note: ISO-Date-Format (YYYY-MM-DD)
	 * Min-Len: 10
	 * Max-Len: 10
	 *
	 * @var string|null $shipmentDate - Shipment-Data or null (= Today if Sunday then +1 Day)
	 */
	private $shipmentDate = null;

	/**
	 * Note: Optional
	 * Min-Len: 14
	 * Max-Len: 14
	 *
	 * @var string|null $returnAccountNumber
	 */
	private $returnAccountNumber = null;

	/**
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $returnReference
	 */
	private $returnReference = null;

	/**
	 * Weight of the Shipment-Object in KG
	 *
	 * @var float $weight - Weight in KG
	 */
	private $weight = 5.0;

	/**
	 * Length of the Shipment-Object in CM
	 *
	 * Note: Optional
	 *
	 * @var int|null $length - Length in CM
	 */
	private $length = null;

	/**
	 * Width of the Shipment-Object in CM
	 *
	 * Note: Optional
	 *
	 * @var int|null $width - Width in CM
	 */
	private $width = null;

	/**
	 * Height of the Shipment-Object in CM
	 *
	 * Note: Optional
	 *
	 * @var int|null $height - Height in CM
	 */
	private $height = null;

	/**
	 * Type of the Package
	 *
	 * Note: Optional
	 *
	 * @var string $packageType - Package-Type
	 */
	private $packageType = self::PACKAGE;

	/**
	 * DHL_ShipmentDetails constructor.
	 *
	 * @param string $accountNumber - Account-Number
	 */
	public function __construct($accountNumber) {
		$this->setAccountNumber($accountNumber);
	}

	/**
	 * Clears the Memory
	 */
	public function __destruct() {
		unset($this->product);
		unset($this->accountNumber);
		unset($this->customerReference);
		unset($this->shipmentDate);
		unset($this->returnAccountNumber);
		unset($this->returnReference);
		unset($this->weight);
		unset($this->length);
		unset($this->width);
		unset($this->height);
		unset($this->packageType);
	}

	/**
	 * @return string
	 */
	public function getProduct() {
		return $this->product;
	}

	/**
	 * @param string $product
	 */
	public function setProduct($product) {
		$this->product = $product;
	}

	/**
	 * @return string
	 */
	private function getAccountNumber() {
		return $this->accountNumber;
	}

	/**
	 * @param string $accountNumber
	 */
	private function setAccountNumber($accountNumber) {
		$this->accountNumber = $accountNumber;
	}

	/**
	 * @return null|string
	 */
	public function getCustomerReference() {
		return $this->customerReference;
	}

	/**
	 * @param null|string $customerReference
	 */
	public function setCustomerReference($customerReference) {
		$this->customerReference = $customerReference;
	}

	/**
	 * @return string
	 */
	public function getShipmentDate() {
		if($this->shipmentDate === null)
			$this->setShipmentDate($this->createDefaultShipmentDate());

		return $this->shipmentDate;
	}

	/**
	 * @param string|null $shipmentDate
	 */
	public function setShipmentDate($shipmentDate) {
		$this->shipmentDate = $shipmentDate;
	}

	/**
	 * @return null|string
	 */
	public function getReturnAccountNumber() {
		return $this->returnAccountNumber;
	}

	/**
	 * @param null|string $returnAccountNumber
	 */
	public function setReturnAccountNumber($returnAccountNumber) {
		$this->returnAccountNumber = $returnAccountNumber;
	}

	/**
	 * @return null|string
	 */
	public function getReturnReference() {
		return $this->returnReference;
	}

	/**
	 * @param null|string $returnReference
	 */
	public function setReturnReference($returnReference) {
		$this->returnReference = $returnReference;
	}

	/**
	 * @return float
	 */
	public function getWeight() {
		return $this->weight;
	}

	/**
	 * @param float $weight
	 */
	public function setWeight($weight) {
		$this->weight = $weight;
	}

	/**
	 * @return int|null
	 */
	public function getLength() {
		return $this->length;
	}

	/**
	 * @param int|null $length
	 */
	public function setLength($length) {
		$this->length = $length;
	}

	/**
	 * @return int|null
	 */
	public function getWidth() {
		return $this->width;
	}

	/**
	 * @param int|null $width
	 */
	public function setWidth($width) {
		$this->width = $width;
	}

	/**
	 * @return int|null
	 */
	public function getHeight() {
		return $this->height;
	}

	/**
	 * @param int|null $height
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

	/**
	 * Creates a Default Shipment-Date (Today or if Sunday the next Day)
	 *
	 * @return string - Default-Date
	 */
	private function createDefaultShipmentDate() {
		$now = time();
		$weekDay = date('w', $now);

		if($weekDay === 0)
			$now += 86400; // Increase Day by 1 if Sunday

		return date('Y-m-d', $now);
	}

	/**
	 * Returns an DHL-Class of this Object for DHL-Shipment Details
	 *
	 * @return StdClass - ShipmentDetailsClass
	 */
	public function getShipmentDetailsClass_v1() {
		// todo implement
		return new StdClass;
	}

	/**
	 * Returns an DHL-Class of this Object for DHL-Shipment Details
	 *
	 * @return StdClass - ShipmentDetailsClass
	 */
	public function getShipmentDetailsClass_v2() {
		$class = new StdClass;

		$class->product = $this->getProduct();
		$class->accountNumber = $this->getAccountNumber();
		if($this->getCustomerReference() !== null)
			$class->customerReference = $this->getCustomerReference();
		$class->shipmentDate = $this->getShipmentDate();
		if($this->getReturnAccountNumber() !== null)
			$class->returnShipmentAccountNumber = $this->getReturnAccountNumber();
		if($this->getReturnReference() !== null)
			$class->returnShipmentReference = $this->getReturnReference();
		$class->ShipmentItem = new StdClass;
		$class->ShipmentItem->weightInKG = $this->getWeight();
		if($this->getLength() !== null)
			$class->ShipmentItem->lengthInCM = $this->getLength();
		if($this->getWidth() !== null)
			$class->ShipmentItem->widthInCM = $this->getWidth();
		if($this->getHeight() !== null)
			$class->ShipmentItem->heightInCM = $this->getHeight();

		return $class;
	}
}
