<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 18.11.2016
 * Time: 16:00
 * Update: 06.08.2018
 * Version: 1.2.0
 *
 * Notes: Contains the DHL-Response Class, which manages the response that you get with simple getters
 */

/**
 * Class Response
 */
class Response extends Version {
	/**
	 * Contains Status-Code-Values:
	 *
	 * - Response::DHL_ERROR_NOT_SET -> Status-Code was not set
	 * - Response::DHL_ERROR_NO_ERROR -> No Error occurred
	 * - Response::DHL_ERROR_WEAK_WARNING -> A week warning has occurred
	 * - Response::DHL_ERROR_SERVICE_TMP_NOT_AVAILABLE -> DHL-API Service is not available
	 * - Response::DHL_ERROR_GENERAL -> General Error
	 * - Response::DHL_ERROR_AUTH_FAILED -> Authentication has failed
	 * - Response::DHL_ERROR_HARD_VAL_ERROR -> A hard-validation Error has occurred
	 * - Response::DHL_ERROR_UNKNOWN_SHIPMENT_NUMBER -> Given Shipment-Number is unknown
	 */
	const DHL_ERROR_NOT_SET = -1;
	const DHL_ERROR_NO_ERROR = 0;
	const DHL_ERROR_WEAK_WARNING = 1;
	const DHL_ERROR_SERVICE_TMP_NOT_AVAILABLE = 500;
	const DHL_ERROR_GENERAL = 1000;
	const DHL_ERROR_AUTH_FAILED = 1001;
	const DHL_ERROR_HARD_VAL_ERROR = 1101;
	const DHL_ERROR_UNKNOWN_SHIPMENT_NUMBER = 2000;

	/**
	 * Shipment-Number
	 *
	 * @var null|string $shipmentNumber - Shipment-Number | null if not set
	 */
	private $shipmentNumber = null;

	/**
	 * Note: Just used in v1
	 *
	 * @var null|string $pieceNumber - pieceNumber or null if not set
	 *
	 * @deprecated - DHL-API-Version 1 Field
	 */
	private $pieceNumber = null;

	/**
	 * Label URL/Base64-Data - Can also have the return label in one
	 *
	 * @var null|string $label - Label-URL or Base64-Label-Data | null if not set
	 */
	private $label = null;

	/**
	 * Return Label URL/Base64-Data
	 *
	 * @var null|string $returnLabel - Return Label-URL/Base64-Label-Data or null if not requested
	 */
	private $returnLabel = null;

	/**
	 * Export-Document-Label-URL/Base64-Data
	 *
	 * @var null|string $exportDoc - Export-Document Label-URL/Base64-Label-Data or null if not requested
	 */
	private $exportDoc = null;

	/**
	 * Manifest PDF-Data as Base64-String
	 *
	 * @var null|string $manifestData - Manifest PDF-Data as Base64 String or null if not requested
	 */
	private $manifestData = null;

	/**
	 * Label-Response-Type (Base64 or URL)
	 *
	 * @var null|string $labelType - Label-Response-Type (Base64 or URL) | null for default
	 */
	private $labelType;

	/**
	 * Sequence-Number (Useful for AJAX-Requests)
	 *
	 * @var string|null $sequenceNumber - Sequence-Number of the Request | null for none
	 */
	private $sequenceNumber = null;

	/**
	 * Contains the Status-Code
	 *
	 * - Response::DHL_ERROR_NOT_SET (-1) -> Status-Code was not set
	 * - Response::DHL_ERROR_NO_ERROR (0) -> No Error occurred
	 * - Response::DHL_ERROR_WEAK_WARNING (1) -> A week warning has occurred
	 * - Response::DHL_ERROR_SERVICE_TMP_NOT_AVAILABLE (500) -> DHL-API Service is not available
	 * - Response::DHL_ERROR_GENERAL (1000)-> General Error
	 * - Response::DHL_ERROR_AUTH_FAILED (1001) -> Authentication has failed
	 * - Response::DHL_ERROR_HARD_VAL_ERROR (1101) -> A hard-validation Error has occurred
	 * - Response::DHL_ERROR_UNKNOWN_SHIPMENT_NUMBER (2000) -> Given Shipment-Number is unknown
	 *
	 * @var int $statusCode - Status-Code
	 */
	private $statusCode = self::DHL_ERROR_NOT_SET;

	/**
	 * Contains the Status-Text
	 *
	 * @var string|null $statusText - Status-Text | null if not set
	 */
	private $statusText = null;

	/**
	 * Contains the Status-Message (Mostly more detailed, but longer)
	 *
	 * @var string|null $statusMessage - Status-Message | null if not set
	 */
	private $statusMessage = null;

