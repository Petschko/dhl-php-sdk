<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
 * Authors-Website: http://petschko.org/
 * Date: 26.01.2017
 * Time: 18:18
 * Update: -
 * Version: 0.0.1
 *
 * Notes: Contains the DHL_Service Class
 */

/**
 * Class DHL_Service
 */
class DHL_Service {
	/**
	 * Note: Optional
	 *
	 * @var bool|null $dayOfDeliveryEnabled
	 */
	private $dayOfDeliveryEnabled = null;

	/**
	 *
	 *
	 * Note: Optional|ISO-Date-Format (YYYY-MM-DD)|Required if $dayOfDeliveryEnabled
	 * Min-Len: 10
	 * Max-Len: 10
	 *
	 * @var string|null $dayOfDeliveryDate
	 */
	private $dayOfDeliveryDate = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $deliveryTimeframeEnabled
	 */
	private $deliveryTimeframeEnabled = null;

	/**
	 * Note: Optional|Required if $deliveryTimeframeEnabled
	 * Write the Values like this 10:00 - 12:30 => (Correct Value) 10001230
	 * or 9:13 - 10:00 => 09131000
	 * or 16:00 - 19:00 => 16001900
	 * Min-Len: 8
	 * Max-Len: 8
	 *
	 * @var string|null $deliveryTimeframe
	 */
	private $deliveryTimeframe = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $preferredTimeEnabled
	 */
	private $preferredTimeEnabled = null;

	/**
	 * Note: Optional|Required if $preferredTimeEnabled
	 * Write the Values like this 10:00 - 12:30 => (Correct Value) 10001230
	 * or 9:13 - 10:00 => 09131000
	 * or 16:00 - 19:00 => 16001900
	 * Min-Len: 8
	 * Max-Len: 8
	 *
	 * @var string|null $preferredTime
	 */
	private $preferredTime = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $individualSenderRequiredmentsEnabled
	 */
	private $individualSenderRequiredmentsEnabled = null;

	/**
	 * Note: Optional|Required if $individualSenderRequiredmentsEnabled
	 * Min-Len: 1
	 * Max-Len: 250
	 *
	 * @var string|null $individualSenderRequiredmentsText
	 */
	private $individualSenderRequiredmentsText = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $packagingReturn
	 */
	private $packagingReturn = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $returnImmediatlyIfShipmentFailed
	 */
	private $returnImmediatlyIfShipmentFailed = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $noticeNonDeliverability
	 */
	private $noticeNonDeliverability = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $shipmentHandlingEnabled
	 */
	private $shipmentHandlingEnabled = null;

	/**
	 * Note: Optional|Required if $shipmentHandlingEnabled
	 * Min-Len: 1
	 * Max-Len: 1
	 *
	 * There are the following types are allowed:
	 * a: Remove content, return box;
	 * b: Remove content, pick up and dispose cardboard packaging;
	 * c: Handover parcel/box to customer ¿ no disposal of cardboar.d/box;
	 * d: Remove bag from of cooling unit and handover to customer;
	 * e: Remove content, apply return label und seal box, return box
	 *
	 * @var string|null
	 */
	private $shipmentHandlingType = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $endorsementEnabled
	 */
	private $endorsementEnabled = null;

	/**
	 * Note: Optional|Required if $endorsementEnabled
	 *
	 * for national:
	 *  SOZU (Return immediately),
	 *  ZWZU (2nd attempt of Delivery);
	 * for International:
	 *  IMMEDIATE (Sending back immediately to sender),
	 *  AFTER_DEADLINE (Sending back immediately to sender after expiration of time),
	 *  ABANDONMENT (Abandonment of parcel at the hands of sender (free of charge))
	 *
	 * @var string|null $endorsementType
	 */
	private $endorsementType = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $visualCheckOfAgeEnabled
	 */
	private $visualCheckOfAgeEnabled = null;

	/**
	 * Note: Optional|Required if $visualCheckOfAgeEnabled
	 * Min-Len: 3
	 * Max-Len: 3
	 *
	 * There are the following types are allowed:
	 * A16
	 * A18
	 *
	 * @var string|null $visualCheckOfAgeType
	 */
	private $visualCheckOfAgeType = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $preferredLocationEnabled
	 */
	private $preferredLocationEnabled = null;

