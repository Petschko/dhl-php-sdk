<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: https://petschko.org/
 * Date: 12.08.2018
 * Time: 18:02
 *
 * Notes: Contains the ShipmentOrder Class
 */

use stdClass;
use Exception;

/**
 * Class ShipmentOrder
 *
 * @package Petschko\DHL
 */
class ShipmentOrder {
	/**
	 * Contains the Sequence-Number
	 *
	 * Min-Len: -
	 * Max-Len: 30
	 *
	 * @var string $sequenceNumber - Sequence-Number
	 */
	private $sequenceNumber = '1';

	/**
	 * Contains the Shipment Details
	 *
	 * @var ShipmentDetails $shipmentDetails - Shipment Details Object
	 */
	private $shipmentDetails;

	/**
	 * Contains the Sender-Object
	 *
	 * Note: Optional IF ShipperReference is given (Since 3.0)
	 *
	 * @var Sender|null $sender - Sender Object or null if use sender reference
	 */
	private $sender = null;

	/**
	 * Contains the Receiver-Object
	 *
	 * @var Receiver|PackStation|Filial $receiver - Receiver Object
	 */
	private $receiver;

	/**
	 * Contains the Return Receiver Object
	 *
	 * Note: Optional
	 *
	 * @var ReturnReceiver|null $returnReceiver - Return Receiver Object | null for none
	 */
	private $returnReceiver = null;

	/**
	 * Contains the Export-Document-Settings Object
	 *
	 * Note: Optional
	 *
	 * @var ExportDocument|null $exportDocument - Export-Document-Settings Object | null for none
	 */
	private $exportDocument = null;

	/**
	 * Contains a reference to the Shipper data configured in GKP
	 *
	 * Note: Optional but required if sender is not given
	 *
	 * @var string|null $shipperReference - Shipper Reference or null for none
	 * @since 3.0
	 */
	private $shipperReference = null;

	/**
	 * Contains if the label will be only be printable, if the receiver address is valid.
	 *
	 * Note: Optional
	 *
	 * @var bool|null $printOnlyIfReceiverIsValid - true will only print if receiver address is valid else false (null uses default)
	 */
	private $printOnlyIfReceiverIsValid = null;

	/**
	 * Contains if how the Label-Response-Type will be
	 *
	 * Note: Optional
	 * Values:
	 * BusinessShipment::RESPONSE_TYPE_URL -> Url
	 * BusinessShipment::RESPONSE_TYPE_B64 -> Base64
	 * BusinessShipment::RESPONSE_TYPE_XML -> XML (since 3.0)
	 *
	 * @var string|null $labelResponseType - Label-Response-Type (Can use class constance's) (null uses default)
	 */
	private $labelResponseType = null;

	/**
	 * Contains the Label-Format
	 *
	 * @var LabelFormat|null $labelFormat Label-Format (null uses default)
	 * @since 3.0
	 */
	private $labelFormat = null;

	/**
	 * Get the Sequence-Number
	 *
	 * @return string - Sequence-Number
	 */
	public function getSequenceNumber() {
		return $this->sequenceNumber;
	}

	/**
	 * Set the Sequence-Number
	 *
	 * @param string $sequenceNumber - Sequence-Number
	 */
	public function setSequenceNumber($sequenceNumber) {
		$this->sequenceNumber = $sequenceNumber;
	}

	/**
	 * Get Shipment-Details-Object
	 *
	 * @return ShipmentDetails - Shipment-Details-Object
	 */
	public function getShipmentDetails() {
		return $this->shipmentDetails;
	}

	/**
	 * Set Shipment-Details-Object
	 *
	 * @param ShipmentDetails $shipmentDetails - Shipment-Details-Object
	 */
	public function setShipmentDetails($shipmentDetails) {
		$this->shipmentDetails = $shipmentDetails;
	}

	/**
	 * Get the Sender-Object
	 *
	 * @return Sender|null - Sender-Object or null if use sender reference
	 */
	public function getSender() {
		return $this->sender;
	}

