<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 26.01.2017
 * Time: 15:37
 * Update: 14.07.2018
 * Version: 1.3.1
 *
 * Notes: Contains all Functions/Values for DHL-Business-Shipment
 */

use Exception;
use SoapClient;
use SoapHeader;
use stdClass;

/**
 * Class BusinessShipment
 */
class BusinessShipment extends Version {
	/**
	 * DHL Origin WSDL-Lib-URL
	 */
	const DHL_WSDL_LIB_URL = 'https://cig.dhl.de/cig-wsdls/com/dpdhl/wsdl/geschaeftskundenversand-api/';

	/**
	 * DHL-Soap-Header URL
	 */
	const DHL_SOAP_HEADER_URI = 'http://dhl.de/webservice/cisbase';

	/**
	 * DHL-Sandbox SOAP-URL
	 */
	const DHL_SANDBOX_URL = 'https://cig.dhl.de/services/sandbox/soap';

	/**
	 * DHL-Live SOAP-URL
	 */
	const DHL_PRODUCTION_URL = 'https://cig.dhl.de/services/production/soap';

	/**
	 * Newest-Version
	 */
	const NEWEST_VERSION = '2.2';

	/**
	 * Response-Type URL
	 */
	const RESPONSE_TYPE_URL = 'URL';

	/**
	 * Response-Type Base64
	 */
	const RESPONSE_TYPE_B64 = 'B64';

	// System-Fields
	/**
	 * Contains the Soap Client
	 *
	 * @var SoapClient|null $soapClient - Soap-Client
	 */
	private $soapClient = null;

	/**
	 * Contains the error array
	 *
	 * @var array $errors - Error-Array
	 */
	private $errors = array();

	// Setting-Fields
	/**
	 * Contains if the Object runs in Sandbox-Mode
	 *
	 * @var bool $test - Is Sandbox-Mode
	 */
	private $test;

	/**
	 * Contains if Log is enabled
	 *
	 * @var bool $log - Is Logging enabled
	 */
	private $log = false;

	// Object-Fields
	/**
	 * Contains the Credentials Object
	 *
	 * Notes: Is required every time! Used to login
	 *
	 * @var Credentials $credentials - Credentials Object
	 */
	private $credentials;

	/**
	 * Contains the Shipment Details
	 *
	 * @var ShipmentDetails $shipmentDetails - Shipment Details Object
	 */
	private $shipmentDetails;

	/**
	 * Contains the Service Object (Many settings for the Shipment)
	 *
	 * Note: Optional
	 *
	 * @var Service|null $service - Service Object
	 */
	private $service = null;

	/**
	 * Contains the Bank-Object
	 *
	 * Note: Optional
	 *
	 * @var BankData|null $bank - Bank-Object
	 */
	private $bank = null;

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
	 * @var ReturnReceiver|null $returnReceiver - Return Receiver Object
	 */
	private $returnReceiver = null;

	/**
	 * Contains the Export-Document-Settings Object
	 *
	 * Note: Optional
	 *
	 * @var ExportDocument|null $exportDocument - Export-Document-Settings Object
	 */
	private $exportDocument = null;