	/**
	 * Note: Optional|Required if $preferredLocationEnabled
	 * Min-Len: 1
	 * Max-Len: 100
	 *
	 * @var string|null $preferredLocationDetails
	 */
	private $preferredLocationDetails = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $preferredNeighbourEnabled
	 */
	private $preferredNeighbourEnabled = null;

	/**
	 * Note: Optional|Required if $preferredNeighbourEnabled
	 * Min-Len: 1
	 * Max-Len: 100
	 *
	 * @var string|null
	 */
	private $preferredNeighbourText = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $preferredDayEnabled
	 */
	private $preferredDayEnabled = null;

	/**
	 * Note: Optional|Required if $preferredDayEnabled
	 * Min-Len: 1
	 * Max-Len: 100
	 *
	 * @var string|null $preferredDayText
	 */
	private $preferredDayText = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $goGreen
	 */
	private $goGreen = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $perishables
	 */
	private $perishables = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $personalHandover
	 */
	private $personalHandover = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $disableNeighbourDelivery
	 */
	private $disableNeighbourDelivery = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $namedPersonOnly
	 */
	private $namedPersonOnly = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $returnReceipt
	 */
	private $returnReceipt = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $premium
	 */
	private $premium = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $cashOnDeliveryEnabled
	 */
	private $cashOnDeliveryEnabled = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $cashOnDeliveryAddFee
	 */
	private $cashOnDeliveryAddFee = null;

	/**
	 * Note: Optional|Required if $cashOnDeliveryEnabled
	 *
	 * @var float|null $cashOnDeliveryAmount
	 */
	private $cashOnDeliveryAmount = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $additionalInsuranceEnabled
	 */
	private $additionalInsuranceEnabled = null;

	/**
	 * Note: Optional|Required if $additionalInsuranceEnabled
	 *
	 * @var float|null $additionalInsuranceAmount
	 */
	private $additionalInsuranceAmount = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $bulkyGoods
	 */
	private $bulkyGoods = null;

	/**
	 * Note: Optional
	 *
	 * @var bool|null $identCheckEnabled
	 */
	private $identCheckEnabled = null;

	/**
	 * Note: Optional|Required if $indentCheckEnabled
	 *
	 * @var DHL_IdentCheck|null $identCheckObj
	 */
	private $identCheckObj = null;

	/**
	 * DHL_Service constructor.
	 */
	public function __construct() {
		// VOID
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		unset($this->dayOfDeliveryEnabled);
		unset($this->dayOfDeliveryDate);
		unset($this->deliveryTimeframeEnabled);
		unset($this->deliveryTimeframe);
		unset($this->preferredTimeEnabled);
		unset($this->preferredTime);
		unset($this->individualSenderRequiredmentsEnabled);
		unset($this->individualSenderRequiredmentsText);
		unset($this->packagingReturn);
		unset($this->returnImmediatlyIfShipmentFailed);
		unset($this->noticeNonDeliverability);
		unset($this->shipmentHandlingEnabled);
		unset($this->shipmentHandlingType);
		unset($this->endorsementEnabled);
		unset($this->endorsementType);
		unset($this->visualCheckOfAgeEnabled);
		unset($this->visualCheckOfAgeType);
		unset($this->preferredLocationEnabled);
		unset($this->preferredLocationDetails);
		unset($this->preferredNeighbourEnabled);
		unset($this->preferredNeighbourText);
		unset($this->preferredDayEnabled);
		unset($this->preferredDayText);
		unset($this->goGreen);
		unset($this->perishables);
		unset($this->personalHandover);
		unset($this->disableNeighbourDelivery);
		unset($this->namedPersonOnly);
		unset($this->returnReceipt);
		unset($this->premium);
		unset($this->cashOnDeliveryEnabled);
		unset($this->cashOnDeliveryAddFee);
		unset($this->cashOnDeliveryAmount);
		unset($this->additionalInsuranceEnabled);
		unset($this->additionalInsuranceAmount);
		unset($this->bulkyGoods);
		unset($this->identCheckEnabled);
		unset($this->identCheckObj);
	}

