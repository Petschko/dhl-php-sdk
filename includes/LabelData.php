<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 02.09.2018
 * Time: 13:13
 * Update: 05.09.2018
 * Version: 1.0.0
 *
 * Notes: Contains the LabelData Class
 */

/**
 * Class LabelData
 *
 * @package Petschko\DHL
 */
class LabelData extends Version implements LabelResponse {
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
	private $statusCode = Response::DHL_ERROR_NOT_SET;

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
	 * Sequence-Number (Useful for AJAX-Requests)
	 *
	 * @var string|null $sequenceNumber - Sequence-Number of the Request | null for none
	 */
	private $sequenceNumber = null;

	/**
	 * Shipment-Number
	 *
	 * @var null|string $shipmentNumber - Shipment-Number | null if not set
	 */
	private $shipmentNumber = null;

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
	 * Cod-Label-URL/Base64-Data
	 *
	 * @var null|string $codLabel - Cod-Label-URL/Base64-Data or null if not requested
	 */
	private $codLabel = null;

	/**
	 * LabelData constructor.
	 *
	 * @param string $version - Current DHL-Version
	 * @param object $labelData - LabelData-Object from DHL-Response
	 */
	public function __construct($version, $labelData) {
		parent::__construct($version);

		if($labelData !== null) {
			switch($this->getMayor()) {
				case 1:
					trigger_error('[DHL-PHP-SDK]: Called Version 1 Method ' .__CLASS__ . '->' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);
					break;
				case 2:
				default:
					$this->loadLabelData_v2($labelData);
			}
		}
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		unset($this->statusCode);
		unset($this->statusText);
		unset($this->statusMessage);
		unset($this->sequenceNumber);
		unset($this->shipmentNumber);
		unset($this->label);
		unset($this->returnLabel);
		unset($this->exportDoc);
		unset($this->codLabel);
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
	 * Getter for Cod-Label
	 *
	 * @return null|string - Cod-Label-URL/Base64-Data or null if not requested/set
	 */
	public function getCodLabel() {
		return $this->codLabel;
	}

	/**
	 * Setter for Cod-Label
	 *
	 * @param null|string $codLabel - Cod-Label-URL/Base64-Data or null if not requested/set
	 */
	private function setCodLabel($codLabel) {
		$this->codLabel = $codLabel;
	}

	/**
	 * Check if the current Status-Code is correct and set the correct one if not
	 */
	private function validateStatusCode() {
		if($this->getStatusCode() === 0 && $this->getStatusText() !== 'ok')
			$this->setStatusCode(Response::DHL_ERROR_WEAK_WARNING);
	}

	/**
	 * Set all Values of the LabelResponse to this Object
	 *
	 * @param Object $response - LabelData-Response
	 */
	private function loadLabelData_v2($response) {
		$labelResponse = $response;
		// Check if the tree is correct (and may reconfigure it)
		if(isset($response->LabelData))
			$labelResponse = $response->LabelData;

		// Get Sequence-Number
		if(isset($response->sequenceNumber))
			$this->setSequenceNumber((string) $response->sequenceNumber);
		else if(isset($labelResponse->sequenceNumber))
			$this->setSequenceNumber((string) $labelResponse->sequenceNumber);

		// Get Status
		if(isset($labelResponse->Status)) {
			if(isset($labelResponse->Status->statusCode))
				$this->setStatusCode((int) $labelResponse->Status->statusCode);
			if(isset($labelResponse->Status->statusText)) {
				if(is_array($labelResponse->Status->statusText))
					$this->setStatusText(implode(';', $labelResponse->Status->statusText));
				else
					$this->setStatusText($labelResponse->Status->statusText);
			}
			if(isset($labelResponse->Status->statusMessage)) {
				if(is_array($labelResponse->Status->statusMessage))
					$this->setStatusMessage(implode(';', $labelResponse->Status->statusMessage));
				else
					$this->setStatusMessage($labelResponse->Status->statusMessage);
			}

			$this->validateStatusCode();
		}

		// Get Shipment-Number
		if(isset($labelResponse->shipmentNumber))
			$this->setShipmentNumber((string) $labelResponse->shipmentNumber);

		// Get Label-Data
		if(isset($labelResponse->labelUrl))
			$this->setLabel($labelResponse->labelUrl);
		else if(isset($labelResponse->labelData))
			$this->setLabel($labelResponse->labelData);

		// Get Return-Label
		if(isset($labelResponse->returnLabelUrl))
			$this->setReturnLabel($labelResponse->returnLabelUrl);
		else if(isset($labelResponse->returnLabelData))
			$this->setReturnLabel($labelResponse->returnLabelData);

		// Get Export-Doc
		if(isset($labelResponse->exportLabelUrl))
			$this->setExportDoc($labelResponse->exportLabelUrl);
		else if(isset($labelResponse->exportLabelData))
			$this->setExportDoc($labelResponse->exportLabelData);
		else if(isset($labelResponse->exportDocURL))
			$this->setExportDoc($labelResponse->exportDocURL);
		else if(isset($labelResponse->exportDocData))
			$this->setExportDoc($labelResponse->exportDocData);

		if(isset($labelResponse->codLabelUrl))
			$this->setCodLabel($labelResponse->codLabelUrl);
		else if(isset($labelResponse->codLabelData))
			$this->setCodLabel($labelResponse->codLabelData);
	}
}