	/**
	 * Set the Sender-Object
	 *
	 * @param Sender|null $sender - Sender-Object or null if use sender reference
	 */
	public function setSender($sender) {
		$this->sender = $sender;
	}

	/**
	 * Get the Receiver-Object
	 *
	 * @return Receiver|PackStation|Filial - Receiver-Object
	 */
	public function getReceiver() {
		return $this->receiver;
	}

	/**
	 * Set the Receiver-Object
	 *
	 * @param Receiver|PackStation|Filial $receiver - Receiver-Object
	 */
	public function setReceiver($receiver) {
		$this->receiver = $receiver;
	}

	/**
	 * Get the ReturnReceiver-Object
	 *
	 * Usually only used for Re-Tour (In most cases the same Address like the Sender)
	 *
	 * @return ReturnReceiver|null - ReturnReceiver-Object or null if none
	 */
	public function getReturnReceiver() {
		return $this->returnReceiver;
	}

	/**
	 * Set the ReturnReceiver-Object
	 *
	 * Usually only used for Re-Tour (In most cases the same Address like the Sender)
	 *
	 * @param ReturnReceiver|null $returnReceiver - ReturnReceiver-Object or null for none
	 */
	public function setReturnReceiver($returnReceiver) {
		$this->returnReceiver = $returnReceiver;
	}

	/**
	 * Get the ExportDocument-Object
	 *
	 * @return ExportDocument|null - ExportDocument-Object or null if none
	 */
	public function getExportDocument() {
		return $this->exportDocument;
	}

	/**
	 * Set the ExportDocument-Object
	 *
	 * @param ExportDocument|null $exportDocument - ExportDocument-Object or null for none
	 */
	public function setExportDocument($exportDocument) {
		$this->exportDocument = $exportDocument;
	}

	/**
	 * Get the Shipper-Reference
	 *
	 * @return string|null - Shipper-Reference or null for none
	 * @since 3.0
	 */
	public function getShipperReference(): ?string {
		return $this->shipperReference;
	}

	/**
	 * Set the Shipper-Reference
	 *
	 * @param string|null $shipperReference - Shipper-Reference or null for none
	 * @since 3.0
	 */
	public function setShipperReference(?string $shipperReference): void {
		$this->shipperReference = $shipperReference;
	}

	/**
	 * Get if the label should only printed if the Receiver-Address is valid
	 *
	 * @return bool|null - Should the label only printed on a valid Address | null means DHL-Default
	 */
	public function getPrintOnlyIfReceiverIsValid() {
		return $this->printOnlyIfReceiverIsValid;
	}

	/**
	 * Set if the label should only printed if the Receiver-Address is valid
	 *
	 * WARNING: The Address-Validation can fail sometimes also on existing Addresses (for example new streets) use with care!
	 *
	 * @param bool|null $printOnlyIfReceiverIsValid - Should the label only printed on a valid Address | null uses default from DHL
	 */
	public function setPrintOnlyIfReceiverIsValid($printOnlyIfReceiverIsValid) {
		$this->printOnlyIfReceiverIsValid = $printOnlyIfReceiverIsValid;
	}

	/**
	 * Get the Label-Response type
	 *
	 * @return null|string - Label-Response type | null means DHL-Default
	 */
	public function getLabelResponseType() {
		return $this->labelResponseType;
	}

	/**
	 * Set the Label-Response type
	 *
	 * @param null|string $labelResponseType - Label-Response type | null uses DHL-Default
	 */
	public function setLabelResponseType($labelResponseType) {
		$this->labelResponseType = $labelResponseType;
	}

	/**
	 * Get the Label-Format
	 *
	 * @return LabelFormat|null - Label-Format | null means DHL-Default
	 * @since 3.0
	 */
	public function getLabelFormat(): ?LabelFormat {
		return $this->labelFormat;
	}