	/**
	 * Response constructor.
	 *
	 * Loads the correct Version and loads the Response if not null into this Object
	 *
	 * @param string $version - Current DHL-Version
	 * @param null|Object $response - DHL-Response or null for none
	 * @param null|string $labelType - Label-Response-Type (Base64 or URL) or null for default (URL)
	 */
	public function __construct($version, $response = null, $labelType = null) {
		parent::__construct($version);

		$this->setLabelType($labelType);

		if($response !== null) {
			switch($this->getMayor()) {
				case 1:
					$this->loadResponse_v1($response);
					break;
				case 2:
				default:
					$this->loadResponse_v2($response);
			}
		}
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		parent::__destruct();
		unset($this->shipmentNumber);
		unset($this->pieceNumber);
		unset($this->label);
		unset($this->returnLabel);
		unset($this->exportDoc);
		unset($this->manifestData);
		unset($this->labelType);
		unset($this->sequenceNumber);
		unset($this->statusCode);
		unset($this->statusText);
		unset($this->statusMessage);
	}

	/**
	 * Getter for Shipment-Number
	 *
	 * @return null|string - Shipment-Number or null if not set
	 */
	public function getShipmentNumber() {
		return $this->shipmentNumber;
	}

	/**
	 * Setter for Shipment-Number
	 *
	 * @param null|string $shipment_number - Shipment-Number or null for not set
	 */
	private function setShipmentNumber($shipment_number) {
		$this->shipmentNumber = $shipment_number;
	}

	/**
	 * Getter for pieceNumber
	 *
	 * @return null|string - null if not set else pieceNumber (just used in API-Version 1)
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	public function getPieceNumber() {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);

		return $this->pieceNumber;
	}

	/**
	 * Setter for pieceNumber
	 *
	 * @param null|string $pieceNumber - null for not set else pieceNumber (just used in API-Version 1)
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	private function setPieceNumber($pieceNumber) {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);

		$this->pieceNumber = $pieceNumber;
	}

	/**
	 * Getter for Label
	 *
	 * @return null|string - Label URL/Base64-Data (Can also contain the return label) or null if not set
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * Setter for Label
	 *
	 * @param null|string $label - Label URL/Base64-Data (Can also contain the return label) or null for not set
	 */
	private function setLabel($label) {
		$this->label = $label;
	}

	/**
	 * Getter for ReturnLabel
	 *
	 * @return null|string - Return Label-URL/Base64-Label-Data or null if not requested/set
	 */
	public function getReturnLabel() {
		return $this->returnLabel;
	}

	/**
	 * Setter for ReturnLabel
	 *
	 * @param null|string $returnLabel - Return Label-URL/Base64-Label-Data or null for not requested/set
	 */
	private function setReturnLabel($returnLabel) {
		$this->returnLabel = $returnLabel;
	}

	/**
	 * Getter for Export-Document
	 *
	 * @return null|string - Export-Document Label-URL/Base64-Label-Data or null if not requested/set
	 */
	public function getExportDoc() {
		return $this->exportDoc;
	}

	/**
	 * Setter for Export-Document
	 *
	 * @param null|string $exportDoc - Export-Document Label-URL/Base64-Label-Data or null for not requested/set
	 */
	private function setExportDoc($exportDoc) {
		$this->exportDoc = $exportDoc;
	}

	/**
	 * Get the Manifest PDF-Data as Base64-String
	 *
	 * @return null|string - PDF-Data as Base64-String or null if empty/not requested
	 */
	public function getManifestData() {
		return $this->manifestData;
	}

	/**
	 * Set the Manifest PDF-Data as Base64-String
	 *
	 * @param null|string $manifestData - PDF-Data as Base64-String or null for none
	 */
	private function setManifestData($manifestData) {
		$this->manifestData = $manifestData;
	}

	/**
	 * Getter for Label-Response-Type
	 *
	 * @return null|string - Label-Response-Type (Base64 or URL) or null for default (URL)
	 */
	private function getLabelType() {
		return $this->labelType;
	}

	/**
	 * Setter for Label-Response-Type
	 *
	 * @param null|string $labelType - Label-Response-Type (Base64 or URL) or null for default (URL)
	 */
	private function setLabelType($labelType) {
		$this->labelType = $labelType;
	}

	/**
	 * Getter for Sequence-Number
	 *
	 * @return string|null - Sequence-Number of the Request or null if not set
	 */
	public function getSequenceNumber() {
		return $this->sequenceNumber;
	}

