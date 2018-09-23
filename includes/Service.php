<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 26.01.2017
 * Time: 18:18
 * Update: 05.08.2018
 * Version: 0.1.2
 *
 * Notes: Contains the Service Class
 */

use stdClass;

/**
 * Class Service
 *
 * @package Petschko\DHL
 */
class Service {
	/**
	 * Contains if the Shipment should delivered on a specific Day
	 *
	 * Note: Optional
	 *
	 * Available for:
	 * 	ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
	 *
	 * @var bool|null $dayOfDeliveryEnabled - Is this enabled | null uses default
	 */
	private $dayOfDeliveryEnabled = null;

	/**
	 * Contains the Day, when the Shipment should be delivered
	 *
	 * Note: Optional|ISO-Date-Format (YYYY-MM-DD)|Required if $dayOfDeliveryEnabled
	 *
	 * Available for:
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
	 *
	 * Min-Len: 10
	 * Max-Len: 10
	 *
	 * @var string|null $dayOfDeliveryDate - Delivery-Date | null for none
	 */
	private $dayOfDeliveryDate = null;

	/**
	 * Contains if the Shipment should be delivered on a specific Time-Frame
	 *
	 * Note: Optional
	 *
	 * Available for:
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
	 *
	 * @var bool|null $deliveryTimeframeEnabled - Is this enabled | null uses default
	 */
	private $deliveryTimeframeEnabled = null;

	/**
	 * Contains the Time-Frame when the Shipment should be delivered
	 *
	 * Note: Optional|Required if $deliveryTimeframeEnabled
	 *
	 * Write the Values like this:
	 * 	10:00 - 12:30 => (Correct Value) '10001230'
	 * 	9:13 - 10:00 => '09131000'
	 * 	16:00 - 19:00 => '16001900'
	 *
	 * Available for:
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
	 *
	 * Min-Len: 8
	 * Max-Len: 8
	 *
	 * @var string|null $deliveryTimeframe - Time-Frame for delivery | null for none
	 */
	private $deliveryTimeframe = null;

	/**
	 * Contains if preferred delivery Time is enabled
	 *
	 * Note: Optional
	 *
	 * Available for:
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE
	 *
	 * @var bool|null $preferredTimeEnabled - Is this enabled | null uses default
	 */
	private $preferredTimeEnabled = null;

	/**
	 * Contains the preferred delivery Time-Frame
	 *
	 * Note: Optional|Required if $preferredTimeEnabled
	 *
	 * Write the Values like this:
	 * 	10:00 - 12:30 => (Correct Value) '10001230'
	 * 	9:13 - 10:00 => '09131000'
	 * 	16:00 - 19:00 => '16001900'
	 *
	 * Available for:
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE
	 *
	 * Min-Len: 8
	 * Max-Len: 8
	 *
	 * @var string|null $preferredTime - Preferred delivery Time-Frame | null for none
	 */
	private $preferredTime = null;

	/**
	 * Contains if an individual sender requirement is enabled (and required)
	 *
	 * Note: Optional
	 *
	 * Available for:
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
	 *
	 * @var bool|null $individualSenderRequirementsEnabled - Is this enabled | null uses default
	 */
	private $individualSenderRequirementsEnabled = null;

	/**
	 * Contains the Requirement (Free text)
	 *
	 * Note: Optional|Required if $individualSenderRequirementsEnabled
	 *
	 * Available for:
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
	 *
	 * Min-Len: 1
	 * Max-Len: 250
	 *
	 * @var string|null $individualSenderRequirementsText - Sender Requirement (Free text) | null for none
	 */
	private $individualSenderRequirementsText = null;

	/**
	 * Contains if Packaging return is enabled
	 *
	 * Note: Optional
	 *
	 * @var bool|null $packagingReturn - Is this enabled | null uses default
	 */
	private $packagingReturn = null;

	/**
	 * Contains if return immediately if the Shipment failed
	 *
	 * Note: Optional
	 *
	 * Available for:
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE
	 *
	 * @var bool|null $returnImmediatelyIfShipmentFailed - Is this enabled | null uses default
	 */
	private $returnImmediatelyIfShipmentFailed = null;

	/**
	 * Contains if Notice on Non-Deliverable is enabled
	 *
	 * Note: Optional
	 *
	 * @var bool|null $noticeOnNonDeliverable - Is this enabled | null uses default
	 */
	private $noticeOnNonDeliverable = null;

	/**
	 * Contains if Shipment-Handling is enabled
	 *
	 * Note: Optional
	 *
	 * Available for:
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
	 *
	 * @var bool|null $shipmentHandlingEnabled - Is this enabled | null uses default
	 */
	private $shipmentHandlingEnabled = null;

	/**
	 * Contains the Shipment-Handling Type
	 *
	 * Note: Optional|Required if $shipmentHandlingEnabled
	 *
	 * Available for:
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
	 * 	DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
	 *
	 * Min-Len: 1
	 * Max-Len: 1
	 *
	 * The following types are allowed:
	 * 	'a': Remove content, return box;
	 * 	'b': Remove content, pick up and dispose cardboard packaging;
	 * 	'c': Handover parcel/box to customer ¿ no disposal of cardboar.d/box;
	 * 	'd': Remove bag from of cooling unit and handover to customer;
	 * 	'e': Remove content, apply return label und seal box, return box
	 * 	null: None
	 *
	 * @var string|null $shipmentHandlingType - Shipment-Handling Type | null for none
	 */
	private $shipmentHandlingType = null;

	/**
	 * Contains if the Service "Endorsement" is enabled
	 *
	 * Note: Optional
	 *
	 * @var bool|null $endorsementEnabled - Is this enabled | null uses default
	 */
	private $endorsementEnabled = null;

