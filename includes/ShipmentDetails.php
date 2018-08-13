<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 18.11.2016
 * Time: 13:07
 * Update: 05.08.2018
 * Version: 0.1.2
 *
 * Notes: Details for a Shipment (Like size/Weight etc)
 */

use stdClass;

/**
 * Class ShipmentDetails
 *
 * @package Petschko\DHL
 */
class ShipmentDetails {
	/**
	 * DHL-Package-Type "Palette"
	 *
	 * @deprecated - DHL-API-Version 1 Constant
	 */
	const PALETTE = 'PL';

	/**
	 * DHL-Package-Type "Package"
	 *
	 * @deprecated - DHL-API-Version 1 Constant
	 */
	const PACKAGE = 'PK';

	/**
	 * Product-Type Values:
	 *
	 * - ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE -> National-Package
	 * - ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE_PRIO -> National-Package-Prio
	 * - ShipmentDetails::PRODUCT_TYPE_INTERNATIONAL_PACKAGE -> International-Package
	 * - ShipmentDetails::PRODUCT_TYPE_EUROPA_PACKAGE -> Europa-Package
	 * - ShipmentDetails::PRODUCT_TYPE_PACKED_CONNECT -> Packed Connect
	 * - ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE -> Same-Day Package
	 * - ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER -> Same Day Messenger
	 * - ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER -> Wish Time Messenger
	 * - ShipmentDetails::PRODUCT_TYPE_AUSTRIA_PACKAGE -> Austria Package
	 * - ShipmentDetails::PRODUCT_TYPE_AUSTRIA_INTERNATIONAL_PACKAGE -> Austria International Package
	 * - ShipmentDetails::PRODUCT_TYPE_CONNECT_PACKAGE -> Connect Package
	 */
	const PRODUCT_TYPE_NATIONAL_PACKAGE = 'V01PAK';
	const PRODUCT_TYPE_NATIONAL_PACKAGE_PRIO = 'V01PRIO';
	const PRODUCT_TYPE_INTERNATIONAL_PACKAGE = 'V53WPAK';
	const PRODUCT_TYPE_EUROPA_PACKAGE = 'V54EPAK';
	const PRODUCT_TYPE_PACKED_CONNECT = 'V55PAK';
	const PRODUCT_TYPE_SAME_DAY_PACKAGE = 'V06PAK';
	const PRODUCT_TYPE_SAME_DAY_MESSENGER = 'V06TG';
	const PRODUCT_TYPE_WISH_TIME_MESSENGER = 'V06WZ';
	const PRODUCT_TYPE_AUSTRIA_PACKAGE = 'V86PARCEL';
	const PRODUCT_TYPE_AUSTRIA_INTERNATIONAL_PACKAGE = 'V82PARCEL';
	const PRODUCT_TYPE_CONNECT_PACKAGE = 'V87PARCEL';

	/**
	 * Contains which Product is used
	 *
	 * Allowed values: (Use PRODUCT_TYPE_* constants - See above)
	 * 	'V01PAK' or ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE -> National-Package
	 * 	'V01PRIO' or ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE_PRIO -> National-Package-Prio
	 * 	'V53WPAK' or ShipmentDetails::PRODUCT_TYPE_INTERNATIONAL_PACKAGE -> International-Package
	 * 	'V54EPAK' or ShipmentDetails::PRODUCT_TYPE_EUROPA_PACKAGE -> Europa-Package
	 * 	'V55PAK' or ShipmentDetails::PRODUCT_TYPE_PACKED_CONNECT -> Packed Connect
	 * 	'V06PAK' or ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE -> Same-Day Package
	 * 	'V06TG' or ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER -> Same Day Messenger
	 * 	'V06WZ' or ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER -> Wish Time Messenger
	 * 	'V86PARCEL' or ShipmentDetails::PRODUCT_TYPE_AUSTRIA_PACKAGE -> Austria Package
	 * 	'V82PARCEL' or ShipmentDetails::PRODUCT_TYPE_AUSTRIA_INTERNATIONAL_PACKAGE -> Austria International Package
	 * 	'V87PARCEL' or ShipmentDetails::PRODUCT_TYPE_CONNECT_PACKAGE -> Connect Package
	 *
	 * @var string $product - Product to use (Default: National Package)
	 */
	private $product = self::PRODUCT_TYPE_NATIONAL_PACKAGE;