	/**
	 * @return bool|null
	 */
	public function getDayOfDeliveryEnabled() {
		return $this->dayOfDeliveryEnabled;
	}

	/**
	 * @param bool|null $dayOfDeliveryEnabled
	 */
	public function setDayOfDeliveryEnabled($dayOfDeliveryEnabled) {
		$this->dayOfDeliveryEnabled = $dayOfDeliveryEnabled;
	}

	/**
	 * @return null|string
	 */
	public function getDayOfDeliveryDate() {
		return $this->dayOfDeliveryDate;
	}

	/**
	 * @param null|string $dayOfDeliveryDate
	 */
	public function setDayOfDeliveryDate($dayOfDeliveryDate) {
		$this->dayOfDeliveryDate = $dayOfDeliveryDate;
	}

	/**
	 * @return bool|null
	 */
	public function getDeliveryTimeframeEnabled() {
		return $this->deliveryTimeframeEnabled;
	}

	/**
	 * @param bool|null $deliveryTimeframeEnabled
	 */
	public function setDeliveryTimeframeEnabled($deliveryTimeframeEnabled) {
		$this->deliveryTimeframeEnabled = $deliveryTimeframeEnabled;
	}

	/**
	 * @return null|string
	 */
	public function getDeliveryTimeframe() {
		return $this->deliveryTimeframe;
	}

	/**
	 * @param null|string $deliveryTimeframe
	 */
	public function setDeliveryTimeframe($deliveryTimeframe) {
		$this->deliveryTimeframe = $deliveryTimeframe;
	}

	/**
	 * @return bool|null
	 */
	public function getPreferredTimeEnabled() {
		return $this->preferredTimeEnabled;
	}

	/**
	 * @param bool|null $preferredTimeEnabled
	 */
	public function setPreferredTimeEnabled($preferredTimeEnabled) {
		$this->preferredTimeEnabled = $preferredTimeEnabled;
	}

	/**
	 * @return null|string
	 */
	public function getPreferredTime() {
		return $this->preferredTime;
	}

	/**
	 * @param null|string $preferredTime
	 */
	public function setPreferredTime($preferredTime) {
		$this->preferredTime = $preferredTime;
	}

	/**
	 * @return bool|null
	 */
	public function getIndividualSenderRequiredmentsEnabled() {
		return $this->individualSenderRequiredmentsEnabled;
	}

	/**
	 * @param bool|null $individualSenderRequiredmentsEnabled
	 */
	public function setIndividualSenderRequiredmentsEnabled($individualSenderRequiredmentsEnabled) {
		$this->individualSenderRequiredmentsEnabled = $individualSenderRequiredmentsEnabled;
	}

	/**
	 * @return null|string
	 */
	public function getIndividualSenderRequiredmentsText() {
		return $this->individualSenderRequiredmentsText;
	}

	/**
	 * @param null|string $individualSenderRequiredmentsText
	 */
	public function setIndividualSenderRequiredmentsText($individualSenderRequiredmentsText) {
		$this->individualSenderRequiredmentsText = $individualSenderRequiredmentsText;
	}

	/**
	 * @return bool|null
	 */
	public function getPackagingReturn() {
		return $this->packagingReturn;
	}

	/**
	 * @param bool|null $packagingReturn
	 */
	public function setPackagingReturn($packagingReturn) {
		$this->packagingReturn = $packagingReturn;
	}

	/**
	 * @return bool|null
	 */
	public function getReturnImmediatlyIfShipmentFailed() {
		return $this->returnImmediatlyIfShipmentFailed;
	}

	/**
	 * @param bool|null $returnImmediatlyIfShipmentFailed
	 */
	public function setReturnImmediatlyIfShipmentFailed($returnImmediatlyIfShipmentFailed) {
		$this->returnImmediatlyIfShipmentFailed = $returnImmediatlyIfShipmentFailed;
	}