	/**
	 * Contains the Type for the "Endorsement"-Service
	 *
	 * Note: Optional|Required if $endorsementEnabled
	 *
	 * Values for national:
	 * 	'SOZU': (Return immediately),
	 * 	'ZWZU': (2nd attempt of Delivery);
	 * -----------------------------
	 * Values for International:
	 * 	'IMMEDIATE': (Sending back immediately to sender),
	 * 	'AFTER_DEADLINE': (Sending back immediately to sender after expiration of time),
	 * 	'ABANDONMENT': (Abandonment of parcel at the hands of sender (free of charge))
	 *
	 * @var string|null $endorsementType - Endorsement-Service Type | null for none
	 */
	private $endorsementType = null;

	/**
	 * Contains if Age-Check is enabled
	 *
	 * Note: Optional
	 *
	 * @var bool|null $visualCheckOfAgeEnabled - Is this enabled | null uses default
	 */
	private $visualCheckOfAgeEnabled = null;

	/**
	 * Contains the Age that the Receiver should be at least have
	 *
	 * Note: Optional|Required if $visualCheckOfAgeEnabled
	 *
	 * Min-Len: 3
	 * Max-Len: 3
	 *
	 * The following Values are allowed:
	 * 	'A16': Person must be 16+
	 * 	'A18': Person must be 18+
	 *
	 * @var string|null $visualCheckOfAgeType - Minimum-Age of the Receiver | null for none
	 */
	private $visualCheckOfAgeType = null;

	/**
	 * Contains if preferred Location is enabled
	 *
	 * Note: Optional
	 *
	 * @var bool|null $preferredLocationEnabled - Is this enabled | null uses default
	 */
	private $preferredLocationEnabled = null;

	/**
	 * Contains details of the preferred Location (Free text)
	 *
	 * Note: Optional|Required if $preferredLocationEnabled
	 *
	 * Min-Len: 1
	 * Max-Len: 100
	 *
	 * @var string|null $preferredLocationDetails - Details of the preferred Location (Free text) | null for none
	 */
	private $preferredLocationDetails = null;

	/**
	 * Contains if preferred Neighbour is enabled
	 *
	 * Note: Optional
	 *
	 * @var bool|null $preferredNeighbourEnabled - Is this enabled | null uses default
	 */
	private $preferredNeighbourEnabled = null;

	/**
	 * Contains the details of the preferred Neighbour (Free text)
	 *
	 * Note: Optional|Required if $preferredNeighbourEnabled
	 *
	 * Min-Len: 1
	 * Max-Len: 100
	 *
	 * @var string|null $preferredNeighbourText - Details of the preferred Neighbour (Free text) | null for none
	 */
	private $preferredNeighbourText = null;

	/**
	 * Contains if preferred Day is enabled
	 *
	 * Note: Optional
	 *
	 * @var bool|null $preferredDayEnabled - Is this enabled | null uses default
	 */
	private $preferredDayEnabled = null;

	/**
	 * Contains the details of the preferred Day (Free text)
	 *
	 * Note: Optional|Required if $preferredDayEnabled
	 *
	 * Min-Len: 1
	 * Max-Len: 100
	 *
	 * @var string|null $preferredDayText - Details of the preferred Day (Free text) | null for none
	 */
	private $preferredDayText = null;

	/**
	 * Contains if GoGreen is enabled
	 *
	 * Note: Optional|Version 1 ONLY
	 *
	 * @var bool|null $goGreen - Is this enabled | null uses default
	 *
	 * @deprecated - DHL-API-Version 1 Field
	 */
	private $goGreen = null;

	/**
	 * Contains if deliver Perishables
	 *
	 * Note: Optional
	 *
	 * @var bool|null $perishables - Is this enabled | null uses default
	 */
	private $perishables = null;

	/**
	 * Contains if personal handover is enabled
	 *
	 * Note: Optional
	 *
	 * @var bool|null $personalHandover - Is this enabled | null uses default
	 *
	 * @deprecated - DHL-API-Version 1 Field
	 */
	private $personalHandover = null;

	/**
	 * Contains if Neighbour delivery is disabled
	 *
	 * Note: Optional
	 *
	 * @var bool|null $disableNeighbourDelivery - Is this enabled | null uses default
	 */
	private $disableNeighbourDelivery = null;

	/**
	 * Contains if named Person can only accept delivery
	 *
	 * Note: Optional
	 *
	 * @var bool|null $namedPersonOnly - Is this enabled | null uses default
	 */
	private $namedPersonOnly = null;

	/**
	 * Contains if return receipt is enabled
	 *
	 * Note: Optional
	 *
	 * @var bool|null $returnReceipt - Is this enabled | null uses default
	 */
	private $returnReceipt = null;

	/**
	 * Contains if Premium is enabled (for fast and safe delivery of international shipments)
	 *
	 * Note: Optional
	 *
	 * @var bool|null $premium - Is this enabled | null uses default
	 */
	private $premium = null;

	/**
	 * Contains if Cash on delivery (COD) is enabled
	 *
	 * Note: Optional
	 *
	 * @var bool|null $cashOnDeliveryEnabled - Is this enabled | null uses default
	 */
	private $cashOnDeliveryEnabled = null;

	/**
	 * Contains if the Service "AddFee" is enabled
	 *
	 * Explanation from DHL: (COD = CashOnDelivery)
	 * Configuration whether the transmission fee to be added to the COD amount or not by DHL.
	 * Select the option then the new COD amount will automatically printed on the shipping label and will transferred
	 * to the end of the day to DHL. Do not select the option and the specified COD amount remains unchanged.
	 *
	 * Note: Optional
	 *
	 * @var bool|null $cashOnDeliveryAddFee - Is this enabled | null uses default
	 */
	private $cashOnDeliveryAddFee = null;