	/**
	 * Contains the
	 * EKP Account Number         (10 Digits) Example 123457890
	 * concat Product Type Number (2 Digits)  Example 01 for V01PAK or 53 for V53WPAK or 07 for Retoure Online
	 * concat Process Type Number (2 Digits)  Example 01 for default or 02 for block pricing/flat fee
	 *                                         = 1234578900101
	 *
	 * More Information: https://entwickler.dhl.de/group/ep/wsapis/geschaeftskundenversand/authentifizierung
	 *
	 * Min-Len: 14
	 * Max-Len: 14
	 *
	 * @var string $accountNumber - Account-Number plus Product Type Number plus Process Type Number
	 */
	private $accountNumber;

	/**
	 * Contains the Customer-Reference
	 *
	 * Note: Optional
	 *
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $customerReference - Customer Reference or null for none
	 */
	private $customerReference = null;

	/**
	 * Contains the Shipment-Date
	 *
	 * Note: ISO-Date-Format (YYYY-MM-DD)
	 *
	 * Min-Len: 10
	 * Max-Len: 10
	 *
	 * @var string|null $shipmentDate - Shipment-Date or null for today (+1 Day if Sunday)
	 */
	private $shipmentDate = null;

	/**
	 * Contains the Return-Account-Number (EKP)
	 *
	 * Note: Optional
	 *
	 * Min-Len: 14
	 * Max-Len: 14
	 *
	 * @var string|null $returnAccountNumber - Return-Account-Number or null for none
	 */
	private $returnAccountNumber = null;

	/**
	 * Contains the Return-Reference
	 *
	 * Note: Optional
	 *
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $returnReference - Return-Reference or null for none
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
	 * Contains the Service Object (Many settings for the Shipment)
	 *
	 * Note: Optional
	 *
	 * @var Service|null $service - Service Object | null for none
	 */
	private $service = null;

	/**
	 * Type of the Package
	 *
	 * Note: Optional
	 *
	 * Allowed values:
	 * 	'PK' or ShipmentDetails::PACKAGE -> DHL-Package-Type "Package"
	 * 	'PL' or ShipmentDetails::PALETTE -> DHL-Package-Type "Palette"
	 *
	 * @var string $packageType - Package-Type
	 *
	 * @deprecated - DHL-API-Version 1 Field
	 */
	private $packageType = self::PACKAGE;

	/**
	 * E-mail address for shipping notification
	 *
	 * Note: Optional
	 *
	 * @var string|null $notificationEmail - Notification E-Mail or null for none
	 */
	private $notificationEmail = null;

	/**
	 * Contains the Bank-Object
	 *
	 * Note: Optional
	 *
	 * @var BankData|null $bank - Bank-Object | null for none
	 */
	private $bank = null;

	/**
	 * ShipmentDetails constructor.
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
		unset($this->service);
		unset($this->packageType);
		unset($this->notificationEmail);
		unset($this->bank);
	}

	/**
	 * Get which Product is used
	 *
	 * 	Return values: (Use PRODUCT_TYPE_* constants - See above)
	 * 	'V01PAK' or ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE -> National-Package
	 * 	'V01PRIO' or ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE_PRIO -> National-Package-Prio
	 * 	'V53WPAK' or ShipmentDetails::PRODUCT_TYPE_INTERNATIONAL_PACKAGE -> International-Package
	 * 	'V54EPAK' or ShipmentDetails::PRODUCT_TYPE_EUROPA_PACKAGE -> Europa-Package
	 * 	'V55PAK' or ShipmentDetails::PRODUCT_TYPE_PACKED_CONNECT -> Packed Connect
	 * 	'V06PAK' or ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE -> Same-Day Package
	 * 	'V06TG' or ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER -> Same Day Messenger
	 * 	'V06WZ' or ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER -> Wish Time Messenger
	 * 	'V86PARCEL' or ShipmentDetails::PRODUCT_TYPE_AUSTRIA_PACKAGE -> Austria Package
	 * 	'V82PARCEL' or ShipmentDetails::PRODUCT_TYPE_AUSTRIA_INTERNATIONAL_PACKAGE -> Austria International Package
	 * 	'V87PARCEL' or ShipmentDetails::PRODUCT_TYPE_CONNECT_PACKAGE -> Connect Package
	 *
	 * @return string - Used Product
	 */
	public function getProduct() {
		return $this->product;
	}