	// Fields
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
	 * Contains the Receiver-E-Mail (Used for Notification to the Receiver)
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 70
	 *
	 * @var string|null $receiverEmail - Receiver-E-Mail
	 */
	private $receiverEmail = null;

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
	 * RESPONSE_TYPE_URL -> Url
	 * RESPONSE_TYPE_B64 -> Base64
	 *
	 * @var string|null $labelResponseType - Label-Response-Type (Can use class constance's)
	 */
	private $labelResponseType = null;

	/**
	 * Custom-WSDL-File URL
	 *
	 * @var null|string $customAPIURL - Custom-API URL to use internal let this value null
	 */
	private $customAPIURL = null;

	/**
	 * BusinessShipment constructor.
	 *
	 * @param Credentials $credentials - DHL-Credentials-Object
	 * @param bool $testModus - Uses the Sandbox-Modus or Live (True uses test-Modus)
	 * @param null|string $version - Version to use or null for the newest
	 */
	public function __construct($credentials, $testModus = false, $version = null) {
		// Set Version
		if($version === null)
			$version = self::NEWEST_VERSION;

		parent::__construct($version);

		// Set Test-Modus
		$this->setTest($testModus);

		// Set Credentials
		if($this->isTest()) {
			$c = new Credentials(true);
			$c->setApiUser($credentials->getApiUser());
			$c->setApiPassword($credentials->getApiPassword());

			$credentials = $c;
		}

		$this->setCredentials($credentials);

		// Set Shipment-Class
		$this->setShipmentDetails(new ShipmentDetails($credentials->getEkp(10) . '0101'));
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		parent::__destruct();
		unset($this->soapClient);
		unset($this->errors);
		unset($this->test);
		unset($this->log);
		unset($this->credentials);
		unset($this->shipmentDetails);
		unset($this->service);
		unset($this->bank);
		unset($this->sender);
		unset($this->receiver);
		unset($this->returnReceiver);
		unset($this->exportDocument);
		unset($this->sequenceNumber);
		unset($this->receiverEmail);
		unset($this->printOnlyIfReceiverIsValid);
		unset($this->labelResponseType);
		unset($this->customAPIURL);
	}

	/**
	 * Get the Business-API-URL for this Version
	 *
	 * @return string - Business-API-URL
	 */
	protected function getAPIUrl() {
		// Use own API-URL if set
		if($this->getCustomAPIURL() !== null)
			return $this->getCustomAPIURL();

		return self::DHL_WSDL_LIB_URL . $this->getVersion() . '/geschaeftskundenversand-api-' . $this->getVersion() . '.wsdl';
	}

	/**
	 * @return null|SoapClient
	 */
	private function getSoapClient() {
		if($this->soapClient === null)
			$this->buildSoapClient();

		return $this->soapClient;
	}

	/**
	 * Returns the Last XML-Request or null
	 *
	 * @return null|string - Last XML-Request or null if none
	 */
	public function getLastXML() {
		if($this->soapClient === null)
			return null;

		return $this->getSoapClient()->__getLastRequest();
	}

	/**
	 * @param null|SoapClient $soapClient
	 */
	private function setSoapClient($soapClient) {
		$this->soapClient = $soapClient;
	}

	/**
	 * @return array
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * @param array $errors
	 */
	public function setErrors($errors) {
		$this->errors = $errors;
	}

	/**
	 * @param string $error
	 */
	private function addError($error) {
		$this->errors[] = $error;
	}

	/**
	 * @return bool
	 */
	private function isTest() {
		return $this->test;
	}

	/**
	 * @param bool $test
	 */
	private function setTest($test) {
		$this->test = $test;
	}

	/**
	 * @return bool
	 */
	public function isLog() {
		return $this->log;
	}

	/**
	 * @param bool $log
	 */
	public function setLog($log) {
		$this->log = $log;
	}

	/**
	 * @return Credentials
	 */
	private function getCredentials() {
		return $this->credentials;
	}

	/**
	 * @param Credentials $credentials
	 */
	public function setCredentials($credentials) {
		$this->credentials = $credentials;
	}

	/**
	 * @return ShipmentDetails
	 */
	public function getShipmentDetails() {
		return $this->shipmentDetails;
	}

	/**
	 * @param ShipmentDetails $shipmentDetails
	 */
	public function setShipmentDetails($shipmentDetails) {
		$this->shipmentDetails = $shipmentDetails;
	}

	/**
	 * @return Service|null
	 */
	public function getService() {
		return $this->service;
	}

	/**
	 * @param Service|null $service
	 */
	public function setService($service) {
		$this->service = $service;
	}

	/**
	 * @return BankData|null
	 */
	public function getBank() {
		return $this->bank;
	}

	/**
	 * @param BankData|null $bank
	 */
	public function setBank($bank) {
		$this->bank = $bank;
	}

	/**
	 * @return Sender
	 */
	public function getSender() {
		return $this->sender;
	}

	/**
	 * @param Sender $sender
	 */
	public function setSender($sender) {
		$this->sender = $sender;
	}

	/**
	 * @return Receiver
	 */
	public function getReceiver() {
		return $this->receiver;
	}

	/**
	 * @param Receiver $receiver
	 */
	public function setReceiver($receiver) {
		$this->receiver = $receiver;
	}

	/**
	 * @return ReturnReceiver|null
	 */
	public function getReturnReceiver() {
		return $this->returnReceiver;
	}

	/**
	 * @param ReturnReceiver|null $returnReceiver
	 */
	public function setReturnReceiver($returnReceiver) {
		$this->returnReceiver = $returnReceiver;
	}

	/**
	 * @return ExportDocument|null
	 */
	public function getExportDocument() {
		return $this->exportDocument;
	}

	/**
	 * @param ExportDocument|null $exportDocument
	 */
	public function setExportDocument($exportDocument) {
		$this->exportDocument = $exportDocument;
	}

	/**
	 * @return string
	 */
	public function getSequenceNumber() {
		return $this->sequenceNumber;
	}

	/**
	 * @param string $sequenceNumber
	 */
	public function setSequenceNumber($sequenceNumber) {
		$this->sequenceNumber = $sequenceNumber;
	}

	/**
	 * @return null|string
	 */
	public function getReceiverEmail() {
		return $this->receiverEmail;
	}

	/**
	 * @param null|string $receiverEmail
	 */
	public function setReceiverEmail($receiverEmail) {
		$this->receiverEmail = $receiverEmail;
	}

	/**
	 * @return bool|null
	 */
	public function getPrintOnlyIfReceiverIsValid() {
		return $this->printOnlyIfReceiverIsValid;
	}

	/**
	 * @param bool|null $printOnlyIfReceiverIsValid
	 */
	public function setPrintOnlyIfReceiverIsValid($printOnlyIfReceiverIsValid) {
		$this->printOnlyIfReceiverIsValid = $printOnlyIfReceiverIsValid;
	}

	/**
	 * @return null|string
	 */
	public function getLabelResponseType() {
		return $this->labelResponseType;
	}

	/**
	 * @param null|string $labelResponseType
	 */
	public function setLabelResponseType($labelResponseType) {
		$this->labelResponseType = $labelResponseType;
	}

	/**
	 * @return null|string
	 */
	public function getCustomAPIURL() {
		return $this->customAPIURL;
	}

	/**
	 * @param null|string $customAPIURL
	 */
	public function setCustomAPIURL($customAPIURL) {
		$this->customAPIURL = $customAPIURL;
	}

	/**
	 * Add the Massage to Log if enabled
	 *
	 * @param mixed $message - Message to add to Log
	 */
	private function log($message) {
		if($this->isLog()) {
			if(is_array($message) || is_object($message))
				error_log(print_r($message, true));
			else
				error_log($message);
		}
	}

	/**
	 * Build SOAP-Auth-Header
	 *
	 * @return SoapHeader
	 */
	private function buildAuthHeader() {
		$auth_params = array(
			'user' => $this->getCredentials()->getUser(),
			'signature' => $this->getCredentials()->getSignature(),
			'type' => 0
		);

		return new SoapHeader(self::DHL_SOAP_HEADER_URI, 'Authentification', $auth_params);
	}

	/**
	 * Builds the Soap-Client
	 */
	private function buildSoapClient() {
		$header = $this->buildAuthHeader();

		if($this->isTest())
			$location = self::DHL_SANDBOX_URL;
		else
			$location = self::DHL_PRODUCTION_URL;

		$auth_params = array(
			'login' => $this->getCredentials()->getApiUser(),
			'password' => $this->getCredentials()->getApiPassword(),
			'location' => $location,
			'trace' => 1
		);

		$this->log($auth_params);
		$this->setSoapClient(new SoapClient($this->getAPIUrl(), $auth_params));
		$this->getSoapClient()->__setSoapHeaders($header);
		$this->log($this->getSoapClient());
	}

	/**
	 * Creates the doManifest-Request via SOAP
	 *
	 * @param Object|array $data - Manifest-Data
	 * @return Object - DHL-Response
	 */
	private function sendDoManifestRequest($data) {
		switch($this->getMayor()) {
			case 1:
				return $this->getSoapClient()->DoManifestTD($data); // todo verify if correct
			case 2:
			default:
				return $this->getSoapClient()->doManifest($data);
		}
	}

	/**
	 * Creates the doManifest-Request
	 *
	 * @param string $shipmentNumber - Shipment-Number for Manifest
	 * @return bool|Response - false on error or DHL-Response Object
	 */
	public function doManifest($shipmentNumber) {
		switch($this->getMayor()) {
			case 1:
				$data = $this->createDoManifestClass_v1($shipmentNumber);
				break;
			case 2:
			default:
				$data = $this->createDoManifestClass_v2($shipmentNumber);
		}

		try {
			$response = $this->sendDoManifestRequest($data);
		} catch(Exception $e) {
			$this->addError($e->getMessage());

			return false;
		}

		if(is_soap_fault($response)) {
			$this->addError($response->faultstring);

			return false;
		} else
			return new Response($this->getVersion(), $response);
	}

	/**
	 * Creates the Data-Object for Manifest
	 *
	 * @param string $shipmentNumber - Shipment-Number for the Manifest
	 * @return StdClass - Data-Object
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	private function createDoManifestClass_v1($shipmentNumber) {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		$data = new StdClass;

		// todo implement v1 method

		return $data;
	}

	/**
	 * Creates the Data-Object for Manifest
	 *
	 * @param string $shipmentNumber - Shipment-Number for the Manifest
	 * @return StdClass - Data-Object
	 */
	private function createDoManifestClass_v2($shipmentNumber) {
		$data = new StdClass;

		$data->Version = $this->getVersionClass();
		$data->shipmentNumber = $shipmentNumber;

		return $data;
	}

	/**
	 * Creates the Shipment-Order Request via SOAP
	 *
	 * @param Object|array $data - Shipment-Data
	 * @return Object - DHL-Response
	 */
	private function sendCreateRequest($data) {
		switch($this->getMayor()) {
			case 1:
				return $this->getSoapClient()->CreateShipmentDD($data);
			case 2:
			default:
				return $this->getSoapClient()->createShipmentOrder($data);
		}
	}

	/**
	 * Creates the Shipment-Request
	 *
	 * @return bool|Response - false on error or DHL-Response Object
	 */
	public function createShipment() {
		switch($this->getMayor()) {
			case 1:
				$data = $this->createShipmentClass_v1();
				break;
			case 2:
			default:
				$data = $this->createShipmentClass_v2();
		}

		$response = null;

		// Create Shipment
		try {
			$response = $this->sendCreateRequest($data);
		} catch(Exception $e) {
			$this->addError($e->getMessage());

			return false;
		}

		if(is_soap_fault($response)) {
			$this->addError($response->faultstring);

			return false;
		} else
			return new Response($this->getVersion(), $response, $this->getLabelResponseType());
	}

	/**
	 * Creates the Data-Object for the Request
	 *
	 * @return StdClass - Data-Object
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	private function createShipmentClass_v1() {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		$data = new StdClass;

		// todo implement v1 method

		return $data;
	}

	/**
	 * Creates the Data-Object for the Request
	 *
	 * @return StdClass - Data-Object
	 */
	private function createShipmentClass_v2() {
		$data = new StdClass;
		$data->Version = $this->getVersionClass();
		$data->ShipmentOrder = new StdClass;
		$data->ShipmentOrder->sequenceNumber = $this->getSequenceNumber();

		// Shipment
		$data->ShipmentOrder->Shipment = new StdClass;
		$data->ShipmentOrder->Shipment->ShipmentDetails = $this->getShipmentDetails()->getShipmentDetailsClass_v2();

		// Service
		if($this->getService() !== null)
			$data->ShipmentOrder->Shipment->ShipmentDetails->Service = $this->getService()->getServiceClass_v2($this->getShipmentDetails()->getProduct());

		// Notification
		if($this->getReceiverEmail() !== null) {
			$data->ShipmentOrder->Shipment->ShipmentDetails->Notification = new StdClass;
			$data->ShipmentOrder->Shipment->ShipmentDetails->Notification->recipientEmailAddress = $this->getReceiverEmail();
		}

		// Bank-Data
		if($this->getBank() !== null)
			$data->ShipmentOrder->Shipment->ShipmentDetails->BankData = $this->getBank()->getBankClass_v2();

		// Shipper
		$data->ShipmentOrder->Shipment->Shipper = $this->getSender()->getClass_v2();

		// Receiver
		$data->ShipmentOrder->Shipment->Receiver = $this->getReceiver()->getClass_v2();

		// Return-Receiver
		if($this->getReturnReceiver() !== null)
			$data->ShipmentOrder->Shipment->ReturnReceiver = $this->getReturnReceiver()->getClass_v2();

		// Export-Document
		if($this->getExportDocument() !== null) {
			try {
				$data->ShipmentOrder->Shipment->ExportDocument = $this->getExportDocument()->getExportDocumentClass_v2();
			} catch(Exception $e) {
				$this->addError($e->getMessage());
			}
		}

		// Other Settings
		if($this->getPrintOnlyIfReceiverIsValid() !== null) {
			$data->ShipmentOrder->PrintOnlyIfCodeable = new StdClass;
			$data->ShipmentOrder->PrintOnlyIfCodeable->active = (int) $this->getPrintOnlyIfReceiverIsValid();
		}
		if($this->getLabelResponseType() !== null)
			$data->ShipmentOrder->labelResponseType = $this->getLabelResponseType();

		return $data;
	}

	/**
	 * Creates the Shipment-Order-Delete Request via SOAP
	 *
	 * @param Object|array $data - Delete-Data
	 * @return Object - DHL-Response
	 */
	private function sendDeleteRequest($data) {
		switch($this->getMayor()) {
			case 1:
				return $this->getSoapClient()->DeleteShipmentDD($data);
			case 2:
			default:
				return $this->getSoapClient()->deleteShipmentOrder($data);
		}
	}

	/**
	 * Deletes a Shipment
	 *
	 * @param string $shipmentNumber - Shipment-Number of the Shipment to delete
	 * @return bool|Response - Response
	 */
	public function deleteShipment($shipmentNumber) {
		switch($this->getMayor()) {
			case 1:
				$data = $this->createDeleteClass_v1($shipmentNumber);
				break;
			case 2:
			default:
				$data = $this->createDeleteClass_v2($shipmentNumber);
		}

		try {
			$response = $this->sendDeleteRequest($data);
		} catch(Exception $e) {
			$this->addError($e->getMessage());

			return false;
		}

		if(is_soap_fault($response)) {
			$this->addError($response->faultstring);

			return false;
		} else
			return new Response($this->getVersion(), $response);
	}

	/**
	 * Creates Data-Object for Deletion
	 *
	 * @param string $shipmentNumber - Shipment-Number of the Shipment to delete
	 * @return StdClass - Data-Object
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	private function createDeleteClass_v1($shipmentNumber) {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		$data = new StdClass;

		// todo implement v1 method

		return $data;
	}

	/**
	 * Creates Data-Object for Deletion
	 *
	 * @param string $shipmentNumber - Shipment-Number of the Shipment to delete
	 * @return StdClass - Data-Object
	 */
	private function createDeleteClass_v2($shipmentNumber) {
		$data = new StdClass;

		$data->Version = $this->getVersionClass();
		$data->shipmentNumber = $shipmentNumber;

		return $data;
	}

	/**
	 * Requests a Label again via SOAP
	 *
	 * @param Object $data - Label-Data
	 * @return Object - DHL-Response
	 */
	private function sendGetLabelRequest($data) {
		switch($this->getMayor()) {
			case 1:
				return $this->getSoapClient()->getLabelDD($data);
			case 2:
			default:
				return $this->getSoapClient()->getLabel($data);
		}
	}

	/**
	 * Requests a Shipment-Label again
	 *
	 * @param string $shipmentNumber - Shipment-Number of the Label
	 * @return bool|Response - Response or false on error
	 */
	public function getShipmentLabel($shipmentNumber) {
		switch($this->getMayor()) {
			case 1:
				$data = $this->getLabelClass_v1($shipmentNumber);
				break;
			case 2:
			default:
				$data = $this->getLabelClass_v2($shipmentNumber);
		}

		try {
			$response = $this->sendGetLabelRequest($data);
		} catch(Exception $e) {
			$this->addError($e->getMessage());

			return false;
		}

		if(is_soap_fault($response)) {
			$this->addError($response->faultstring);

			return false;
		} else
			return new Response($this->getVersion(), $response, $this->getLabelResponseType());
	}

	/**
	 * Creates Data-Object for Label-Request
	 *
	 * @param string $shipmentNumber - Number of the Shipment
	 * @return StdClass - Data-Object
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	private function getLabelClass_v1($shipmentNumber) {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		$data = new StdClass;

		// todo implement v1 method

		return $data;
	}

	/**
	 * Creates Data-Object for Label-Request
	 *
	 * @param string $shipmentNumber - Number of the Shipment
	 * @return StdClass - Data-Object
	 */
	private function getLabelClass_v2($shipmentNumber) {
		$data = new StdClass;

		$data->Version = $this->getVersionClass();
		$data->shipmentNumber = $shipmentNumber;
		if($this->getLabelResponseType() !== null)
			$data->labelResponseType = $this->getLabelResponseType();

		return $data;
	}

	/**
	 * Requests the Export-Document again via SOAP
	 *
	 * @param Object $data - Export-Doc-Data
	 * @return Object - DHL-Response
	 */
	private function sendGetExportDocRequest($data) {
		switch($this->getMayor()) {
			case 1:
				return $this->getSoapClient()->getExportDocDD($data);
			case 2:
			default:
				return $this->getSoapClient()->getExportDoc($data);
		}
	}

	/**
	 * Requests a Export-Document again
	 *
	 * @param string $shipmentNumber - Shipment-Number of the Export-Document
	 * @return bool|Response - Response or false on error
	 */
	public function getExportDoc($shipmentNumber) {
		switch($this->getMayor()) {
			case 1:
				$data = $this->getExportDocClass_v1($shipmentNumber);
				break;
			case 2:
			default:
				$data = $this->getExportDocClass_v2($shipmentNumber);
		}

		try {
			$response = $this->sendGetExportDocRequest($data);
		} catch(Exception $e) {
			$this->addError($e->getMessage());

			return false;
		}

		if(is_soap_fault($response)) {
			$this->addError($response->faultstring);

			return false;
		} else
			return new Response($this->getVersion(), $response);
	}

	/**
	 * Creates Data-Object for Export-Document-Request
	 *
	 * @param string $shipmentNumber - Number of the Shipment
	 * @return StdClass - Data-Object
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	private function getExportDocClass_v1($shipmentNumber) {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		$data = new StdClass;

		// todo implement v1 method

		return $data;
	}

	/**
	 * Creates Data-Object for Export-Document-Request
	 *
	 * @param string $shipmentNumber - Number of the Shipment
	 * @return StdClass - Data-Object
	 */
	private function getExportDocClass_v2($shipmentNumber) {
		$data = new StdClass;

		$data->Version = $this->getVersionClass();
		$data->shipmentNumber = $shipmentNumber;
		if($this->getLabelResponseType() !== null)
			$data->exportDocResponseType = $this->getLabelResponseType();

		return $data;
	}

	/**
	 * Validates a Shipment
	 *
	 * @return bool|Response - Response or false on error
	 */
	public function validateShipment() {
		switch($this->getMayor()) {
			case 1:
				$data = null;
				break;
			case 2:
			default:
				$data = $this->createShipmentClass_v2();
		}

		try {
			$response = $this->sendValidateShipmentRequest($data);
		} catch(Exception $e) {
			$this->addError($e->getMessage());

			return false;
		}

		if(is_soap_fault($response)) {
			$this->addError($response->faultstring);

			return false;
		} else
			return new Response($this->getVersion(), $response);
	}

	/**
	 * Requests the Validation of a Shipment via SOAP
	 *
	 * @param Object|array $data - Shipment-Data
	 * @return Object - DHL-Response
	 * @throws Exception - Method doesn't exists for Version
	 */
	private function sendValidateShipmentRequest($data) {
		switch($this->getMayor()) {
			case 1:
				throw new Exception(__FUNCTION__ . ': Method doesn\'t exists for Version 1!');
			case 2:
			default:
				return $this->getSoapClient()->validateShipment($data);
		}
	}
}
