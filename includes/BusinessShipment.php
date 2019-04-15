<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 26.01.2017
 * Time: 15:37
 * Update: 15.04.2019
 * Version: 1.7.1
 *
 * Notes: Contains all Functions/Values for DHL-Business-Shipment
 */

use Exception;
use SoapClient;
use SoapHeader;
use stdClass;

/**
 * Class BusinessShipment
 *
 * @package Petschko\DHL
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

	/**
	 * Maximum requests to DHL in one call
	 */
	const MAX_DHL_REQUESTS = 30;

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
	 * @var string[] $errors - Error-Array
	 */
	private $errors = array();

	// Setting-Fields
	/**
	 * Contains if the Object runs in Sandbox-Mode
	 *
	 * @var bool $test - Is Sandbox-Mode
	 */
	private $test;

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
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	private $shipmentDetails;

	/**
	 * Contains the Service Object (Many settings for the Shipment)
	 *
	 * Note: Optional
	 *
	 * @var Service|null $service - Service Object | null for none
	 *
	 * @deprecated - These details belong to the `ShipmentDetails` Object, please do them there
	 */
	private $service = null;

	/**
	 * Contains the Bank-Object
	 *
	 * Note: Optional
	 *
	 * @var BankData|null $bank - Bank-Object | null for none
	 *
	 * @deprecated - These details belong to the `ShipmentDetails` Object, please do them there
	 */
	private $bank = null;

	/**
	 * Contains the Sender-Object
	 *
	 * @var Sender|null $sender - Sender Object
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	private $sender = null;

	/**
	 * Contains the Receiver-Object
	 *
	 * @var Receiver|PackStation|Filial|null $receiver - Receiver Object
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	private $receiver = null;

	/**
	 * Contains the Return Receiver Object
	 *
	 * Note: Optional
	 *
	 * @var ReturnReceiver|null $returnReceiver - Return Receiver Object | null for none
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	private $returnReceiver = null;

	/**
	 * Contains the Export-Document-Settings Object
	 *
	 * Note: Optional
	 *
	 * @var ExportDocument|null $exportDocument - Export-Document-Settings Object | null for none
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
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
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	private $sequenceNumber = '1';

	/**
	 * Contains the Receiver-E-Mail (Used for Notification to the Receiver)
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 70
	 *
	 * @var string|null $receiverEmail - Receiver-E-Mail | null for none
	 *
	 * @deprecated - Moved Receiver E-Mail to correct Class (Shipment-Details)
	 */
	private $receiverEmail = null;

	/**
	 * Contains if the label will be only be printable, if the receiver address is valid.
	 *
	 * Note: Optional
	 *
	 * @var bool|null $printOnlyIfReceiverIsValid - true will only print if receiver address is valid else false (null uses default)
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
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
	 * @var string|null $labelResponseType - Label-Response-Type (Can use class constance's) (null uses default)
	 */
	private $labelResponseType = null;

	/**
	 * Contains all Shipment-Orders
	 *
	 * Note: Can be up to 30 Shipment-Orders
	 *
	 * @var ShipmentOrder[] $shipmentOrders - Contains ShipmentOrder Objects
	 */
	private $shipmentOrders = array();

	/**
	 * Custom-WSDL-File URL
	 *
	 * @var null|string $customAPIURL - Custom-API URL (null uses default from DHL)
	 */
	private $customAPIURL = null;

	/**
	 * BusinessShipment constructor.
	 *
	 * @param Credentials $credentials - DHL-Credentials-Object
	 * @param bool|string $testMode - Use a specific Sandbox-Mode or Production-Mode
	 * 					Test-Mode (Normal): Credentials::TEST_NORMAL, 'test', true
	 * 					Test-Mode (Thermo-Printer): Credentials::TEST_THERMO_PRINTER, 'thermo'
	 * 					Live (No-Test-Mode): false - default
	 * @param null|string $version - Version to use or null for the newest
	 */
	public function __construct($credentials, $testMode = false, $version = null) {
		// Set Version
		if($version === null)
			$version = self::NEWEST_VERSION;

		parent::__construct($version);

		// Set Test-Mode
		$this->setTest((($testMode) ? true : false));

		// Set Credentials
		if($this->isTest()) {
			$c = new Credentials($testMode);
			$c->setApiUser($credentials->getApiUser());
			$c->setApiPassword($credentials->getApiPassword());

			$credentials = $c;
		}

		$this->setCredentials($credentials);

		// @deprecated Set Shipment-Class for Backward-Compatibility todo remove in newer versions
		$this->shipmentDetails = new ShipmentDetails($credentials->getEkp(10) . '0101');
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		parent::__destruct();
		unset($this->soapClient);
		unset($this->errors);
		unset($this->test);
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
		unset($this->shipmentOrders);
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
	 * Get the Soap-Client if exists
	 *
	 * @return null|SoapClient - SoapClient or null on error
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
	 * Returns the last XML-Response from DHL or null
	 *
	 * @return null|string - Last XML-Response from DHL or null if none
	 */
	public function getLastDhlXMLResponse() {
		if($this->soapClient === null)
			return null;

		return $this->getSoapClient()->__getLastResponse();
	}

	/**
	 * Set the Soap-Client
	 *
	 * @param null|SoapClient $soapClient - Soap-Client
	 */
	private function setSoapClient($soapClient) {
		$this->soapClient = $soapClient;
	}

	/**
	 * Get Error-Array
	 *
	 * @return string[] - Error-Array
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * Set Error-Array
	 *
	 * @param string[] $errors - Error-Array
	 */
	public function setErrors($errors) {
		$this->errors = $errors;
	}

	/**
	 * Adds an Error to the Error-Array
	 *
	 * @param string $error - Error-Message
	 */
	private function addError($error) {
		$this->errors[] = $error;
	}

	/**
	 * Returns if this instance run in Test-Mode / Sandbox-Mode
	 *
	 * @return bool - Runs in Test-Mode / Sandbox-Mode
	 */
	private function isTest() {
		return $this->test;
	}

	/**
	 * Set if this instance runs in Test-Mode / Sandbox-Mode
	 *
	 * @param bool $test - Runs in Test-Mode / Sandbox-Mode
	 */
	private function setTest($test) {
		$this->test = $test;
	}

	/**
	 * Returns if log is enabled
	 *
	 * @return bool - Log enabled
	 *
	 * @deprecated - Removed Log-Function
	 */
	public function isLog() {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ . ' Logging has been removed',
			E_USER_DEPRECATED
		);

		return false;
	}

	/**
	 * Set if log enabled
	 *
	 * @param bool $log - Enable log
	 *
	 * @deprecated - Removed Log-Function
	 */
	public function setLog($log) {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ . ' Logging has been removed',
			E_USER_DEPRECATED
		);
	}

	/**
	 * Get Credentials-Object
	 *
	 * @return Credentials - Credentials-Object
	 */
	private function getCredentials() {
		return $this->credentials;
	}

	/**
	 * Set Credentials-Object
	 *
	 * @param Credentials $credentials - Credentials-Object
	 */
	public function setCredentials($credentials) {
		$this->credentials = $credentials;
	}

	/**
	 * Get Shipment-Details-Object
	 *
	 * @return ShipmentDetails - Shipment-Details-Object
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	public function getShipmentDetails() {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentOrder` Object, please do/get them there and assign the' .
			' `ShipmentOrder` Object to this Object by using `addShipmentOrder($shipmentOrder)` on this instance!',
			E_USER_DEPRECATED
		);

		return $this->shipmentDetails;
	}

	/**
	 * Set Shipment-Details-Object
	 *
	 * @param ShipmentDetails $shipmentDetails - Shipment-Details-Object
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	public function setShipmentDetails($shipmentDetails) {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentOrder` Object, please do/get them there and assign the' .
			' `ShipmentOrder` Object to this Object by using `addShipmentOrder($shipmentOrder)` on this instance!',
			E_USER_DEPRECATED
		);

		$this->shipmentDetails = $shipmentDetails;
	}

	/**
	 * Get the Service-Object
	 *
	 * @return Service|null - Service-Object or null if none
	 *
	 * @deprecated - These details belong to the `ShipmentDetails` Object, please do them there
	 */
	public function getService() {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentDetails` Object, please do/get them there and assign the' .
			' `ShipmentDetails` Object to the `ShipmentOrder` Object by using `setShipmentDetails($shipmentDetails)`' .
			' on the Shipment instance!',
			E_USER_DEPRECATED
		);

		return $this->service;
	}

	/**
	 * Set the Service-Object
	 *
	 * @param Service|null $service - Service-Object or null for none
	 *
	 * @deprecated - These details belong to the `ShipmentDetails` Object, please do them there
	 */
	public function setService($service) {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentDetails` Object, please do/get them there and assign the' .
			' `ShipmentDetails` Object to the `ShipmentOrder` Object by using `setShipmentDetails($shipmentDetails)`' .
			' on the Shipment instance!',
			E_USER_DEPRECATED
		);

		$this->service = $service;
	}

	/**
	 * Get the Bank-Object
	 *
	 * @return BankData|null - Bank-Object or null if none
	 *
	 * @deprecated - These details belong to the `ShipmentDetails` Object, please do them there
	 */
	public function getBank() {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentDetails` Object, please do/get them there and assign the' .
			' `ShipmentDetails` Object to the `ShipmentOrder` Object by using `setShipmentDetails($shipmentDetails)`' .
			' on the Shipment instance!',
			E_USER_DEPRECATED
		);

		return $this->bank;
	}

	/**
	 * Set the Bank-Object
	 *
	 * @param BankData|null $bank - Bank-Object or null for none
	 *
	 * @deprecated - These details belong to the `ShipmentDetails` Object, please do them there
	 */
	public function setBank($bank) {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentDetails` Object, please do/get them there and assign the' .
			' `ShipmentDetails` Object to the `ShipmentOrder` Object by using `setShipmentDetails($shipmentDetails)`' .
			' on the Shipment instance!',
			E_USER_DEPRECATED
		);

		$this->bank = $bank;
	}

	/**
	 * Get the Sender-Object
	 *
	 * @return Sender|null - Sender-Object or null if none
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	public function getSender() {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentOrder` Object, please do/get them there and assign the' .
			' `ShipmentOrder` Object to this Object by using `addShipmentOrder($shipmentOrder)` on this instance!',
			E_USER_DEPRECATED
		);

		return $this->sender;
	}

	/**
	 * Set the Sender-Object
	 *
	 * @param Sender|null $sender - Sender-Object or null if none
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	public function setSender($sender) {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentOrder` Object, please do/get them there and assign the' .
			' `ShipmentOrder` Object to this Object by using `addShipmentOrder($shipmentOrder)` on this instance!',
			E_USER_DEPRECATED
		);

		$this->sender = $sender;
	}

	/**
	 * Get the Receiver-Object
	 *
	 * @return Receiver|PackStation|Filial|null - Receiver-Object or null if none
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	public function getReceiver() {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentOrder` Object, please do/get them there and assign the' .
			' `ShipmentOrder` Object to this Object by using `addShipmentOrder($shipmentOrder)` on this instance!',
			E_USER_DEPRECATED
		);

		return $this->receiver;
	}

	/**
	 * Set the Receiver-Object
	 *
	 * @param Receiver|PackStation|Filial|null $receiver - Receiver-Object or null if none
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	public function setReceiver($receiver) {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentOrder` Object, please do/get them there and assign the' .
			' `ShipmentOrder` Object to this Object by using `addShipmentOrder($shipmentOrder)` on this instance!',
			E_USER_DEPRECATED
		);

		$this->receiver = $receiver;
	}

	/**
	 * Get the ReturnReceiver-Object
	 *
	 * Usually only used for Re-Tour (In most cases the same Address like the Sender)
	 *
	 * @return ReturnReceiver|null - ReturnReceiver-Object or null if none
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	public function getReturnReceiver() {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentOrder` Object, please do/get them there and assign the' .
			' `ShipmentOrder` Object to this Object by using `addShipmentOrder($shipmentOrder)` on this instance!',
			E_USER_DEPRECATED
		);

		return $this->returnReceiver;
	}

	/**
	 * Set the ReturnReceiver-Object
	 *
	 * Usually only used for Re-Tour (In most cases the same Address like the Sender)
	 *
	 * @param ReturnReceiver|null $returnReceiver - ReturnReceiver-Object or null for none
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	public function setReturnReceiver($returnReceiver) {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentOrder` Object, please do/get them there and assign the' .
			' `ShipmentOrder` Object to this Object by using `addShipmentOrder($shipmentOrder)` on this instance!',
			E_USER_DEPRECATED
		);

		$this->returnReceiver = $returnReceiver;
	}

	/**
	 * Get the ExportDocument-Object
	 *
	 * @return ExportDocument|null - ExportDocument-Object or null if none
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	public function getExportDocument() {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentOrder` Object, please do/get them there and assign the' .
			' `ShipmentOrder` Object to this Object by using `addShipmentOrder($shipmentOrder)` on this instance!',
			E_USER_DEPRECATED
		);

		return $this->exportDocument;
	}

	/**
	 * Set the ExportDocument-Object
	 *
	 * @param ExportDocument|null $exportDocument - ExportDocument-Object or null for none
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	public function setExportDocument($exportDocument) {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentOrder` Object, please do/get them there and assign the' .
			' `ShipmentOrder` Object to this Object by using `addShipmentOrder($shipmentOrder)` on this instance!',
			E_USER_DEPRECATED
		);

		$this->exportDocument = $exportDocument;
	}

	/**
	 * Get the Sequence-Number
	 *
	 * @return string - Sequence-Number
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	public function getSequenceNumber() {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentOrder` Object, please do/get them there and assign the' .
			' `ShipmentOrder` Object to this Object by using `addShipmentOrder($shipmentOrder)` on this instance!',
			E_USER_DEPRECATED
		);

		return $this->sequenceNumber;
	}

	/**
	 * Set the Sequence-Number
	 *
	 * @param string $sequenceNumber - sequence-Number
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	public function setSequenceNumber($sequenceNumber) {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentOrder` Object, please do/get them there and assign the' .
			' `ShipmentOrder` Object to this Object by using `addShipmentOrder($shipmentOrder)` on this instance!',
			E_USER_DEPRECATED
		);

		$this->sequenceNumber = $sequenceNumber;
	}

	/**
	 * Get the Receiver-Email
	 *
	 * @return null|string - Receiver-Email or null if none
	 *
	 * @deprecated - Moved Receiver E-Mail to correct Class (Shipment-Details)
	 */
	public function getReceiverEmail() {
		trigger_error('[DHL-PHP-SDK]: Called deprecated method ' . __METHOD__ . ' in class ' . __CLASS__ .
			'. The notification E-Mail (or receiver E-Mail) was moved into the ShipmentDetail class!' .
			' Please use the new function, this here will removed in the future!', E_USER_DEPRECATED);

		return $this->receiverEmail;
	}

	/**
	 * Set the Receiver-Email
	 *
	 * @param null|string $receiverEmail - Receiver-Email or null for none
	 *
	 * @deprecated - Moved Receiver E-Mail to correct Class (Shipment-Details)
	 */
	public function setReceiverEmail($receiverEmail) {
		trigger_error('[DHL-PHP-SDK]: Called deprecated method ' . __METHOD__ . ' in class ' . __CLASS__ .
			'. The notification E-Mail (or receiver E-Mail) was moved into the ShipmentDetail class!' .
			' Please use the new function, this here will removed in the future!', E_USER_DEPRECATED);

		$this->receiverEmail = $receiverEmail;
	}

	/**
	 * Get if the label should only printed if the Receiver-Address is valid
	 *
	 * @return bool|null - Should the label only printed on a valid Address | null means DHL-Default
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	public function getPrintOnlyIfReceiverIsValid() {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentOrder` Object, please do/get them there and assign the' .
			' `ShipmentOrder` Object to this Object by using `addShipmentOrder($shipmentOrder)` on this instance!',
			E_USER_DEPRECATED
		);

		return $this->printOnlyIfReceiverIsValid;
	}

	/**
	 * Set if the label should only printed if the Receiver-Address is valid
	 *
	 * WARNING: The Address-Validation can fail sometimes also on existing Addresses (for example new streets) use with care!
	 *
	 * @param bool|null $printOnlyIfReceiverIsValid - Should the label only printed on a valid Address | null uses default from DHL
	 *
	 * @deprecated - These details belong to the `ShipmentOrder` Object, please do them there
	 */
	public function setPrintOnlyIfReceiverIsValid($printOnlyIfReceiverIsValid) {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' These details belong to the `ShipmentOrder` Object, please do/get them there and assign the' .
			' `ShipmentOrder` Object to this Object by using `addShipmentOrder($shipmentOrder)` on this instance!',
			E_USER_DEPRECATED
		);

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
	 * Get the list with all Shipment-Orders Objects
	 *
	 * @return ShipmentOrder[] - List with all Shipment-Orders Objects
	 */
	public function getShipmentOrders() {
		return $this->shipmentOrders;
	}

	/**
	 * Set the list with all Shipment-Orders Objects
	 *
	 * @param ShipmentOrder[]|ShipmentOrder $shipmentOrders - Shipment-Order Object-Array or a Single Shipment-Order Object
	 */
	public function setShipmentOrders($shipmentOrders) {
		if(! is_array($shipmentOrders)) {
			trigger_error(
				'[DHL-PHP-SDK]: The type of $shipmentOrders is NOT an array, but is required to set as array! Called method ' .
				__METHOD__ . ' in class ' . __CLASS__,
				E_USER_ERROR
			);
			$this->addError(__METHOD__ . ': Non-Array value given');

			return;
		}

		$this->shipmentOrders = $shipmentOrders;
	}

	/**
	 * Adds a Shipment-Order to the List
	 *
	 * @param ShipmentOrder $shipmentOrder - Shipment-Order to add
	 */
	public function addShipmentOrder($shipmentOrder) {
		$this->shipmentOrders[] = $shipmentOrder;
	}

	/**
	 * Clears the Shipment-Order list
	 */
	public function clearShipmentOrders() {
		$this->setShipmentOrders(array());
	}

	/**
	 * Returns how many Shipment-Orders are in this List
	 *
	 * @return int - ShipmentOrder Count
	 */
	public function countShipmentOrders() {
		return count($this->getShipmentOrders());
	}

	/**
	 * Get the Custom-API-URL
	 *
	 * @return null|string - Custom-API-URL or null for none
	 */
	public function getCustomAPIURL() {
		return $this->customAPIURL;
	}

	/**
	 * Set the Custom-API-URL
	 *
	 * @param null|string $customAPIURL - Custom-API-URL or null for none
	 */
	public function setCustomAPIURL($customAPIURL) {
		$this->customAPIURL = $customAPIURL;
	}

	/**
	 * Check if the request-Array is to long
	 *
	 * @param array $array - Array to check
	 * @param string $action - Action of the request
	 * @param int $maxReq - Maximum-Requests - Default: self::MAX_DHL_REQUESTS
	 */
	private function checkRequestCount($array, $action, $maxReq = self::MAX_DHL_REQUESTS) {
		$count = count($array);

		if($count > self::MAX_DHL_REQUESTS)
			$this->addError('There are only ' . $maxReq . ' Request/s for one call allowed for the action "'
				. $action . '"! You tried to request ' . $count . ' ones');
	}

	/**
	 * Build SOAP-Auth-Header
	 *
	 * @return SoapHeader - Soap-Auth-Header
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

		$this->setSoapClient(new SoapClient($this->getAPIUrl(), $auth_params));
		$this->getSoapClient()->__setSoapHeaders($header);
	}

	/**
	 * Gets the current (local)-Version or Request it via SOAP from DHL
	 *
	 * @param bool $viaSOAP - Request the Version from DHL (Default: false - get local-version as string)
	 * @param bool $getBuildNumber - Return the Build number as well (String look then like this: 2.2.12) Only possible via SOAP - Default false
	 * @param bool $returnAsArray - Return the Version as Array - Default: false
	 * @return bool|array|string - Returns the Version as String|array or false on error
	 */
	public function getVersion($viaSOAP = false, $getBuildNumber = false, $returnAsArray = false) {
		if(! $viaSOAP) {
			if($returnAsArray)
				return array(
					'mayor' => parent::getMayor(),
					'minor' => parent::getMinor()
				);
			else
				return parent::getVersion();
		}

		switch($this->getMayor()) {
			case 1:
				trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);
				$this->addError('Version 1 SOAP-Method "' . __METHOD__ . '" is not implemented or removed!');

				return false;
			case 2:
			default:
				$data = $this->getVersionClass();
		}

		try {
			$response = $this->sendGetVersionRequest($data);
		} catch(Exception $e) {
			$this->addError($e->getMessage());

			return false;
		}

		if(is_soap_fault($response)) {
			$this->addError($response->faultstring);

			return false;
		} else {
			if($returnAsArray)
				return array(
					'mayor' => $response->Version->majorRelease,
					'minor' => $response->Version->minorRelease,
					'build' => $response->Version->build
				);
			else
				return $response->Version->majorRelease . '.' . $response->Version->minorRelease .
					(($getBuildNumber) ? '.' . $response->Version->build : '');
		}
	}

	/**
	 * Creates the getVersion-Request via SOAP
	 *
	 * @param Object|array $data - Version-Data
	 * @return Object - DHL-Response
	 */
	private function sendGetVersionRequest($data) {
		return $this->getSoapClient()->getVersion($data);
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
				return $this->getSoapClient()->DoManifestTD($data);
			case 2:
			default:
				return $this->getSoapClient()->doManifest($data);
		}
	}

	/**
	 * Creates the doManifest-Request
	 *
	 * @param string|string[] $shipmentNumbers - Shipment-Number(s) for Manifest (up to 30 Numbers)
	 * @return bool|Response - false on error or DHL-Response Object
	 */
	public function doManifest($shipmentNumbers) {
		switch($this->getMayor()) {
			case 1:
				$data = $this->createDoManifestClass_v1($shipmentNumbers);
				break;
			case 2:
			default:
				$data = $this->createDoManifestClass_v2($shipmentNumbers);
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
	 * @param string|string[] $shipmentNumbers - Shipment-Number(s) for the Manifest (up to 30 Numbers)
	 * @return StdClass - Data-Object
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	private function createDoManifestClass_v1($shipmentNumbers) {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		$data = new StdClass;

		return $data;
	}

	/**
	 * Creates the Data-Object for Manifest
	 *
	 * @param string|string[] $shipmentNumbers - Shipment-Number(s) for the Manifest (up to 30 Numbers)
	 * @return StdClass - Data-Object
	 */
	private function createDoManifestClass_v2($shipmentNumbers) {
		$data = new StdClass;

		$data->Version = $this->getVersionClass();

		if(is_array($shipmentNumbers)) {
			$this->checkRequestCount($shipmentNumbers, 'doManifest');

			foreach($shipmentNumbers as $key => &$number)
				$data->shipmentNumber[$key] = $number;
		} else
			$data->shipmentNumber = $shipmentNumbers;

		return $data;
	}

	/**
	 * Creates the getManifest-Request
	 *
	 * @param string|int $manifestDate - Manifest-Date as String (YYYY-MM-DD) or the int time() value of the date
	 * @param bool $useIntTime - Use the int Time Value instead of a String
	 * @return bool|Response - false on error or DHL-Response Object
	 */
	public function getManifest($manifestDate, $useIntTime = false) {
		if($useIntTime) {
			// Convert to Date-Format for DHL
			$oldDate = $manifestDate;
			$manifestDate = date('Y-m-d', $manifestDate);

			if($manifestDate === false) {
				$this->addError('Could not convert given time() value "' . $oldDate . '" to YYYY-MM-DD... Called method: ' . __METHOD__);

				return false;
			}

			unset($oldDate);
		}

		switch($this->getMayor()) {
			case 1:
				trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);
				$this->addError('Version 1 Method "' . __METHOD__ . '" is not implemented or removed!');

				return false;
			case 2:
			default:
				$data = $this->createGetManifestClass_v2($manifestDate);
		}

		try {
			$response = $this->sendGetManifestRequest($data);
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
	 * Creates the Data-Object for getManifest
	 *
	 * @param string $manifestDate - Manifest Date (String-Format: YYYY-MM-DD)
	 * @return StdClass - Data-Object
	 */
	private function createGetManifestClass_v2($manifestDate) {
		$data = new StdClass;

		if(is_array($manifestDate))
			$this->addError('You can only request 1 date on getManifest - multiple requests in 1 call are not allowed here');

		$data->Version = $this->getVersionClass();
		$data->manifestDate = $manifestDate;

		return $data;
	}

	/**
	 * Creates the getManifest-Request via SOAP
	 *
	 * @param Object|array $data - Manifest-Data
	 * @return Object - DHL-Response
	 */
	private function sendGetManifestRequest($data) {
		return $this->getSoapClient()->getManifest($data);
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
	 * Alias for createShipmentOrder
	 *
	 * Creates the Shipment-Request
	 *
	 * @return bool|Response - false on error or DHL-Response Object
	 */
	public function createShipment() {
		return $this->createShipmentOrder();
	}

	/**
	 * Creates the Shipment-Request
	 *
	 * @return bool|Response - false on error or DHL-Response Object
	 */
	public function createShipmentOrder() {
		switch($this->getMayor()) {
			case 1:
				$data = $this->createShipmentClass_v1();
				break;
			case 2:
			default:
				if($this->countShipmentOrders() < 1)
					$data = $this->createShipmentClass_v2_legacy();
				else
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
			return new Response($this->getVersion(), $response);
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

		return $data;
	}

	/**
	 * Creates the Data-Object for the Request
	 *
	 * @param null|string $shipmentNumber - Shipment Number which should be included or null for none
	 * @return StdClass - Data-Object
	 */
	private function createShipmentClass_v2($shipmentNumber = null) {
		$shipmentOrders = $this->getShipmentOrders();

		$this->checkRequestCount($shipmentOrders, 'createShipmentClass');

		$data = new StdClass;
		$data->Version = $this->getVersionClass();

		if($shipmentNumber !== null)
			$data->shipmentNumber = (string) $shipmentNumber;

		foreach($shipmentOrders as $key => &$shipmentOrder) {
			/**
			 * @var ShipmentOrder $shipmentOrder
			 */
			// Set global response-type if none is defined in shipment
			if($shipmentOrder->getLabelResponseType() === null && $this->getLabelResponseType() !== null)
				$shipmentOrder->setLabelResponseType($this->getLabelResponseType());

			$data->ShipmentOrder[$key] = $shipmentOrder->getShipmentOrderClass_v2();
		}

		return $data;
	}

	/**
	 * Creates the Data-Object for the Request
	 *
	 * @param null|string $shipmentNumber - Shipment Number which should be included or null for none
	 * @return StdClass - Data-Object
	 *
	 * @deprecated - Old Shipment creation class (Supports only 1 Shipment)
	 */
	private function createShipmentClass_v2_legacy($shipmentNumber = null) {
		trigger_error(
			'[DHL-PHP-SDK]: ' . __CLASS__ . '->' . __METHOD__ .
			' This method was called for Backward-Compatibility, please create `ShipmentOrder` Objects' .
			' and assign them with `addShipmentOrder($shipmentOrder)` on this instance.',
			E_USER_DEPRECATED
		);

		// Set old values
		$this->getShipmentDetails()->setService($this->getService());
		$this->getShipmentDetails()->setBank($this->getBank());

		// Create class
		$data = new StdClass;
		$data->Version = $this->getVersionClass();

		if($shipmentNumber !== null)
			$data->shipmentNumber = (string) $shipmentNumber;

		$data->ShipmentOrder = new StdClass;
		$data->ShipmentOrder->sequenceNumber = $this->getSequenceNumber();

		// Shipment
		$data->ShipmentOrder->Shipment = new StdClass;
		$data->ShipmentOrder->Shipment->ShipmentDetails = $this->getShipmentDetails()->getShipmentDetailsClass_v2();

		// Notification
		$email = null; // Check for backward compatibility
		if($this->getShipmentDetails()->getNotificationEmail() === null && $this->receiverEmail !== null)
			$email = $this->getReceiverEmail(); // Use old E-Mail implementation for BC

		if($email !== null) {
			$data->ShipmentOrder->Shipment->ShipmentDetails->Notification = new StdClass;
			$data->ShipmentOrder->Shipment->ShipmentDetails->Notification->recipientEmailAddress = $email;
		}

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
	 * Alias for deleteShipmentOrder
	 *
	 * Deletes a Shipment
	 *
	 * @param string|string[] $shipmentNumbers - Shipment-Number(s) of the Shipment(s) to delete (up to 30 Numbers)
	 * @return bool|Response - Response
	 */
	public function deleteShipment($shipmentNumbers) {
		return $this->deleteShipmentOrder($shipmentNumbers);
	}

	/**
	 * Deletes a Shipment
	 *
	 * @param string|string[] $shipmentNumbers - Shipment-Number(s) of the Shipment(s) to delete (up to 30 Numbers)
	 * @return bool|Response - Response
	 */
	public function deleteShipmentOrder($shipmentNumbers) {
		switch($this->getMayor()) {
			case 1:
				$data = $this->createDeleteClass_v1($shipmentNumbers);
				break;
			case 2:
			default:
				$data = $this->createDeleteClass_v2($shipmentNumbers);
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
	 * @param string|string[] $shipmentNumbers - Shipment-Number(s) of the Shipment(s) to delete (up to 30 Numbers)
	 * @return StdClass - Data-Object
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	private function createDeleteClass_v1($shipmentNumbers) {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		$data = new StdClass;

		return $data;
	}

	/**
	 * Creates Data-Object for Deletion
	 *
	 * @param string|string[] $shipmentNumbers - Shipment-Number(s) of the Shipment(s) to delete (up to 30 Numbers)
	 * @return StdClass - Data-Object
	 */
	private function createDeleteClass_v2($shipmentNumbers) {
		$data = new StdClass;

		$data->Version = $this->getVersionClass();

		if(is_array($shipmentNumbers)) {
			$this->checkRequestCount($shipmentNumbers, 'deleteShipmentOrder');

			foreach($shipmentNumbers as $key => &$number)
				$data->shipmentNumber[$key] = $number;
		} else
			$data->shipmentNumber = $shipmentNumbers;

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
	 * Alias for getLabel
	 *
	 * Requests a Shipment-Label again
	 *
	 * @param string|string[] $shipmentNumbers - Shipment-Number(s) of the Label(s) (up to 30 Numbers)
	 * @return bool|Response - Response or false on error
	 */
	public function getShipmentLabel($shipmentNumbers) {
		return $this->getLabel($shipmentNumbers);
	}

	/**
	 * Requests a Shipment-Label again
	 *
	 * @param string|string[] $shipmentNumbers - Shipment-Number(s) of the Label(s) (up to 30 Numbers)
	 * @return bool|Response - Response or false on error
	 */
	public function getLabel($shipmentNumbers) {
		switch($this->getMayor()) {
			case 1:
				$data = $this->getLabelClass_v1($shipmentNumbers);
				break;
			case 2:
			default:
				$data = $this->getLabelClass_v2($shipmentNumbers);
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
			return new Response($this->getVersion(), $response);
	}

	/**
	 * Creates Data-Object for Label-Request
	 *
	 * @param string|string[] $shipmentNumbers - Number(s) of the Shipment(s) (up to 30 Numbers)
	 * @return StdClass - Data-Object
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	private function getLabelClass_v1($shipmentNumbers) {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		$data = new StdClass;

		return $data;
	}

	/**
	 * Creates Data-Object for Label-Request
	 *
	 * @param string|string[] $shipmentNumbers - Number(s) of the Shipment(s) (up to 30 Numbers)
	 * @return StdClass - Data-Object
	 */
	private function getLabelClass_v2($shipmentNumbers) {
		$data = new StdClass;

		$data->Version = $this->getVersionClass();

		if(is_array($shipmentNumbers)) {
			$this->checkRequestCount($shipmentNumbers, 'getLabel');

			foreach($shipmentNumbers as $key => &$number)
				$data->shipmentNumber[$key] = $number;
		} else
			$data->shipmentNumber = $shipmentNumbers;

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
	 * @param string|string[] $shipmentNumbers - Shipment-Number(s) of the Export-Document(s) (up to 30 Numbers)
	 * @return bool|Response - Response or false on error
	 */
	public function getExportDoc($shipmentNumbers) {
		switch($this->getMayor()) {
			case 1:
				$data = $this->getExportDocClass_v1($shipmentNumbers);
				break;
			case 2:
			default:
				$data = $this->getExportDocClass_v2($shipmentNumbers);
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
	 * @param string|string[] $shipmentNumbers - Number(s) of the Shipment(s) (up to 30 Numbers)
	 * @return StdClass - Data-Object
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	private function getExportDocClass_v1($shipmentNumbers) {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		$data = new StdClass;

		return $data;
	}

	/**
	 * Creates Data-Object for Export-Document-Request
	 *
	 * @param string|string[] $shipmentNumbers - Number(s) of the Shipment(s) (up to 30 Numbers)
	 * @return StdClass - Data-Object
	 */
	private function getExportDocClass_v2($shipmentNumbers) {
		$data = new StdClass;

		$data->Version = $this->getVersionClass();

		if(is_array($shipmentNumbers)) {
			$this->checkRequestCount($shipmentNumbers, 'getExportDoc');

			foreach($shipmentNumbers as $key => &$number)
				$data->shipmentNumber[$key] = $number;
		} else
			$data->shipmentNumber = $shipmentNumbers;

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

	/**
	 * Updates the Shipment-Request
	 *
	 * @param string $shipmentNumber - Number of the Shipment, which should be updated
	 * @return bool|Response - false on error or DHL-Response Object
	 */
	public function updateShipmentOrder($shipmentNumber) {
		if(is_array($shipmentNumber) || $this->countShipmentOrders() > 1) {
			$this->addError(__FUNCTION__ . ': Updating Shipments is a Single-Operation only!');

			return false;
		}

		switch($this->getMayor()) {
			case 1:
				$data = null;
				break;
			case 2:
			default:
				if($this->countShipmentOrders() < 1)
					$data = $this->createShipmentClass_v2_legacy($shipmentNumber);
				else
					$data = $this->createShipmentClass_v2($shipmentNumber);
		}

		$response = null;

		// Create Shipment
		try {
			$response = $this->sendUpdateRequest($data);
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
	 * Requests the Update of a Shipment via SOAP
	 *
	 * @param Object|array $data - Shipment-Data
	 * @return Object - DHL-Response
	 * @throws Exception - Method doesn't exists for Version
	 */
	private function sendUpdateRequest($data) {
		switch($this->getMayor()) {
			case 1:
				throw new Exception(__FUNCTION__ . ': Method doesn\'t exists for Version 1!');
			case 2:
			default:
				return $this->getSoapClient()->updateShipmentOrder($data);
		}
	}
}
