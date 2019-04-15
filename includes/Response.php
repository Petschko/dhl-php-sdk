<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 18.11.2016
 * Time: 16:00
 * Update: 15.04.2019
 * Version: 1.3.5
 *
 * Notes: Contains the DHL-Response Class, which manages the response that you get with simple getters
 */

/**
 * Class Response
 *
 * @package Petschko\DHL
 */
class Response extends Version implements LabelResponse {
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
	 * Manifest PDF-Data as Base64-String
	 *
	 * @var null|string $manifestData - Manifest PDF-Data as Base64 String or null if not requested
	 */
	private $manifestData = null;

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
	 * Contains all LabelData Objects
	 *
	 * @var LabelData[] - LabelData Object-Array
	 */
	private $labelData = array();

	/**
	 * Response constructor.
	 *
	 * Loads the correct Version and loads the Response if not null into this Object
	 *
	 * @param string $version - Current DHL-Version
	 * @param null|Object $response - DHL-Response or null for none
	 */
	public function __construct($version, $response = null) {
		parent::__construct($version);

		if($response !== null) {
			switch($this->getMayor()) {
				case 1:
					trigger_error('[DHL-PHP-SDK]: Called Version 1 Method ' .__CLASS__ . '->' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);
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
		unset($this->manifestData);
		unset($this->statusCode);
		unset($this->statusText);
		unset($this->statusMessage);
		unset($this->labelData);
	}

	/**
	 * Getter for Shipment-Number
	 *
	 * @return null|string - Shipment-Number or null if not set
	 */
	public function getShipmentNumber() {
		if($this->countLabelData() > 0)
			return $this->getLabelData(0)->getShipmentNumber();

		return null;
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

		return null;
	}

	/**
	 * Getter for Label
	 *
	 * @return null|string - Label URL/Base64-Data (Can also contain the return label) or null if not set
	 */
	public function getLabel() {
		if($this->countLabelData() > 0)
			return $this->getLabelData(0)->getLabel();

		return null;
	}

	/**
	 * Getter for ReturnLabel
	 *
	 * @return null|string - Return Label-URL/Base64-Label-Data or null if not requested/set
	 */
	public function getReturnLabel() {
		if($this->countLabelData() > 0)
			return $this->getLabelData(0)->getReturnLabel();

		return null;
	}

	/**
	 * Getter for Export-Document
	 *
	 * @return null|string - Export-Document Label-URL/Base64-Label-Data or null if not requested/set
	 */
	public function getExportDoc() {
		if($this->countLabelData() > 0)
			return $this->getLabelData(0)->getExportDoc();

		return null;
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
	 * Getter for Sequence-Number
	 *
	 * @return string|null - Sequence-Number of the Request or null if not set
	 */
	public function getSequenceNumber() {
		if($this->countLabelData() > 0)
			return $this->getLabelData(0)->getSequenceNumber();

		return null;
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
	 * Getter for LabelData-Objects
	 *
	 * @param null|int $index - Index of the LabelData-Object or null for the array
	 * @return LabelData[]|LabelData - LabelData-Object(-Array)
	 */
	public function getLabelData($index = null) {
		if($index === null)
			return $this->labelData;
		else
			return $this->labelData[$index];
	}

	/**
	 * Adds a LabelData-Object to the LabelData-Object-Array
	 *
	 * @param LabelData $labelData - LabelData-Object to add
	 */
	private function addLabelData($labelData) {
		$this->labelData[] = $labelData;
	}

	/**
	 * Returns how many LabelData-Objects are in this List
	 *
	 * @return int - LabelData Count
	 */
	public function countLabelData() {
		return count($this->getLabelData());
	}

	/**
	 * Check if the current Status-Code is correct and set the correct one if not
	 */
	private function validateStatusCode() {
		if($this->getStatusCode() === self::DHL_ERROR_NO_ERROR && $this->getStatusText() !== 'ok')
			$this->setStatusCode(self::DHL_ERROR_WEAK_WARNING);

		// Fix the DHL-Error Weak-Warning-Bug
		if($this->countLabelData() === 1) {
			// ALWAYS uses the Shipment-Response when only 1
			$this->setStatusCode($this->getLabelData(0)->getStatusCode());
			$this->setStatusText($this->getLabelData(0)->getStatusText());
			$this->setStatusMessage($this->getLabelData(0)->getStatusMessage());
		} else if($this->getStatusCode() === self::DHL_ERROR_WEAK_WARNING) {
			$noError = true;

			// Search in all shipments if an error/warning exists
			foreach($this->getLabelData() as &$labelData) {
				/**
				 * @var LabelData $labelData
				 */
				if($labelData->getStatusCode() !== self::DHL_ERROR_NO_ERROR) {
					$noError = false;
					break;
				}
			}

			if($noError) {
				$this->setStatusCode(self::DHL_ERROR_NO_ERROR);
				$this->setStatusText('ok');
				$this->setStatusMessage('Der Webservice wurde ohne Fehler ausgeführt.');
			}
		}
	}

	/**
	 * Getter for Cod-Label
	 *
	 * @return null|string - Cod-Label-URL/Base64-Data or null if not requested/set
	 */
	public function getCodLabel() {
		if($this->countLabelData() > 0)
			return $this->getLabelData(0)->getCodLabel();

		return null;
	}

	/**
	 * Handles all Multi-Shipment Object/Arrays and add them to Label-Data
	 *
	 * @param Object|array $possibleMultiLabelObject - Object or array, which should be added to LabelData
	 */
	private function handleMultiShipments($possibleMultiLabelObject) {
		if(is_array($possibleMultiLabelObject)) {
			$multiLabelArray = $possibleMultiLabelObject;

			foreach($multiLabelArray as &$singleLabel)
				$this->addLabelData(new LabelData($this->getVersion(), $singleLabel));
		} else
			$this->addLabelData(new LabelData($this->getVersion(), $possibleMultiLabelObject));
	}

	/**
	 * Loads a DHL-Response into this Object
	 *
	 * @param Object $response - DHL-Response
	 */
	private function loadResponse_v2($response) {
		// Set global Status-Values first
		if(isset($response->Status)) {
			if(isset($response->Status->statusCode))
				$this->setStatusCode((int) $response->Status->statusCode);
			if(isset($response->Status->statusText)) {
				if(is_array($response->Status->statusText))
					$this->setStatusText(implode(';', $response->Status->statusText));
				else
					$this->setStatusText($response->Status->statusText);
			}
			if(isset($response->Status->statusMessage)) {
				if(is_array($response->Status->statusMessage))
					$this->setStatusMessage(implode(';', $response->Status->statusMessage));
				else
					$this->setStatusMessage($response->Status->statusMessage);
			}
		}

		// Set Manifest if exists (getManifest)
		if(isset($response->manifestData)) {
			$this->setManifestData($response->manifestData);

			return;
		}

		/*
		 * Handle Shipment(s) | Calls on:
		 * 1 -> createShipmentOrder
		 * 2 -> deleteShipmentOrder
		 * 3 -> updateShipmentOrder [Only Single]
		 * 3 -> getLabel
		 * 4 -> validateShipment
		 * 5 -> getExportDoc
		 * 6 -> doManifest
		 */
		if(isset($response->CreationState)) // 1
			$this->handleMultiShipments($response->CreationState);
		else if(isset($response->DeletionState)) // 2
			$this->handleMultiShipments($response->DeletionState);
		else if(isset($response->LabelData)) // 3
			$this->handleMultiShipments($response->LabelData);
		else if(isset($response->ValidationState)) // 4
			$this->handleMultiShipments($response->ValidationState);
		else if(isset($response->ExportDocData)) // 5
			$this->handleMultiShipments($response->ExportDocData);
		else if(isset($response->ManifestState)) // 6
			$this->handleMultiShipments($response->ManifestState);

		// Validate the status to fix errors on the Main-Status and show weak-warnings
		if($this->getStatusCode() !== self::DHL_ERROR_NOT_SET)
			$this->validateStatusCode();
	}
}