	/**
	 * @return bool|null
	 */
	public function getNoticeNonDeliverability() {
		return $this->noticeNonDeliverability;
	}

	/**
	 * @param bool|null $noticeNonDeliverability
	 */
	public function setNoticeNonDeliverability($noticeNonDeliverability) {
		$this->noticeNonDeliverability = $noticeNonDeliverability;
	}

	/**
	 * @return bool|null
	 */
	public function getShipmentHandlingEnabled() {
		return $this->shipmentHandlingEnabled;
	}

	/**
	 * @param bool|null $shipmentHandlingEnabled
	 */
	public function setShipmentHandlingEnabled($shipmentHandlingEnabled) {
		$this->shipmentHandlingEnabled = $shipmentHandlingEnabled;
	}

	/**
	 * @return null|string
	 */
	public function getShipmentHandlingType() {
		return $this->shipmentHandlingType;
	}

	/**
	 * @param null|string $shipmentHandlingType
	 */
	public function setShipmentHandlingType($shipmentHandlingType) {
		$this->shipmentHandlingType = $shipmentHandlingType;
	}

	/**
	 * @return bool|null
	 */
	public function getEndorsementEnabled() {
		return $this->endorsementEnabled;
	}

	/**
	 * @param bool|null $endorsementEnabled
	 */
	public function setEndorsementEnabled($endorsementEnabled) {
		$this->endorsementEnabled = $endorsementEnabled;
	}

	/**
	 * @return null|string
	 */
	public function getEndorsementType() {
		return $this->endorsementType;
	}

	/**
	 * @param null|string $endorsementType
	 */
	public function setEndorsementType($endorsementType) {
		$this->endorsementType = $endorsementType;
	}

	/**
	 * @return bool|null
	 */
	public function getVisualCheckOfAgeEnabled() {
		return $this->visualCheckOfAgeEnabled;
	}

	/**
	 * @param bool|null $visualCheckOfAgeEnabled
	 */
	public function setVisualCheckOfAgeEnabled($visualCheckOfAgeEnabled) {
		$this->visualCheckOfAgeEnabled = $visualCheckOfAgeEnabled;
	}

	/**
	 * @return null|string
	 */
	public function getVisualCheckOfAgeType() {
		return $this->visualCheckOfAgeType;
	}

	/**
	 * @param null|string $visualCheckOfAgeType
	 */
	public function setVisualCheckOfAgeType($visualCheckOfAgeType) {
		$this->visualCheckOfAgeType = $visualCheckOfAgeType;
	}

	/**
	 * @return bool|null
	 */
	public function getPreferredLocationEnabled() {
		return $this->preferredLocationEnabled;
	}

	/**
	 * @param bool|null $preferredLocationEnabled
	 */
	public function setPreferredLocationEnabled($preferredLocationEnabled) {
		$this->preferredLocationEnabled = $preferredLocationEnabled;
	}

	/**
	 * @return null|string
	 */
	public function getPreferredLocationDetails() {
		return $this->preferredLocationDetails;
	}

	/**
	 * @param null|string $preferredLocationDetails
	 */
	public function setPreferredLocationDetails($preferredLocationDetails) {
		$this->preferredLocationDetails = $preferredLocationDetails;
	}

	/**
	 * @return bool|null
	 */
	public function getPreferredNeighbourEnabled() {
		return $this->preferredNeighbourEnabled;
	}

	/**
	 * @param bool|null $preferredNeighbourEnabled
	 */
	public function setPreferredNeighbourEnabled($preferredNeighbourEnabled) {
		$this->preferredNeighbourEnabled = $preferredNeighbourEnabled;
	}

	/**
	 * @return null|string
	 */
	public function getPreferredNeighbourText() {
		return $this->preferredNeighbourText;
	}

	/**
	 * @param null|string $preferredNeighbourText
	 */
	public function setPreferredNeighbourText($preferredNeighbourText) {
		$this->preferredNeighbourText = $preferredNeighbourText;
	}

	/**
	 * @return bool|null
	 */
	public function getPreferredDayEnabled() {
		return $this->preferredDayEnabled;
	}