	/**
	 * Setter for Sequence-Number
	 *
	 * @param string|null $sequenceNumber - Sequence-Number of the Request or null for not set
	 */
	private function setSequenceNumber($sequenceNumber) {
		$this->sequenceNumber = $sequenceNumber;
	}

	/**
	 * Getter for Status-Code
	 *
	 * - Response::DHL_ERROR_NOT_SET (-1) -> Status-Code was not set
	 * - Response::DHL_ERROR_NO_ERROR (0) -> No Error occurred
	 * - Response::DHL_ERROR_WEAK_WARNING (1) -> A week warning has occurred
	 * - Response::DHL_ERROR_SERVICE_TMP_NOT_AVAILABLE (500) -> DHL-API Service is not available
	 * - Response::DHL_ERROR_GENERAL (1000)-> General Error
	 * - Response::DHL_ERROR_AUTH_FAILED (1001) -> Authentication has failed
	 * - Response::DHL_ERROR_HARD_VAL_ERROR (1101) -> A hard-validation Error has occurred
	 * - Response::DHL_ERROR_UNKNOWN_SHIPMENT_NUMBER (2000) -> Given Shipment-Number is unknown
	 *
	 * @return int - Status-Code
	 */
	public function getStatusCode() {
		return $this->statusCode;
	}

	/**
	 * Setter for Status-Code
	 *
	 * - Response::DHL_ERROR_NOT_SET (-1) -> Status-Code was not set
	 * - Response::DHL_ERROR_NO_ERROR (0) -> No Error occurred
	 * - Response::DHL_ERROR_WEAK_WARNING (1) -> A week warning has occurred
	 * - Response::DHL_ERROR_SERVICE_TMP_NOT_AVAILABLE (500) -> DHL-API Service is not available
	 * - Response::DHL_ERROR_GENERAL (1000)-> General Error
	 * - Response::DHL_ERROR_AUTH_FAILED (1001) -> Authentication has failed
	 * - Response::DHL_ERROR_HARD_VAL_ERROR (1101) -> A hard-validation Error has occurred
	 * - Response::DHL_ERROR_UNKNOWN_SHIPMENT_NUMBER (2000) -> Given Shipment-Number is unknown
	 *
	 * @param int $statusCode - Status-Code
	 */
	private function setStatusCode($statusCode) {
		$this->statusCode = $statusCode;
	}

	/**
	 * Getter for Status-Text
	 *
	 * @return string|null - Status-Text or null if not set
	 */
	public function getStatusText() {
		return $this->statusText;
	}

	/**
	 * Setter for Status-Text
	 *
	 * @param string|null $statusText - Status-Text or null for not set
	 */
	private function setStatusText($statusText) {
		$this->statusText = $statusText;
	}

	/**
	 * Getter for Status-Message
	 *
	 * @return string|null - Status-Message or null if not set
	 */
	public function getStatusMessage() {
		return $this->statusMessage;
	}

	/**
	 * Setter for Status-Message
	 *
	 * @param string|null $statusMessage - Status-Message or null for not set
	 */
	private function setStatusMessage($statusMessage) {
		$this->statusMessage = $statusMessage;
	}