	/**
	 * Contains the Amount how much the receiver must pay
	 *
	 * Explanation from DHL: (COD = CashOnDelivery)
	 * Money amount to be collected. Mandatory if COD is chosen.
	 * Attention: Please add the additional 2 EURO transmittal fee when entering the COD Amount
	 *
	 * Note: Optional|Required if $cashOnDeliveryEnabled
	 *
	 * @var float|null $cashOnDeliveryAmount - CashOnDelivery Amount | null for none
	 */
	private $cashOnDeliveryAmount = null;

	/**
	 * Contains if the Shipment is insured with a higher standard
	 *
	 * Note: Optional
	 *
	 * @var bool|null $additionalInsuranceEnabled - Is this enabled | null uses default
	 */
	private $additionalInsuranceEnabled = null;

	/**
	 * Contains the Amount with that the Shipment is insured
	 *
	 * Note: Optional|Required if $additionalInsuranceEnabled
	 *
	 * @var float|null $additionalInsuranceAmount - Insure-Amount | null for none
	 */
	private $additionalInsuranceAmount = null;

	/**
	 * Contains if you deliver Bulky-Goods
	 *
	 * Note: Optional
	 *
	 * @var bool|null $bulkyGoods - Is this enabled | null uses default
	 */
	private $bulkyGoods = null;

	/**
	 * Contains if the Ident-Check is enabled
	 *
	 * Note: Optional
	 *
	 * @var bool|null $identCheckEnabled - Is this enabled | null uses default
	 */
	private $identCheckEnabled = null;

	/**
	 * Contains the Ident-Check Object
	 *
	 * Note: Optional|Required if $indentCheckEnabled
	 *
	 * @var IdentCheck|null $identCheckObj - Ident-Check Object | null for none
	 */
	private $identCheckObj = null;

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
		unset($this->individualSenderRequirementsEnabled);
		unset($this->individualSenderRequirementsText);
		unset($this->packagingReturn);
		unset($this->returnImmediatelyIfShipmentFailed);
		unset($this->noticeOnNonDeliverable);
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
	 * Get if the Service "DayOfDelivery" is enabled
	 *
	 * @return bool|null - Is the Service "DayOfDelivery" enabled or null for default
	 */
	public function getDayOfDeliveryEnabled() {
		return $this->dayOfDeliveryEnabled;
	}

	/**
	 * Set if the Service "DayOfDelivery" is enabled
	 *
	 * @param bool|null $dayOfDeliveryEnabled - Service "DayOfDelivery" is enabled or null for default
	 */
	public function setDayOfDeliveryEnabled($dayOfDeliveryEnabled) {
		$this->dayOfDeliveryEnabled = $dayOfDeliveryEnabled;
	}

	/**
	 * Get the Date for the Service "DayOfDelivery"
	 *
	 * @return null|string - The day of Delivery as ISO-Date-Format (YYYY-MM-DD) or null for none
	 */
	public function getDayOfDeliveryDate() {
		return $this->dayOfDeliveryDate;
	}

	/**
	 * Set the Date for the Service "DayOfDelivery"
	 *
	 * @param null|int|string $dayOfDeliveryDate - The Day of Delivery as ISO-Date-Format (YYYY-MM-DD), the day as time() int value or null for none
	 * @param bool $useIntTime - Use the int Time Value instead of a String
	 */
	public function setDayOfDeliveryDate($dayOfDeliveryDate, $useIntTime = false) {
		if($useIntTime) {
			$dayOfDeliveryDate = date('Y-m-d', $dayOfDeliveryDate);

			if($dayOfDeliveryDate === false)
				$dayOfDeliveryDate = null;
		}

		$this->dayOfDeliveryDate = $dayOfDeliveryDate;
	}

	/**
	 * Get if the Service "DeliveryTimeframe" is enabled
	 *
	 * @return bool|null - Is the Service "DeliveryTimeframe" enabled or null for default
	 */
	public function getDeliveryTimeframeEnabled() {
		return $this->deliveryTimeframeEnabled;
	}

	/**
	 * Set if the Service "DeliveryTimeframe" is enabled
	 *
	 * @param bool|null $deliveryTimeframeEnabled - Service "DeliveryTimeframe" is enabled or null for default
	 */
	public function setDeliveryTimeframeEnabled($deliveryTimeframeEnabled) {
		$this->deliveryTimeframeEnabled = $deliveryTimeframeEnabled;
	}

	/**
	 * Get the Timeframe for the Service "DeliveryTimeframe"
	 *
	 * You get Values like this:
	 * 	10:00 - 12:30 => '10001230'
	 * 	9:13 - 10:00 => '09131000'
	 * 	16:00 - 19:00 => '16001900'
	 *
	 * @return null|string - Timeframe for the Service "DeliveryTimeframe" or null for none
	 */
	public function getDeliveryTimeframe() {
		return $this->deliveryTimeframe;
	}

	/**
	 * Set the Timeframe for the Service "DeliveryTimeframe"
	 *
	 * Write Values like this:
	 * 	10:00 - 12:30 => (Correct Value) '10001230'
	 * 	9:13 - 10:00 => '09131000'
	 * 	16:00 - 19:00 => '16001900'
	 *
	 * @param null|string $deliveryTimeframe - Timeframe for the Service "DeliveryTimeframe" or null for none
	 */
	public function setDeliveryTimeframe($deliveryTimeframe) {
		$this->deliveryTimeframe = $deliveryTimeframe;
	}

	/**
	 * Get if the Service "PreferredTime" is enabled
	 *
	 * @return bool|null - Service "PreferredTime" is enabled or null for default
	 */
	public function getPreferredTimeEnabled() {
		return $this->preferredTimeEnabled;
	}

	/**
	 * Set if the Service "PreferredTime" is enabled
	 *
	 * @param bool|null $preferredTimeEnabled - Service "PreferredTime" is enabled or null for default
	 */
	public function setPreferredTimeEnabled($preferredTimeEnabled) {
		$this->preferredTimeEnabled = $preferredTimeEnabled;
	}