	/**
	 * Set which Product is used
	 *
	 * Allowed values: (Use PRODUCT_TYPE_* constants - See above)
	 * 	'V01PAK' or ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE -> National-Package
	 * 	'V01PRIO' or ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE_PRIO -> National-Package-Prio
	 * 	'V53WPAK' or ShipmentDetails::PRODUCT_TYPE_INTERNATIONAL_PACKAGE -> International-Package
	 * 	'V54EPAK' or ShipmentDetails::PRODUCT_TYPE_EUROPA_PACKAGE -> Europa-Package
	 * 	'V55PAK' or ShipmentDetails::PRODUCT_TYPE_PACKED_CONNECT -> Packed Connect
	 * 	'V06PAK' or ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE -> Same-Day Package
	 * 	'V06TG' or ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER -> Same Day Messenger
	 * 	'V06WZ' or ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER -> Wish Time Messenger
	 * 	'V86PARCEL' or ShipmentDetails::PRODUCT_TYPE_AUSTRIA_PACKAGE -> Austria Package
	 * 	'V82PARCEL' or ShipmentDetails::PRODUCT_TYPE_AUSTRIA_INTERNATIONAL_PACKAGE -> Austria International Package
	 * 	'V87PARCEL' or ShipmentDetails::PRODUCT_TYPE_CONNECT_PACKAGE -> Connect Package
	 *
	 * @param string $product - Product, which should be used
	 */
	public function setProduct($product) {
		$this->product = $product;
	}

	/**
	 * Get the
	 * EKP Account Number         (10 Digits) Example 123457890
	 * concat Product Type Number (2 Digits)  Example 01 for V01PAK or 53 for V53WPAK or 07 for Retoure Online
	 * concat Process Type Number (2 Digits)  Example 01 for default or 02 for block pricing/flat fee
	 *                                         = 1234578900101
	 *
	 * @return string - Account-Number plus Product Type Number plus Process Type Number
	 */
	private function getAccountNumber() {
		return $this->accountNumber;
	}

	/**
	 * Set the
	 * EKP Account Number         (10 Digits) Example 123457890
	 * concat Product Type Number (2 Digits)  Example 01 for V01PAK or 53 for V53WPAK or 07 for Retoure Online
	 * concat Process Type Number (2 Digits)  Example 01 for default or 02 for block pricing/flat fee
	 *                                         = 1234578900101
	 *
	 * @param string $accountNumber - Account-Number plus Product Type Number plus Process Type Number
	 */
	private function setAccountNumber($accountNumber) {
		$this->accountNumber = $accountNumber;
	}

	/**
	 * Get the Customer-Reference
	 *
	 * @return null|string - Customer Reference or null for none
	 */
	public function getCustomerReference() {
		return $this->customerReference;
	}

	/**
	 * Set the Customer-Reference
	 *
	 * @param null|string $customerReference - Customer Reference or null for none
	 */
	public function setCustomerReference($customerReference) {
		$this->customerReference = $customerReference;
	}

	/**
	 * Get the Shipment-Date (and set the default one -today- if none was set)
	 *
	 * @return string - Shipment-Date as ISO-Date String YYYY-MM-DD
	 */
	public function getShipmentDate() {
		if($this->shipmentDate === null)
			$this->setShipmentDate($this->createDefaultShipmentDate());

		return $this->shipmentDate;
	}

	/**
	 * Set the Shipment-Date
	 *
	 * @param string|int|null $shipmentDate - Shipment-Date as String YYYY-MM-DD or the int value time() of the date | null for today (+1 Day on Sunday)
	 * @param bool $useIntTime - Use the int Time Value instead of a String
	 */
	public function setShipmentDate($shipmentDate, $useIntTime = false) {
		if($useIntTime) {
			// Convert Time-Stamp to Date
			$shipmentDate = date('Y-m-d', $shipmentDate);

			if($shipmentDate === false)
				$shipmentDate = null;
		}

		$this->shipmentDate = $shipmentDate;
	}

	/**
	 * Get the Return-Account-Number (EKP)
	 *
	 * @return null|string - Return-Account-Number or null for none
	 */
	public function getReturnAccountNumber() {
		return $this->returnAccountNumber;
	}

	/**
	 * Set the Return-Account-Number (EKP)
	 *
	 * @param null|string $returnAccountNumber - Return-Account-Number or null for none
	 */
	public function setReturnAccountNumber($returnAccountNumber) {
		$this->returnAccountNumber = $returnAccountNumber;
	}

