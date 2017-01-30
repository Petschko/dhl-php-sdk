<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
 * Authors-Website: http://petschko.org/
 * Date: 18.11.2016
 * Time: 16:00
 * Update: -
 * Version: 0.0.1
 *
 * Notes: -
 */

/**
 * Class DHL_Response
 */
class DHL_Response extends DHL_Version {
	/**
	 * Contains Status-Code-Values
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
	 * @var null|string $shipment_number - Shipment-Number
	 */
	private $shipment_number = null;

	/**
	 * TODO DOCUMENT ME
	 *
	 * Note: Just used in v1
	 *
	 * @var null|string $piece_number
	 */
	private $piece_number = null;

	/**
	 * Label URL/Base64-Data
	 *
	 * @var null|string $label - Label URL or Base64-Data
	 */
	private $label = null;

	/**
	 * Return Label URL/Base64-Data
	 *
	 * @var null|string $returnLabel - Return Label URL/Base64-Data or null if not requested
	 */
	private $returnLabel = null;

	/**
	 * Label-Response-Type (Base64 or URL)
	 *
	 * @var null|string $labelType - Label-Response-Type
	 */
	private $labelType;

	/**
	 * Sequence-Number
	 *
	 * @var string|null $sequenceNumber - Sequence-Number of the Request (Useful for AJAX-Requests)
	 */
	private $sequenceNumber = null;

	/**
	 * Contains the Status-Code
	 *
	 * @var int $statusCode - Status-Code see DHL_ERROR_* Constance's
	 */
	private $statusCode = self::DHL_ERROR_NOT_SET;

	/**
	 * Contains the Status-Text
	 *
	 * @var string|null $statusText - Status-Text
	 */
	private $statusText = null;

	/**
	 * Contains the Status-Message (Mostly more detailed, but longer)
	 *
	 * @var string|null $statusMessage - Status-Message
	 */
	private $statusMessage = null;

	/**
	 * DHL_Response constructor.
	 *
	 * @param string $version - Current DHL-Version
	 * @param null|Object $response - DHL-Response
	 * @param null|string $labelType - Label-Response-Type
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
		unset($this->shipment_number);
		unset($this->piece_number);
		unset($this->label);
		unset($this->returnLabel);
		unset($this->labelType);
		unset($this->sequenceNumber);
		unset($this->statusCode);
		unset($this->statusText);
		unset($this->statusMessage);
	}

	/**
	 * @return null|string
	 */
	public function getShipmentNumber() {
		return $this->shipment_number;
	}

	/**
	 * @param null|string $shipment_number
	 */
	private function setShipmentNumber($shipment_number) {
		$this->shipment_number = $shipment_number;
	}

	/**
	 * @return null|string
	 */
	public function getPieceNumber() {
		return $this->piece_number;
	}

	/**
	 * @param null|string $piece_number
	 */
	private function setPieceNumber($piece_number) {
		$this->piece_number = $piece_number;
	}

	/**
	 * @return null|string
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @param null|string $label
	 */
	private function setLabel($label) {
		$this->label = $label;
	}

	/**
	 * @return null|string
	 */
	public function getReturnLabel() {
		return $this->returnLabel;
	}

	/**
	 * @param null|string $returnLabel
	 */
	private function setReturnLabel($returnLabel) {
		$this->returnLabel = $returnLabel;
	}

	/**
	 * @return null|string
	 */
	private function getLabelType() {
		return $this->labelType;
	}

	/**
	 * @param null|string $labelType
	 */
	private function setLabelType($labelType) {
		$this->labelType = $labelType;
	}

	/**
	 * @return string|null
	 */
	public function getSequenceNumber() {
		return $this->sequenceNumber;
	}

	/**
	 * @param string|null $sequenceNumber
	 */
	private function setSequenceNumber($sequenceNumber) {
		$this->sequenceNumber = $sequenceNumber;
	}

	/**
	 * @return int
	 */
	public function getStatusCode() {
		return $this->statusCode;
	}

	/**
	 * @param int $statusCode
	 */
	private function setStatusCode($statusCode) {
		$this->statusCode = $statusCode;
	}

	/**
	 * @return string|null
	 */
	public function getStatusText() {
		return $this->statusText;
	}

	/**
	 * @param string|null $statusText
	 */
	private function setStatusText($statusText) {
		$this->statusText = $statusText;
	}

	/**
	 * @return string|null
	 */
	public function getStatusMessage() {
		return $this->statusMessage;
	}

	/**
	 * @param string|null $statusMessage
	 */
	private function setStatusMessage($statusMessage) {
		$this->statusMessage = $statusMessage;
	}

	/**
	 * Loads a DHL-Response into this Object
	 *
	 * @param Object $response - DHL-Response
	 */
	private function loadResponse_v1($response) {
		// Set Shipment-Number if exists
		if(isset($response->CreationState->ShipmentNumber->shipmentNumber))
			$this->setShipmentNumber((string) $response->CreationState->ShipmentNumber->shipmentNumber);

		if(isset($response->CreationState->PieceInformation->PieceNumber->licensePlate))
			$this->setPieceNumber((string) $response->CreationState->PieceInformation->PieceNumber->licensePlate);

		// Set Label if exists
		if($this->getLabelType() === DHL_BusinessShipment::RESPONSE_TYPE_B64) {
			if(isset($response->CreationState->Labeldata)) // todo: is valid???
				$this->setLabel($response->CreationState->Labeldata);
		} else if(isset($response->CreationState->Labelurl))
			$this->setLabel($response->CreationState->Labelurl);

		$this->setStatusCode((int) $response->status->StatusCode);
		$this->setStatusMessage($response->status->StatusMessage);
		//todo add more from v1
	}

	/**
	 * Loads a DHL-Response into this Object
	 *
	 * @param Object $response - DHL-Response
	 */
	private function loadResponse_v2($response) {
		// Set Shipment-Number if exists
		if(isset($response->CreationState->LabelData->shipmentNumber))
			$this->setShipmentNumber((string) $response->CreationState->LabelData->shipmentNumber);

		// Set Label if exists
		if($this->getLabelType() === DHL_BusinessShipment::RESPONSE_TYPE_B64) {
			if(isset($response->CreationState->LabelData->labelData))
				$this->setLabel($response->CreationState->LabelData->labelData);
		} else if(isset($response->CreationState->LabelData->labelUrl))
			$this->setLabel($response->CreationState->LabelData->labelUrl);

		// Set Return Label if exists
		if(isset($response->CreationState->LabelData->returnLabelUrl))
			$this->setReturnLabel($response->CreationState->LabelData->returnLabelUrl);
		else if(isset($response->CreationState->LabelData->returnLabelData))
			$this->setReturnLabel($response->CreationState->LabelData->returnLabelData);

		// Set all other System values
		$this->setSequenceNumber((string) $response->CreationState->sequenceNumber);
		$this->setStatusCode((int) $response->CreationState->LabelData->Status->statusCode);
		$this->setStatusText($response->CreationState->LabelData->Status->statusText);
		$this->setStatusMessage($response->CreationState->LabelData->Status->statusMessage);

		// Change Status-Code if a weak-validation error occurs
		if($this->getStatusCode() === 0 && $this->getStatusText() !== 'ok')
			$this->setStatusCode(self::DHL_ERROR_WEAK_WARNING);
	}

	/**
	 * Returns null
	 *
	 * This function is not used here!
	 *
	 * @return null
	 */
	protected final function getAPIUrl() {
		// VOID - unused here
		return null;
	}
}