	/**
	 * Get the Timeframe for the "PreferredTime"-Service
	 *
	 * You get Values like this:
	 * 	10:00 - 12:30 => '10001230'
	 * 	9:13 - 10:00 => '09131000'
	 * 	16:00 - 19:00 => '16001900'
	 *
	 * @return null|string - Preferred Time-Frame or null for none
	 */
	public function getPreferredTime() {
		return $this->preferredTime;
	}

	/**
	 * Set the Timeframe for the "PreferredTime"-Service
	 *
	 * Write Values like this:
	 * 	10:00 - 12:30 => (Correct Value) '10001230'
	 * 	or 9:13 - 10:00 => '09131000'
	 * 	or 16:00 - 19:00 => '16001900'
	 *
	 * @param null|string $preferredTime - Preferred Time-Frame or null for none
	 */
	public function setPreferredTime($preferredTime) {
		$this->preferredTime = $preferredTime;
	}

	/**
	 * Alias for $this->getIndividualSenderRequirementsEnabled()
	 *
	 * @return bool|null - Service "IndividualSenderRequirements" is enabled or null for default
	 *
	 * @deprecated - Invalid name of the function
	 */
	public function getIndividualSenderRequiredmentsEnabled() {
		trigger_error(
			'Called deprecated method ' . __METHOD__ . ': Use getIndividualSenderRequirementsEnabled() instead, this method will removed in the future!',
			E_USER_DEPRECATED
		);

		return $this->getIndividualSenderRequirementsEnabled();
	}

	/**
	 * Alias for $this->setIndividualSenderRequirementsEnabled()
	 *
	 * @param bool|null $individualSenderRequirementsEnabled - Service "IndividualSenderRequirements" is enabled or null for default
	 *
	 * @deprecated - Invalid name of the function
	 */
	public function setIndividualSenderRequiredmentsEnabled($individualSenderRequirementsEnabled) {
		trigger_error(
			'Called deprecated method ' . __METHOD__ . ': Use setIndividualSenderRequirementsEnabled() instead, this method will removed in the future!',
			E_USER_DEPRECATED
		);

		$this->setIndividualSenderRequirementsEnabled($individualSenderRequirementsEnabled);
	}

	/**
	 * Alias for $this->getIndividualSenderRequirementsText()
	 *
	 * @return null|string - Sender Requirement (Free text) or null for none
	 *
	 * @deprecated - Invalid name of the function
	 */
	public function getIndividualSenderRequiredmentsText() {
		trigger_error(
			'Called deprecated method ' . __METHOD__ . ': Use getIndividualSenderRequirementsText() instead, this method will removed in the future!',
			E_USER_DEPRECATED
		);

		return $this->getIndividualSenderRequirementsText();
	}

	/**
	 * Alias for $this->setIndividualSenderRequirementsText()
	 *
	 * @param null|string $individualSenderRequirementsText - Sender Requirement (Free text) or null for none
	 *
	 * @deprecated - Invalid name of the function
	 */
	public function setIndividualSenderRequiredmentsText($individualSenderRequirementsText) {
		trigger_error(
			'Called deprecated method ' . __METHOD__ . ': Use setIndividualSenderRequirementsText() instead, this method will removed in the future!',
			E_USER_DEPRECATED
		);

		$this->setIndividualSenderRequirementsText($individualSenderRequirementsText);
	}

	/**
	 * Get if the Service "IndividualSenderRequirements" is enabled
	 *
	 * @return bool|null - Service "IndividualSenderRequirements" is enabled or null for default
	 */
	public function getIndividualSenderRequirementsEnabled() {
		return $this->individualSenderRequirementsEnabled;
	}

	/**
	 * Set if the Service "IndividualSenderRequirements" is enabled
	 *
	 * @param bool|null $individualSenderRequirementsEnabled - Service "IndividualSenderRequirements" is enabled or null for default
	 */
	public function setIndividualSenderRequirementsEnabled($individualSenderRequirementsEnabled) {
		$this->individualSenderRequirementsEnabled = $individualSenderRequirementsEnabled;
	}

	/**
	 * Get the Sender Requirements
	 *
	 * @return null|string - Sender Requirement (Free text) or null for none
	 */
	public function getIndividualSenderRequirementsText() {
		return $this->individualSenderRequirementsText;
	}

	/**
	 * Set the Sender Requirements
	 *
	 * @param null|string $individualSenderRequirementsText - Sender Requirement (Free text) or null for none
	 */
	public function setIndividualSenderRequirementsText($individualSenderRequirementsText) {
		$this->individualSenderRequirementsText = $individualSenderRequirementsText;
	}

	/**
	 * Get if Packaging return is enabled
	 *
	 * @return bool|null - Packaging return is enabled or null for default
	 */
	public function getPackagingReturn() {
		return $this->packagingReturn;
	}

	/**
	 * Set if Packaging return is enabled
	 *
	 * @param bool|null $packagingReturn - Packaging return is enabled or null for default
	 */
	public function setPackagingReturn($packagingReturn) {
		$this->packagingReturn = $packagingReturn;
	}

	/**
	 * Alias for $this->getReturnImmediatelyIfShipmentFailed()
	 *
	 * @return bool|null - Should Package return immediately when the shipping has failed or null for default
	 * 
	 * @deprecated - Invalid name of the function
	 */
	public function getReturnImmediatlyIfShipmentFailed() {
		trigger_error(
			'Called deprecated method ' . __METHOD__ . ': Use getReturnImmediatelyIfShipmentFailed() instead, this method will removed in the future!',
			E_USER_DEPRECATED
		);
		
		return $this->getReturnImmediatelyIfShipmentFailed();
	}