	/**
	 * @param bool|null $preferredDayEnabled
	 */
	public function setPreferredDayEnabled($preferredDayEnabled) {
		$this->preferredDayEnabled = $preferredDayEnabled;
	}

	/**
	 * @return null|string
	 */
	public function getPreferredDayText() {
		return $this->preferredDayText;
	}

	/**
	 * @param null|string $preferredDayText
	 */
	public function setPreferredDayText($preferredDayText) {
		$this->preferredDayText = $preferredDayText;
	}

	/**
	 * @return bool|null
	 */
	public function getGoGreen() {
		return $this->goGreen;
	}

	/**
	 * @param bool|null $goGreen
	 */
	public function setGoGreen($goGreen) {
		$this->goGreen = $goGreen;
	}

	/**
	 * @return bool|null
	 */
	public function getPerishables() {
		return $this->perishables;
	}

	/**
	 * @param bool|null $perishables
	 */
	public function setPerishables($perishables) {
		$this->perishables = $perishables;
	}

	/**
	 * @return bool|null
	 */
	public function getPersonalHandover() {
		return $this->personalHandover;
	}

	/**
	 * @param bool|null $personalHandover
	 */
	public function setPersonalHandover($personalHandover) {
		$this->personalHandover = $personalHandover;
	}

	/**
	 * @return bool|null
	 */
	public function getDisableNeighbourDelivery() {
		return $this->disableNeighbourDelivery;
	}

	/**
	 * @param bool|null $disableNeighbourDelivery
	 */
	public function setDisableNeighbourDelivery($disableNeighbourDelivery) {
		$this->disableNeighbourDelivery = $disableNeighbourDelivery;
	}

	/**
	 * @return bool|null
	 */
	public function getNamedPersonOnly() {
		return $this->namedPersonOnly;
	}

	/**
	 * @param bool|null $namedPersonOnly
	 */
	public function setNamedPersonOnly($namedPersonOnly) {
		$this->namedPersonOnly = $namedPersonOnly;
	}

	/**
	 * @return bool|null
	 */
	public function getReturnReceipt() {
		return $this->returnReceipt;
	}

	/**
	 * @param bool|null $returnReceipt
	 */
	public function setReturnReceipt($returnReceipt) {
		$this->returnReceipt = $returnReceipt;
	}

	/**
	 * @return bool|null
	 */
	public function getPremium() {
		return $this->premium;
	}

	/**
	 * @param bool|null $premium
	 */
	public function setPremium($premium) {
		$this->premium = $premium;
	}

	/**
	 * @return bool|null
	 */
	public function getCashOnDeliveryEnabled() {
		return $this->cashOnDeliveryEnabled;
	}

	/**
	 * @param bool|null $cashOnDeliveryEnabled
	 */
	public function setCashOnDeliveryEnabled($cashOnDeliveryEnabled) {
		$this->cashOnDeliveryEnabled = $cashOnDeliveryEnabled;
	}

	/**
	 * @return bool|null
	 */
	public function getCashOnDeliveryAddFee() {
		return $this->cashOnDeliveryAddFee;
	}

	/**
	 * @param bool|null $cashOnDeliveryAddFee
	 */
	public function setCashOnDeliveryAddFee($cashOnDeliveryAddFee) {
		$this->cashOnDeliveryAddFee = $cashOnDeliveryAddFee;
	}

	/**
	 * @return float|null
	 */
	public function getCashOnDeliveryAmount() {
		return $this->cashOnDeliveryAmount;
	}

	/**
	 * @param float|null $cashOnDeliveryAmount
	 */
	public function setCashOnDeliveryAmount($cashOnDeliveryAmount) {
		$this->cashOnDeliveryAmount = $cashOnDeliveryAmount;
	}

	/**
	 * @return bool|null
	 */
	public function getAdditionalInsuranceEnabled() {
		return $this->additionalInsuranceEnabled;
	}

	/**
	 * @param bool|null $additionalInsuranceEnabled
	 */
	public function setAdditionalInsuranceEnabled($additionalInsuranceEnabled) {
		$this->additionalInsuranceEnabled = $additionalInsuranceEnabled;
	}