	/**
	 * Get the Return-Reference
	 *
	 * @return null|string - Return-Reference or null for none
	 */
	public function getReturnReference() {
		return $this->returnReference;
	}

	/**
	 * Set the Return-Reference
	 *
	 * @param null|string $returnReference - Return-Reference or null for none
	 */
	public function setReturnReference($returnReference) {
		$this->returnReference = $returnReference;
	}

	/**
	 * Get the Weight
	 *
	 * @return float - Weight in KG
	 */
	public function getWeight() {
		return $this->weight;
	}

	/**
	 * Set the Weight
	 *
	 * @param float $weight - Weight in KG
	 */
	public function setWeight($weight) {
		$this->weight = $weight;
	}

	/**
	 * Get the Length
	 *
	 * @return int|null - Length in CM or null for none
	 */
	public function getLength() {
		return $this->length;
	}

	/**
	 * Set the Length
	 *
	 * @param int|null $length - Length in CM or null for none
	 */
	public function setLength($length) {
		$this->length = $length;
	}

	/**
	 * Get the Width
	 *
	 * @return int|null - Width in CM or null for none
	 */
	public function getWidth() {
		return $this->width;
	}

	/**
	 * Set the Width
	 *
	 * @param int|null $width - Width in CM or null for none
	 */
	public function setWidth($width) {
		$this->width = $width;
	}

	/**
	 * Get the Height
	 *
	 * @return int|null - Height in CM or null for none
	 */
	public function getHeight() {
		return $this->height;
	}

	/**
	 * Set the Height
	 *
	 * @param int|null $height - Height in CM or null for none
	 */
	public function setHeight($height) {
		$this->height = $height;
	}

	/**
	 * Get the Service-Object
	 *
	 * @return Service|null - Service-Object or null if none
	 */
	public function getService() {
		return $this->service;
	}

	/**
	 * Set the Service-Object
	 *
	 * @param Service|null $service - Service-Object or null for none
	 */
	public function setService($service) {
		$this->service = $service;
	}

	/**
	 * Get the Type of the Package
	 *
	 * Return values:
	 * 	'PK' or ShipmentDetails::PACKAGE -> DHL-Package-Type "Package"
	 * 	'PL' or ShipmentDetails::PALETTE -> DHL-Package-Type "Palette"
	 *
	 * @return string - Type of the Package
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	public function getPackageType() {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);

		return $this->packageType;
	}

	/**
	 * Set the Type of the Package
	 *
	 * Allowed values:
	 * 	'PK' or ShipmentDetails::PACKAGE -> DHL-Package-Type "Package"
	 * 	'PL' or ShipmentDetails::PALETTE -> DHL-Package-Type "Palette"
	 *
	 * @param string $packageType - Type of the Package
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	public function setPackageType($packageType) {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);

		$this->packageType = $packageType;
	}

	/**
	 * Get the Notification E-Mail
	 *
	 * @return string|null - Notification E-Mail or null for none
	 */
	public function getNotificationEmail() {
		return $this->notificationEmail;
	}

	/**
	 * Set the Notification E-Mail
	 *
	 * @param string|null $notificationEmail - Notification E-Mail or null for none
	 */
	public function setNotificationEmail($notificationEmail) {
		$this->notificationEmail = $notificationEmail;
	}

	/**
	 * Get the Bank-Object
	 *
	 * @return BankData|null - Bank-Object or null if none
	 */
	public function getBank() {
		return $this->bank;
	}

	/**
	 * Set the Bank-Object
	 *
	 * @param BankData|null $bank - Bank-Object or null for none
	 */
	public function setBank($bank) {
		$this->bank = $bank;
	}

	/**
	 * Creates a Default Shipment-Date (Today or if Sunday the next Day)
	 *
	 * @return string - Default-Date as ISO-Date String
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
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	public function getShipmentDetailsClass_v1() {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		return new StdClass;
	}

	/**
	 * Returns an DHL-Class of this Object for DHL-Shipment Details
	 *
	 * @return StdClass - DHL-ShipmentDetails-Class
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

		if($this->getService() !== null)
			$class->Service = $this->getService()->getServiceClass_v2($this->getProduct());

		if($this->getNotificationEmail() !== null) {
			$class->Notification = new StdClass;
			$class->Notification->recipientEmailAddress = $this->getNotificationEmail();
		}

		if($this->getBank() !== null)
			$class->BankData = $this->getBank()->getBankClass_v2();

		return $class;
	}
}