	/**
	 * Alias for $this->setReturnImmediatelyIfShipmentFailed()
	 *
	 * @param bool|null $returnImmediatelyIfShipmentFailed - Should Package return immediately when the shipping has failed or null for default
	 * 
	 * @deprecated - Invalid name of the function
	 */
	public function setReturnImmediatlyIfShipmentFailed($returnImmediatelyIfShipmentFailed) {
		trigger_error(
			'Called deprecated method ' . __METHOD__ . ': Use setReturnImmediatelyIfShipmentFailed() instead, this method will removed in the future!',
			E_USER_DEPRECATED
		);
		
		$this->setReturnImmediatelyIfShipmentFailed($returnImmediatelyIfShipmentFailed);
	}
	
	/**
	 * Get if the Package should return immediately when the shipping has failed
	 * 
	 * @return bool|null - Should Package return immediately when the shipping has failed or null for default
	 */
	public function getReturnImmediatelyIfShipmentFailed() {
		return $this->returnImmediatelyIfShipmentFailed;
	}

	/**
	 * Set if the Package should return immediately when the shipping has failed
	 * 
	 * @param bool|null $returnImmediatelyIfShipmentFailed - Should Package return immediately when the shipping has failed or null for default
	 */
	public function setReturnImmediatelyIfShipmentFailed($returnImmediatelyIfShipmentFailed) {
		$this->returnImmediatelyIfShipmentFailed = $returnImmediatelyIfShipmentFailed;
	}

	/**
	 * Alias for $this->getNoticeOnNonDeliverable()
	 *
	 * @return bool|null - Is the Service "Notice on Non-Deliverable" enabled or null for default
	 *
	 * @deprecated - Invalid name of the function
	 */
	public function getNoticeNonDeliverability() {
		trigger_error(
			'Called deprecated method ' . __METHOD__ . ': Use getNoticeOnNonDeliverable() instead, this method will removed in the future!',
			E_USER_DEPRECATED
		);

		return $this->getNoticeOnNonDeliverable();
	}

	/**
	 * Alias for $this->setNoticeOnNonDeliverable()
	 *
	 * @param bool|null $noticeOnNonDeliverable - Is the Service "Notice on Non-Deliverable" enabled or null for default
	 *
	 * @deprecated - Invalid name of the function
	 */
	public function setNoticeNonDeliverability($noticeOnNonDeliverable) {
		trigger_error(
			'Called deprecated method ' . __METHOD__ . ': Use setNoticeOnNonDeliverable() instead, this method will removed in the future!',
			E_USER_DEPRECATED
		);

		$this->setNoticeOnNonDeliverable($noticeOnNonDeliverable);
	}

	/**
	 * Get if the Service "Notice on Non-Deliverable" is enabled
	 *
	 * @return bool|null - Is the Service "Notice on Non-Deliverable" enabled or null for default
	 */
	public function getNoticeOnNonDeliverable() {
		return $this->noticeOnNonDeliverable;
	}

	/**
	 * Set if the Service "Notice on Non-Deliverable" is enabled
	 *
	 * @param bool|null $noticeOnNonDeliverable - Is the Service "Notice on Non-Deliverable" enabled or null for default
	 */
	public function setNoticeOnNonDeliverable($noticeOnNonDeliverable) {
		$this->noticeOnNonDeliverable = $noticeOnNonDeliverable;
	}

	/**
	 * Get if the Service "ShipmentHandling" is enabled
	 *
	 * @return bool|null - Is the Service "ShipmentHandling" enabled or null for default
	 */
	public function getShipmentHandlingEnabled() {
		return $this->shipmentHandlingEnabled;
	}

	/**
	 * Set if the Service "ShipmentHandling" is enabled
	 *
	 * @param bool|null $shipmentHandlingEnabled - Is the Service "ShipmentHandling" enabled or null for default
	 */
	public function setShipmentHandlingEnabled($shipmentHandlingEnabled) {
		$this->shipmentHandlingEnabled = $shipmentHandlingEnabled;
	}

	/**
	 * Get the Shipment-Handling Type
	 *
	 * You will get the following values:
	 * 	'a': Remove content, return box;
	 * 	'b': Remove content, pick up and dispose cardboard packaging;
	 * 	'c': Handover parcel/box to customer ¿ no disposal of cardboar.d/box;
	 * 	'd': Remove bag from of cooling unit and handover to customer;
	 * 	'e': Remove content, apply return label und seal box, return box
	 * 	null: none
	 *
	 * @return null|string - Shipment-Handling Type or null for none
	 */
	public function getShipmentHandlingType() {
		return $this->shipmentHandlingType;
	}

	/**
	 * Set the Shipment-Handling Type
	 *
	 * The following values are allowed:
	 * 	'a': Remove content, return box;
	 * 	'b': Remove content, pick up and dispose cardboard packaging;
	 * 	'c': Handover parcel/box to customer ¿ no disposal of cardboar.d/box;
	 * 	'd': Remove bag from of cooling unit and handover to customer;
	 * 	'e': Remove content, apply return label und seal box, return box
	 * 	null: none
	 *
	 * @param null|string $shipmentHandlingType - Shipment-Handling Type or null for none
	 */
	public function setShipmentHandlingType($shipmentHandlingType) {
		$this->shipmentHandlingType = $shipmentHandlingType;
	}

	/**
	 * Get if the Service "Endorsement" is enabled
	 *
	 * @return bool|null - Is the Service "Endorsement" enabled or null for default
	 */
	public function getEndorsementEnabled() {
		return $this->endorsementEnabled;
	}

	/**
	 * Set if the Service "Endorsement" is enabled
	 *
	 * @param bool|null $endorsementEnabled - Is the Service "Endorsement" enabled or null for default
	 */
	public function setEndorsementEnabled($endorsementEnabled) {
		$this->endorsementEnabled = $endorsementEnabled;
	}

