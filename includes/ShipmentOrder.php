<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 12.08.2018
 * Time: 18:02
 * Update: -
 * Version: 0.0.1
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
	 * @var Sender $sender - Sender Object
	 */
	private $sender;

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
	 *
	 * @var string|null $labelResponseType - Label-Response-Type (Can use class constance's) (null uses default)
	 */
	private $labelResponseType = null;

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		unset($this->sequenceNumber);
		unset($this->shipmentDetails);
		unset($this->sender);
		unset($this->receiver);
		unset($this->returnReceiver);
		unset($this->exportDocument);
		unset($this->printOnlyIfReceiverIsValid);
		unset($this->labelResponseType);
	}

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
	 * @return Sender - Sender-Object
	 */
	public function getSender() {
		return $this->sender;
	}

	/**
	 * Set the Sender-Object
	 *
	 * @param Sender $sender - Sender-Object
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
	 * Returns an DHL-Class of this Object for DHL-Shipment Order
	 *
	 * @return stdClass - DHL-ShipmentOrder-Class
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
		if($this->getLabelResponseType() !== null)
			$class->labelResponseType = $this->getLabelResponseType();

		return $class;
	}
}