	/**
	 * @return float|null
	 */
	public function getAdditionalInsuranceAmount() {
		return $this->additionalInsuranceAmount;
	}

	/**
	 * @param float|null $additionalInsuranceAmount
	 */
	public function setAdditionalInsuranceAmount($additionalInsuranceAmount) {
		$this->additionalInsuranceAmount = $additionalInsuranceAmount;
	}

	/**
	 * @return bool|null
	 */
	public function getBulkyGoods() {
		return $this->bulkyGoods;
	}

	/**
	 * @param bool|null $bulkyGoods
	 */
	public function setBulkyGoods($bulkyGoods) {
		$this->bulkyGoods = $bulkyGoods;
	}

	/**
	 * @return bool|null
	 */
	public function getIdentCheckEnabled() {
		return $this->identCheckEnabled;
	}

	/**
	 * @param bool|null $identCheckEnabled
	 */
	public function setIdentCheckEnabled($identCheckEnabled) {
		$this->identCheckEnabled = $identCheckEnabled;
	}

	/**
	 * @return DHL_IdentCheck|null
	 */
	public function getIdentCheckObj() {
		return $this->identCheckObj;
	}

	/**
	 * @param DHL_IdentCheck|null $identCheckObj
	 */
	public function setIdentCheckObj($identCheckObj) {
		$this->identCheckObj = $identCheckObj;
	}