	/**
	 * Get the Endorsement Type
	 *
	 * Values for national:
	 * 	'SOZU': (Return immediately),
	 * 	'ZWZU': (2nd attempt of Delivery);
	 * ---------------------------
	 * Values for International:
	 * 	'IMMEDIATE': (Sending back immediately to sender),
	 * 	'AFTER_DEADLINE': (Sending back immediately to sender after expiration of time),
	 * 	'ABANDONMENT': (Abandonment of parcel at the hands of sender (free of charge))
	 *
	 * @return null|string - Endorsement-Service Type or null for none
	 */
	public function getEndorsementType() {
		return $this->endorsementType;
	}

	/**
	 * Set the Endorsement Type
	 *
	 * Values for national:
	 * 	'SOZU': (Return immediately),
	 * 	'ZWZU': (2nd attempt of Delivery);
	 * ---------------------------
	 * Values for International:
	 * 	'IMMEDIATE': (Sending back immediately to sender),
	 * 	'AFTER_DEADLINE': (Sending back immediately to sender after expiration of time),
	 * 	'ABANDONMENT': (Abandonment of parcel at the hands of sender (free of charge))
	 *
	 * @param null|string $endorsementType - Endorsement-Service Type or null for none
	 */
	public function setEndorsementType($endorsementType) {
		$this->endorsementType = $endorsementType;
	}

	/**
	 * Get if the Service "VisualCheckOfAge" is enabled
	 *
	 * @return bool|null - Is the Service "VisualCheckOfAge" enabled or null for default
	 */
	public function getVisualCheckOfAgeEnabled() {
		return $this->visualCheckOfAgeEnabled;
	}

	/**
	 * Set if the Service "VisualCheckOfAge" is enabled
	 *
	 * @param bool|null $visualCheckOfAgeEnabled - Is the Service "VisualCheckOfAge" enabled or null for default
	 */
	public function setVisualCheckOfAgeEnabled($visualCheckOfAgeEnabled) {
		$this->visualCheckOfAgeEnabled = $visualCheckOfAgeEnabled;
	}

	/**
	 * Get the Age that the Receiver should be at least have
	 *
	 * You will get the following values:
	 * 	'A16': Person must be 16+
	 * 	'A18': Person must be 18+
	 *
	 * @return null|string - Minimum-Age of the Receiver or null for none
	 */
	public function getVisualCheckOfAgeType() {
		return $this->visualCheckOfAgeType;
	}

	/**
	 * Set the Age that the Receiver should be at least have
	 *
	 * The following Values are allowed:
	 * 	'A16': Person must be 16+
	 * 	'A18': Person must be 18+
	 *
	 * @param null|string $visualCheckOfAgeType - Minimum-Age of the Receiver or null for none
	 */
	public function setVisualCheckOfAgeType($visualCheckOfAgeType) {
		$this->visualCheckOfAgeType = $visualCheckOfAgeType;
	}

	/**
	 * Get if the Service "PreferredLocation" is enabled
	 *
	 * @return bool|null - Is the Service "PreferredLocation" enabled or null for default
	 */
	public function getPreferredLocationEnabled() {
		return $this->preferredLocationEnabled;
	}

	/**
	 * Set if the Service "PreferredLocation" is enabled
	 *
	 * @param bool|null $preferredLocationEnabled - Is the Service "PreferredLocation" enabled or null for default
	 */
	public function setPreferredLocationEnabled($preferredLocationEnabled) {
		$this->preferredLocationEnabled = $preferredLocationEnabled;
	}

	/**
	 * Get the details of the preferred Location (Free text)
	 *
	 * @return null|string - Details of the preferred Location (Free text) or null for none
	 */
	public function getPreferredLocationDetails() {
		return $this->preferredLocationDetails;
	}

	/**
	 * Set the details of the preferred Location (Free text)
	 *
	 * @param null|string $preferredLocationDetails - Details of the preferred Location (Free text) or null for none
	 */
	public function setPreferredLocationDetails($preferredLocationDetails) {
		$this->preferredLocationDetails = $preferredLocationDetails;
	}

	/**
	 * Get if the Service "PreferredNeighbour" is enabled
	 *
	 * @return bool|null - Is the Service "PreferredNeighbour" enabled or null for default
	 */
	public function getPreferredNeighbourEnabled() {
		return $this->preferredNeighbourEnabled;
	}

	/**
	 * Set if the Service "PreferredNeighbour" is enabled
	 *
	 * @param bool|null $preferredNeighbourEnabled - Is the Service "PreferredNeighbour" enabled or null for default
	 */
	public function setPreferredNeighbourEnabled($preferredNeighbourEnabled) {
		$this->preferredNeighbourEnabled = $preferredNeighbourEnabled;
	}

	/**
	 * Get the details of the preferred Neighbour (Free text)
	 *
	 * @return null|string - The details of the preferred Neighbour (Free text) or null for none
	 */
	public function getPreferredNeighbourText() {
		return $this->preferredNeighbourText;
	}

	/**
	 * Set the details of the preferred Neighbour (Free text)
	 *
	 * @param null|string $preferredNeighbourText - The details of the preferred Neighbour (Free text) or null for none
	 */
	public function setPreferredNeighbourText($preferredNeighbourText) {
		$this->preferredNeighbourText = $preferredNeighbourText;
	}

	/**
	 * Get if the Service "PreferredDay" is enabled
	 *
	 * @return bool|null - Is the Service "PreferredDay" enabled or null for default
	 */
	public function getPreferredDayEnabled() {
		return $this->preferredDayEnabled;
	}

	/**
	 * Set if the Service "PreferredDay" is enabled
	 *
	 * @param bool|null $preferredDayEnabled - Is the Service "PreferredDay" enabled or null for default
	 */
	public function setPreferredDayEnabled($preferredDayEnabled) {
		$this->preferredDayEnabled = $preferredDayEnabled;
	}