	/**
	 * Sets the Label-Format
	 *
	 * @param LabelFormat|null $labelFormat - Label-Format | null uses DHL-Default
	 * @since 3.0
	 */
	public function setLabelFormat(?LabelFormat $labelFormat): void {
		$this->labelFormat = $labelFormat;
	}

	/**
	 * Returns an DHL-Class of this Object for DHL-Shipment Order
	 *
	 * @return stdClass - DHL-ShipmentOrder-Class
	 * @since 2.0
	 */
	public function getShipmentOrderClass_v2() {
		$class = new StdClass;
		$class->sequenceNumber = $this->getSequenceNumber();

		// Shipment
		$class->Shipment = new StdClass;
		$class->Shipment->ShipmentDetails = $this->getShipmentDetails()->getShipmentDetailsClass_v2();

		// Shipper
		$class->Shipment->Shipper = $this->getSender()->getClass_v2();

		// Receiver
		$class->Shipment->Receiver = $this->getReceiver()->getClass_v2();

		// Return-Receiver
		if($this->getReturnReceiver() !== null)
			$class->Shipment->ReturnReceiver = $this->getReturnReceiver()->getClass_v2();

		// Export-Document
		if($this->getExportDocument() !== null) {
			try {
				$class->Shipment->ExportDocument = $this->getExportDocument()->getExportDocumentClass_v2();
			} catch(Exception $e) {
				trigger_error('[DHL-PHP-SDK]: Exception in method ' . __METHOD__ . ':' . $e->getMessage(), E_USER_WARNING);
			}
		}

		// Other Settings
		if($this->getPrintOnlyIfReceiverIsValid() !== null) {
			$class->PrintOnlyIfCodeable = new StdClass;
			$class->PrintOnlyIfCodeable->active = (int) $this->getPrintOnlyIfReceiverIsValid();
		}
		if($this->getLabelResponseType() !== null && in_array($this->getLabelResponseType(), array(BusinessShipment::RESPONSE_TYPE_URL, BusinessShipment::RESPONSE_TYPE_B64)))
			$class->labelResponseType = $this->getLabelResponseType();

		return $class;
	}

	/**
	 * Returns an DHL-Class of this Object for DHL-Shipment Order
	 *
	 * @return stdClass - DHL-ShipmentOrder-Class
	 * @since 3.0
	 */
	public function getShipmentOrderClass_v3() {
		$class = new StdClass;
		$class->sequenceNumber = $this->getSequenceNumber();

		// Shipment
		$class->Shipment = new StdClass;
		$class->Shipment->ShipmentDetails = $this->getShipmentDetails()->getShipmentDetailsClass_v3();

		// Receiver
		$class->Shipment->Receiver = $this->getReceiver()->getClass_v3();

		// Return-Receiver
		if($this->getReturnReceiver() !== null)
			$class->Shipment->ReturnReceiver = $this->getReturnReceiver()->getClass_v3();

		// Export-Document
		if($this->getExportDocument() !== null) {
			try {
				$class->Shipment->ExportDocument = $this->getExportDocument()->getExportDocumentClass_v3();
			} catch(Exception $e) {
				trigger_error('[DHL-PHP-SDK]: Exception in method ' . __METHOD__ . ':' . $e->getMessage(), E_USER_WARNING);
			}
		}

		// Shipper
		if($this->getSender() !== null)
			$class->Shipment->Shipper = $this->getSender()->getClass_v3();
		else
			$class->Shipment->ShipperReference = $this->getShipperReference();

		// Other Settings
		if($this->getPrintOnlyIfReceiverIsValid() !== null) {
			$class->PrintOnlyIfCodeable = new StdClass;
			$class->PrintOnlyIfCodeable->active = (int) $this->getPrintOnlyIfReceiverIsValid();
		}

		// Fixme: It doesnt seem to affect the single format, maybe it was just a bug
		if($this->getLabelResponseType() !== null)
			$class->labelResponseType = $this->getLabelResponseType();

		if($this->getLabelFormat() !== null)
			$class = $this->getLabelFormat()->addLabelFormatClass_v3($class);

		return $class;
	}
}