	/**
	 * Loads a DHL-Response into this Object
	 *
	 * @param Object $response - DHL-Response
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	private function loadResponse_v1($response) {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);

		// Set Shipment-Number if exists
		if(isset($response->CreationState->ShipmentNumber->shipmentNumber))
			$this->setShipmentNumber((string) $response->CreationState->ShipmentNumber->shipmentNumber);

		if(isset($response->CreationState->PieceInformation->PieceNumber->licensePlate))
			$this->setPieceNumber((string) $response->CreationState->PieceInformation->PieceNumber->licensePlate);

		// Set Label if exists
		if($this->getLabelType() === BusinessShipment::RESPONSE_TYPE_B64) {
			if(isset($response->CreationState->Labeldata))
				$this->setLabel($response->CreationState->Labeldata);
		} else if(isset($response->CreationState->Labelurl))
			$this->setLabel($response->CreationState->Labelurl);

		$this->setStatusCode((int) $response->status->StatusCode);
		$this->setStatusMessage($response->status->StatusMessage);
	}

	/**
	 * Loads a DHL-Response into this Object
	 *
	 * @param Object $response - DHL-Response
	 */
	private function loadResponse_v2($response) {
		// Set Status-Values first
		if(
			! isset($response->CreationState->LabelData->Status->statusCode) &&
			! isset($response->LabelData->Status->statusCode) &&
			! isset($response->ExportDocData->Status->statusCode) &&
			! isset($response->ValidationState->Status->statusCode)
		) {
			// Set fault Status-Code | Set short responses
			$this->setStatusCode((int) $response->Status->statusCode);
			$this->setStatusText($response->Status->statusText);
			$this->setStatusMessage($response->Status->statusMessage);

			if(isset($response->manifestData))
				$this->setManifestData($response->manifestData);

			return;
		}

		if(isset($response->CreationState->LabelData->Status->statusCode)) {
			$this->setStatusCode((int) $response->CreationState->LabelData->Status->statusCode);
			$this->setStatusText($response->CreationState->LabelData->Status->statusText);
			$this->setStatusMessage($response->CreationState->LabelData->Status->statusMessage);
		} else if(isset($response->LabelData->Status->statusCode)) {
			$this->setStatusCode((int) $response->LabelData->Status->statusCode);
			$this->setStatusText($response->LabelData->Status->statusText);
			$this->setStatusMessage($response->LabelData->Status->statusMessage);
		} else if(isset($response->ExportDocData->Status->statusCode)) {
			// Export-Doc
			$this->setStatusCode((int) $response->ExportDocData->Status->statusCode);
			$this->setStatusText($response->ExportDocData->Status->statusText);
			$this->setStatusMessage($response->ExportDocData->Status->statusMessage);
		} else {
			// Validate Shipment
			$this->setStatusCode((int) $response->ValidationState->Status->statusCode);
			$this->setStatusText($response->Status->statusText);
			if(is_array($response->Status->statusMessage))
				$this->setStatusMessage(implode(';', $response->Status->statusMessage));
			else
				$this->setStatusMessage($response->Status->statusMessage);
		}

		// Change Status-Code if a weak-validation error occurs
		if($this->getStatusCode() === 0 && $this->getStatusText() !== 'ok')
			$this->setStatusCode(self::DHL_ERROR_WEAK_WARNING);

		// Set Shipment-Number if exists
		if(isset($response->CreationState->LabelData->shipmentNumber))
			$this->setShipmentNumber((string) $response->CreationState->LabelData->shipmentNumber);
		else if(isset($response->LabelData->shipmentNumber))
			$this->setShipmentNumber($response->LabelData->shipmentNumber);
		else if(isset($response->ExportDocData->shipmentNumber))
			$this->setShipmentNumber($response->ExportDocData->shipmentNumber);

		// Set Label if exists
		if($this->getLabelType() === BusinessShipment::RESPONSE_TYPE_B64) {
			if(isset($response->CreationState->LabelData->labelData))
				$this->setLabel($response->CreationState->LabelData->labelData);
			else if(isset($response->LabelData->labelData))
				$this->setLabel($response->LabelData->labelData);
		} else {
			if(isset($response->CreationState->LabelData->labelUrl))
				$this->setLabel($response->CreationState->LabelData->labelUrl);
			else if(isset($response->LabelData->labelUrl))
				$this->setLabel($response->LabelData->labelUrl);
		}

		// Set Return Label if exists
		if($this->getLabelType() === BusinessShipment::RESPONSE_TYPE_B64) {
			if(isset($response->CreationState->LabelData->returnLabelData))
				$this->setReturnLabel($response->CreationState->LabelData->returnLabelData);
			else if(isset($response->LabelData->returnLabelData))
				$this->setReturnLabel($response->LabelData->returnLabelData);
		} else {
			if(isset($response->CreationState->LabelData->returnLabelUrl))
				$this->setReturnLabel($response->CreationState->LabelData->returnLabelUrl);
			else if(isset($response->LabelData->returnLabelUrl))
				$this->setReturnLabel($response->LabelData->returnLabelUrl);
		}

		// Set Export Label if exists
		if($this->getLabelType() === BusinessShipment::RESPONSE_TYPE_B64) {
			if(isset($response->CreationState->LabelData->exportLabelData))
				$this->setExportDoc($response->CreationState->LabelData->exportLabelData);
			else if(isset($response->ExportDocData->exportDocData))
				$this->setExportDoc($response->ExportDocData->exportDocData);
		} else {
			if(isset($response->CreationState->LabelData->exportLabelUrl))
				$this->setExportDoc($response->CreationState->LabelData->exportLabelUrl);
			else if(isset($response->ExportDocData->exportDocURL))
				$this->setExportDoc($response->ExportDocData->exportDocURL);
		}

		// Set all other System values
		if(isset($response->CreationState->sequenceNumber))
			$this->setSequenceNumber((string) $response->CreationState->sequenceNumber);
		else if(isset($response->ValidationState->sequenceNumber))
			$this->setSequenceNumber((string) $response->ValidationState->sequenceNumber);
	}
}