	/**
	 * Get the details of the preferred Day (Free text)
	 *
	 * @return null|string - The details of the preferred Day (Free text) or null for none
	 */
	public function getPreferredDayText() {
		return $this->preferredDayText;
	}

	/**
	 * Set the details of the preferred Day (Free text)
	 *
	 * @param null|string $preferredDayText - The details of the preferred Day (Free text) or null for none
	 */
	public function setPreferredDayText($preferredDayText) {
		$this->preferredDayText = $preferredDayText;
	}

	/**
	 * Get if the Service "GoGreen" is enabled
	 *
	 * @return bool|null - Is the Service "GoGreen" enabled or null for default
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	public function getGoGreen() {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);

		return $this->goGreen;
	}

	/**
	 * Set if the Service "GoGreen" is enabled
	 *
	 * @param bool|null $goGreen - Is the Service "GoGreen" enabled or null for default
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	public function setGoGreen($goGreen) {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);

		$this->goGreen = $goGreen;
	}

	/**
	 * Get if deliver Perishables
	 *
	 * @return bool|null - Deliver Perishables or null for default
	 */
	public function getPerishables() {
		return $this->perishables;
	}

	/**
	 * Set if deliver Perishables
	 *
	 * @param bool|null $perishables - Deliver Perishables or null for default
	 */
	public function setPerishables($perishables) {
		$this->perishables = $perishables;
	}

	/**
	 * Get if the Service "PersonalHandover" is enabled
	 *
	 * @return bool|null - Is the Service "PersonalHandover" enabled or null for default
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	public function getPersonalHandover() {
		trigger_error(
			'[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon ( Called method ' . __METHOD__ .
			' - Version 2 Function: getNamedPersonOnly() )!',
			E_USER_DEPRECATED
		);

		return $this->personalHandover;
	}

	/**
	 * Set if the Service "PersonalHandover" is enabled
	 *
	 * @param bool|null $personalHandover - Is the Service "PersonalHandover" enabled or null for default
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	public function setPersonalHandover($personalHandover) {
		trigger_error(
			'[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon ( Called method ' . __METHOD__ .
			' - Version2 Function: setNamedPersonOnly($name) )!',
			E_USER_DEPRECATED
		);

		$this->personalHandover = $personalHandover;
	}

	/**
	 * Get if the Service "DisableNeighbourDelivery" is enabled
	 *
	 * @return bool|null - Is the Service "DisableNeighbourDelivery" enabled or null for default
	 */
	public function getDisableNeighbourDelivery() {
		return $this->disableNeighbourDelivery;
	}

	/**
	 * Set if the Service "DisableNeighbourDelivery" is enabled
	 *
	 * @param bool|null $disableNeighbourDelivery - Is the Service "DisableNeighbourDelivery" enabled or null for default
	 */
	public function setDisableNeighbourDelivery($disableNeighbourDelivery) {
		$this->disableNeighbourDelivery = $disableNeighbourDelivery;
	}

	/**
	 * Get if named Person can only accept delivery
	 *
	 * @return bool|null - Named Person can only accept delivery or null for default
	 */
	public function getNamedPersonOnly() {
		return $this->namedPersonOnly;
	}

	/**
	 * Set if named Person can only accept delivery
	 *
	 * @param bool|null $namedPersonOnly - Named Person can only accept delivery or null for default
	 */
	public function setNamedPersonOnly($namedPersonOnly) {
		$this->namedPersonOnly = $namedPersonOnly;
	}

	/**
	 * Get if the Service "ReturnReceipt" is enabled
	 *
	 * @return bool|null - Is the Service "ReturnReceipt" enabled or null for default
	 */
	public function getReturnReceipt() {
		return $this->returnReceipt;
	}

	/**
	 * Set if the Service "ReturnReceipt" is enabled
	 *
	 * @param bool|null $returnReceipt - Is the Service "ReturnReceipt" enabled or null for default
	 */
	public function setReturnReceipt($returnReceipt) {
		$this->returnReceipt = $returnReceipt;
	}

	/**
	 * Get if Premium is enabled (for fast and safe delivery of international shipments)
	 *
	 * @return bool|null - Premium is enabled or null for default
	 */
	public function getPremium() {
		return $this->premium;
	}

	/**
	 * Set if Premium is enabled (for fast and safe delivery of international shipments)
	 *
	 * @param bool|null $premium - Premium is enabled or null for default
	 */
	public function setPremium($premium) {
		$this->premium = $premium;
	}

	/**
	 * Get if Cash on delivery (COD) is enabled
	 *
	 * @return bool|null - Is Cash on delivery (COD) enabled or null for default
	 */
	public function getCashOnDeliveryEnabled() {
		return $this->cashOnDeliveryEnabled;
	}

	/**
	 * Set if Cash on delivery (COD) is enabled
	 *
	 * @param bool|null $cashOnDeliveryEnabled - Is Cash on delivery (COD) enabled or null for default
	 */
	public function setCashOnDeliveryEnabled($cashOnDeliveryEnabled) {
		$this->cashOnDeliveryEnabled = $cashOnDeliveryEnabled;
	}

	/**
	 * Get if the Service "AddFee" is enabled
	 *
	 * @return bool|null - Is the Service "AddFee" is enabled or null for default
	 */
	public function getCashOnDeliveryAddFee() {
		return $this->cashOnDeliveryAddFee;
	}

	/**
	 * Set if the Service "AddFee" is enabled
	 *
	 * @param bool|null $cashOnDeliveryAddFee - Is the Service "AddFee" is enabled or null for default
	 */
	public function setCashOnDeliveryAddFee($cashOnDeliveryAddFee) {
		$this->cashOnDeliveryAddFee = $cashOnDeliveryAddFee;
	}

