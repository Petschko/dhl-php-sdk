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
class DHL_Response {
	/**
	 * Shipment-Number
	 *
	 * @var null|string - Shipment-Number
	 */
	private $shipment_number = null;

	/**
	 * TODO DOCUMENT ME
	 *
	 * @var null|string - TODO DESC
	 */
	private $piece_number = null;

	/**
	 * Label URL
	 *
	 * @var null|string - Label URL
	 */
	private $label_url = null;

	/**
	 * DHL_Response constructor.
	 *
	 * @param null|Object $response - DHL-Response
	 */
	public function __construct($response = null) {
		if($response !== null)
			$this->loadResponse($response);
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		unset($this->shipment_number);
		unset($this->piece_number);
		unset($this->label_url);
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
	public function setShipmentNumber($shipment_number) {
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
	public function setPieceNumber($piece_number) {
		$this->piece_number = $piece_number;
	}

	/**
	 * @return null|string
	 */
	public function getLabelUrl() {
		return $this->label_url;
	}

	/**
	 * @param null|string $label_url
	 */
	public function setLabelUrl($label_url) {
		$this->label_url = $label_url;
	}

	/**
	 * Loads a DHL-Response into this Object
	 *
	 * @param Object $response - DHL-Response
	 */
	private function loadResponse($response) {
		$this->setShipmentNumber((string) $response->CreationState->ShipmentNumber->shipmentNumber);
		$this->setPieceNumber((string) $response->CreationState->PieceInformation->PieceNumber->licensePlate);
		$this->setLabelUrl((string) $response->CreationState->Labelurl);
	}
}