	/**
	 * Get the Class of this Service-Object
	 *
	 * @param string $productType - Type of the Product
	 * @return StdClass - Service-DHL-Class
	 */
	public function getServiceClass_v2($productType) {
		$class = new StdClass;

		if($this->getDayOfDeliveryEnabled() !== null && in_array(
			$productType,
			array(
				DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER,
				DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
			))) {
			$class->DayOfDelivery = new StdClass;
			$class->DayOfDelivery->active = (int) $this->getDayOfDeliveryEnabled();
			$class->DayOfDelivery->details = $this->getDayOfDeliveryDate();
		}
		if($this->getDeliveryTimeframeEnabled() !== null && in_array(
				$productType,
				array(
					DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER,
					DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
				))) {
			$class->DeliveryTimeframe = new StdClass;
			$class->DeliveryTimeframe->active = (int) $this->getDeliveryTimeframeEnabled();
			$class->DeliveryTimeframe->type = $this->getDeliveryTimeframe();
		}
		if($this->getPreferredTimeEnabled() !== null && in_array(
				$productType,
				array(
					DHL_ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE,
					DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE
				))) {
			$class->PreferredTime = new StdClass;
			$class->PreferredTime->active = (int) $this->getPreferredTimeEnabled();
			$class->PreferredTime->type = $this->getPreferredTime();
		}
		if($this->getIndividualSenderRequiredmentsEnabled() !== null && in_array(
				$productType,
				array(
					DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER,
					DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
				))) {
			$class->IndividualSenderRequirement = new StdClass;
			$class->IndividualSenderRequirement->active = (int) $this->getIndividualSenderRequiredmentsEnabled();
			$class->IndividualSenderRequirement->details = $this->getIndividualSenderRequiredmentsText();
		}
		if($this->getPackagingReturn() !== null) {
			$class->PackagingReturn = new StdClass;
			$class->PackagingReturn->active = (int) $this->getPackagingReturn();
		}
		if($this->getReturnImmediatlyIfShipmentFailed() !== null && in_array(
				$productType,
				array(
					DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE
				))) {
			$class->ReturnImmediately = new StdClass;
			$class->ReturnImmediately->active = (int) $this->getReturnImmediatlyIfShipmentFailed();
		}
		if($this->getNoticeNonDeliverability() !== null) {
			$class->NoticeOfNonDeliverability = new StdClass;
			$class->NoticeOfNonDeliverability->active = (int) $this->getNoticeNonDeliverability();
		}
		if($this->getShipmentHandlingEnabled() !== null && in_array(
				$productType,
				array(
					DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER,
					DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
				))) {
			$class->ShipmentHandling = new StdClass;
			$class->ShipmentHandling->active = (int) $this->getShipmentHandlingEnabled();
			$class->ShipmentHandling->type = $this->getShipmentHandlingType();
		}
		if($this->getEndorsementEnabled() !== null) {
			$class->Endorsement = new StdClass;
			$class->Endorsement->active = (int) $this->getEndorsementEnabled();
			$class->Endorsement->type = $this->getEndorsementType();
		}
		if($this->getVisualCheckOfAgeEnabled() !== null) {
			$class->VisualCheckOfAge = new StdClass;
			$class->VisualCheckOfAge->active = (int) $this->getVisualCheckOfAgeEnabled();
			$class->VisualCheckOfAge->type = $this->getVisualCheckOfAgeType();
		}
		if($this->getPreferredLocationEnabled() !== null) {
			$class->PreferredLocation = new StdClass;
			$class->PreferredLocation->active = (int) $this->getPreferredLocationEnabled();
			$class->PreferredLocation->details = $this->getPreferredLocationDetails();
		}
		if($this->getPreferredNeighbourEnabled() !== null) {
			$class->PreferredNeighbour = new StdClass;
			$class->PreferredNeighbour->active = (int) $this->getPreferredNeighbourEnabled();
			$class->PreferredNeighbour->details = $this->getPreferredNeighbourText();
		}
		if($this->getPreferredDayEnabled() !== null) {
			$class->PreferredDay = new StdClass;
			$class->PreferredDay->active = (int) $this->getPreferredDayEnabled();
			$class->PreferredDay->details = $this->getPreferredDayText();
		}
		if($this->getGoGreen() !== null) {
			$class->GoGreen = new StdClass;
			$class->GoGreen->active = (int) $this->getGoGreen();
		}
		if($this->getPerishables() !== null) {
			$class->Perishables = new StdClass;
			$class->Perishables->active = (int) $this->getPerishables();
		}
		if($this->getPersonalHandover() !== null) {
			$class->Personally = new StdClass;
			$class->Personally->active = (int) $this->getPersonalHandover();
		}
		if($this->getDisableNeighbourDelivery() !== null) {
			$class->NoNeighbourDelivery = new StdClass;
			$class->NoNeighbourDelivery->active = (int) $this->getDisableNeighbourDelivery();
		}
		if($this->getNamedPersonOnly() !== null) {
			$class->NamedPersonOnly = new StdClass;
			$class->NamedPersonOnly->active = (int) $this->getNamedPersonOnly();
		}
		if($this->getReturnReceipt() !== null) {
			$class->ReturnReceipt = new StdClass;
			$class->ReturnReceipt->active = (int) $this->getReturnReceipt();
		}
		if($this->getPremium() !== null) {
			$class->Premium = new StdClass;
			$class->Premium->active = (int) $this->getPremium();
		}
		if($this->getCashOnDeliveryEnabled() !== null) {
			$class->CashOnDelivery = new StdClass;
			$class->CashOnDelivery->active = (int) $this->getCashOnDeliveryEnabled();
			if($this->getCashOnDeliveryAddFee() !== null)
				$class->CashOnDelivery->addFee = $this->getCashOnDeliveryAddFee();
			$class->CashOnDelivery->codAmount = $this->getCashOnDeliveryAmount();
		}
		if($this->getAdditionalInsuranceEnabled() !== null) {
			$class->AdditionalInsurance = new StdClass;
			$class->AdditionalInsurance->active = (int) $this->getAdditionalInsuranceEnabled();
			$class->AdditionalInsurance->insuranceAmount = $this->getAdditionalInsuranceAmount();
		}
		if($this->getBulkyGoods() !== null) {
			$class->BulkyGoods = new StdClass;
			$class->BulkyGoods->active = (int) $this->getBulkyGoods();
		}
		if($this->getIdentCheckEnabled() !== null) {
			$class->IdentCheck = new StdClass;
			$class->IdentCheck->active = (int) $this->getIdentCheckEnabled();
			$class->IdentCheck->Ident = $this->getIdentCheckObj()->getIdentClass_v2();
		}

		return $class;
	}
}