	/**
	 * Get the Amount how much the receiver must pay
	 *
	 * @return float|null - The Amount how much the receiver must pay or null for none
	 */
	public function getCashOnDeliveryAmount() {
		return $this->cashOnDeliveryAmount;
	}

	/**
	 * Set the Amount how much the receiver must pay
	 *
	 * @param float|null $cashOnDeliveryAmount - The Amount how much the receiver must pay or null for none
	 */
	public function setCashOnDeliveryAmount($cashOnDeliveryAmount) {
		$this->cashOnDeliveryAmount = $cashOnDeliveryAmount;
	}

	/**
	 * Get if additional Insurance is enabled
	 *
	 * @return bool|null - Is additional Insurance enabled or null for default
	 */
	public function getAdditionalInsuranceEnabled() {
		return $this->additionalInsuranceEnabled;
	}

	/**
	 * Set if additional Insurance is enabled
	 *
	 * @param bool|null $additionalInsuranceEnabled - Is additional Insurance enabled or null for default
	 */
	public function setAdditionalInsuranceEnabled($additionalInsuranceEnabled) {
		$this->additionalInsuranceEnabled = $additionalInsuranceEnabled;
	}

	/**
	 * Get the Amount with that the Shipment is insured
	 *
	 * @return float|null - The Amount with that the Shipment is insured or null for none
	 */
	public function getAdditionalInsuranceAmount() {
		return $this->additionalInsuranceAmount;
	}

	/**
	 * Set the Amount with that the Shipment is insured
	 *
	 * @param float|null $additionalInsuranceAmount - The Amount with that the Shipment is insured or null for none
	 */
	public function setAdditionalInsuranceAmount($additionalInsuranceAmount) {
		$this->additionalInsuranceAmount = $additionalInsuranceAmount;
	}

	/**
	 * Get if you deliver Bulky-Goods
	 *
	 * @return bool|null - Do you deliver Bulky-Goods or null for default
	 */
	public function getBulkyGoods() {
		return $this->bulkyGoods;
	}

	/**
	 * Set if you deliver Bulky-Goods
	 *
	 * @param bool|null $bulkyGoods - Do you deliver Bulky-Goods or null for default
	 */
	public function setBulkyGoods($bulkyGoods) {
		$this->bulkyGoods = $bulkyGoods;
	}

	/**
	 * Get if Ident check is enabled
	 *
	 * @return bool|null - Is Ident check enabled or null for default
	 */
	public function getIdentCheckEnabled() {
		return $this->identCheckEnabled;
	}

	/**
	 * Set if Ident check is enabled
	 *
	 * @param bool|null $identCheckEnabled - Is Ident check enabled or null for default
	 */
	public function setIdentCheckEnabled($identCheckEnabled) {
		$this->identCheckEnabled = $identCheckEnabled;
	}

	/**
	 * Get the IdentCheck Object
	 *
	 * @return IdentCheck|null - The IdentCheck Object or null for none
	 */
	public function getIdentCheckObj() {
		return $this->identCheckObj;
	}

	/**
	 * Set the IdentCheck Object
	 *
	 * @param IdentCheck|null $identCheckObj - The IdentCheck Object or null for none
	 */
	public function setIdentCheckObj($identCheckObj) {
		$this->identCheckObj = $identCheckObj;
	}

	/**
	 * Get the Class of this Service-Object
	 *
	 * @param string $productType - Type of the Product
	 * @return StdClass - Service-DHL-Class
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	public function getServiceClass_v1($productType) {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		return new StdClass;
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
				ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER,
				ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
			))) {
			$class->DayOfDelivery = new StdClass;
			$class->DayOfDelivery->active = (int) $this->getDayOfDeliveryEnabled();
			$class->DayOfDelivery->details = $this->getDayOfDeliveryDate();
		}
		if($this->getDeliveryTimeframeEnabled() !== null && in_array(
				$productType,
				array(
					ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER,
					ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
				))) {
			$class->DeliveryTimeframe = new StdClass;
			$class->DeliveryTimeframe->active = (int) $this->getDeliveryTimeframeEnabled();
			$class->DeliveryTimeframe->type = $this->getDeliveryTimeframe();
		}
		if($this->getPreferredTimeEnabled() !== null && in_array(
				$productType,
				array(
					ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE,
					ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE
				))) {
			$class->PreferredTime = new StdClass;
			$class->PreferredTime->active = (int) $this->getPreferredTimeEnabled();
			$class->PreferredTime->type = $this->getPreferredTime();
		}
		if($this->getIndividualSenderRequirementsEnabled() !== null && in_array(
				$productType,
				array(
					ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER,
					ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
				))) {
			$class->IndividualSenderRequirement = new StdClass;
			$class->IndividualSenderRequirement->active = (int) $this->getIndividualSenderRequirementsEnabled();
			$class->IndividualSenderRequirement->details = $this->getIndividualSenderRequirementsText();
		}
		if($this->getPackagingReturn() !== null) {
			$class->PackagingReturn = new StdClass;
			$class->PackagingReturn->active = (int) $this->getPackagingReturn();
		}
		if($this->getReturnImmediatelyIfShipmentFailed() !== null && in_array(
				$productType,
				array(
					ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE
				))) {
			$class->ReturnImmediately = new StdClass;
			$class->ReturnImmediately->active = (int) $this->getReturnImmediatelyIfShipmentFailed();
		}
		if($this->getNoticeOnNonDeliverable() !== null) {
			$class->NoticeOfNonDeliverability = new StdClass;
			$class->NoticeOfNonDeliverability->active = (int) $this->getNoticeOnNonDeliverable();
		}
		if($this->getShipmentHandlingEnabled() !== null && in_array(
				$productType,
				array(
					ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER,
					ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
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
		if($this->getPerishables() !== null) {
			$class->Perishables = new StdClass;
			$class->Perishables->active = (int) $this->getPerishables();
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
