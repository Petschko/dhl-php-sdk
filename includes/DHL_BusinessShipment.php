<?php

// Set correct encoding
mb_internal_encoding('UTF-8');

// Get required classes
require_once('Address.php');
require_once('DHL_Credentials.php');
require_once('DHL_Company.php');
require_once('DHL_Receiver.php');
require_once('DHL_ShipmentDetails.php');
require_once('DHL_Response.php');

/**
 * Class DHLBusinessShipment
 */
class DHL_BusinessShipment {
	const DHL_SANDBOX_URL = 'https://cig.dhl.de/services/sandbox/soap';
	const DHL_PRODUCTION_URL = 'https://cig.dhl.de/services/production/soap';
	const API_URL = 'https://cig.dhl.de/cig-wsdls/com/dpdhl/wsdl/geschaeftskundenversand-api/1.0/geschaeftskundenversand-api-1.0.wsdl';

	/**
	 * Contains the DHL_Credentials Object
	 *
	 * @var DHL_Credentials $credentials - DHL_Credentials Object
	 */
	private $credentials;

	/**
	 * Contains the DHL_Company Object
	 *
	 * @var DHL_Company $info - DHL_Company Object
	 */
	private $info;

	/**
	 * Contains the SoapClient Object
	 *
	 * @var SoapClient $client - SoapClient Object
	 */
	private $client;

	/**
	 * Contains the error array
	 *
	 * @var array $errors - Error-Array
	 */
	private $errors = array();

	/**
	 * Contains if the Object runs in Sandbox-Mode
	 *
	 * @var bool $sandbox - Run the Object in Sandbox mode
	 */
	private $sandbox;

	/**
	 * Contains if the Object had enabled Log-Messages
	 *
	 * @var bool $log - Has the Object enabled Log-Messages
	 */
	private $log = false;

	/**
	 * Constructor for Shipment SDK
	 *
	 * @param DHL_Credentials $api_credentials
	 * @param DHL_Company $customer_info
	 * @param boolean $sandbox - Use sandbox or production environment (Default false)
	 */
	public function __construct($api_credentials, $customer_info, $sandbox = false) {
		$this->setCredentials($api_credentials);
		$this->setInfo($customer_info);
		$this->setSandbox($sandbox);
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		unset($this->credentials);
		unset($this->info);
		unset($this->client);
		unset($this->errors);
		unset($this->sandbox);
		unset($this->log);
	}

	/**
	 * @return DHL_Credentials
	 */
	private function getCredentials() {
		return $this->credentials;
	}

	/**
	 * @param DHL_Credentials $credentials
	 */
	private function setCredentials($credentials) {
		$this->credentials = $credentials;
	}

	/**
	 * @return DHL_Company
	 */
	private function getInfo() {
		return $this->info;
	}

	/**
	 * @param DHL_Company $info
	 */
	private function setInfo($info) {
		$this->info = $info;
	}

	/**
	 * @return SoapClient
	 */
	private function getClient() {
		return $this->client;
	}

	/**
	 * @param SoapClient $client
	 */
	private function setClient($client) {
		$this->client = $client;
	}

	/**
	 * @return array
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * @param string $error
	 */
	private function addError($error) {
		$this->errors[] = $error;
	}

	/**
	 * @return boolean
	 */
	private function isSandbox() {
		return $this->sandbox;
	}

	/**
	 * @param boolean $sandbox
	 */
	private function setSandbox($sandbox) {
		$this->sandbox = $sandbox;
	}

	/**
	 * @return boolean
	 */
	public function isLog() {
		return $this->log;
	}

	/**
	 * @param boolean $log
	 */
	public function setLog($log) {
		$this->log = $log;
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
	 * Auth Client on DHL-API
	 */
	private function buildClient() {
		$header = $this->buildAuthHeader();

		if($this->isSandbox())
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
		$this->setClient(new SoapClient(self::API_URL, $auth_params));
		$this->getClient()->__setSoapHeaders($header);
		$this->log($this->getClient());
	}

	/**
	 * Creates a nation Shipment
	 *
	 * @param DHL_Receiver $customer_details
	 * @param DHL_ShipmentDetails $shipment_details - Shipment details
	 * @return DHL_Response|bool - Response or false on error
	 */
	public function createNationalShipment($customer_details, $shipment_details = null) {
		$this->buildClient();

		$shipment = array();

		// Set default values for details if none are given
		if($shipment_details === null)
			$shipment_details = new DHL_ShipmentDetails();

		// Version
		$shipment['Version'] = array('majorRelease' => '1', 'minorRelease' => '0');

		// Order
		$shipment['ShipmentOrder'] = array();

		// Fixme/TODO
		$shipment['ShipmentOrder']['SequenceNumber'] = '1';

		// Shipment
		$s = array();
		$s['ProductCode'] = 'EPN';
		$s['ShipmentDate'] = date('Y-m-d');
		$s['EKP'] = $this->getCredentials()->getEpk();

		$s['Attendance'] = array();
		$s['Attendance']['partnerID'] = '01';
		// Add Details
		$s['ShipmentItem'] = $shipment_details->toDHLArray();

		$shipment['ShipmentOrder']['Shipment']['ShipmentDetails'] = $s;

		$shipper = array();
		$shipper['Company'] = array();
		$shipper['Company']['Company'] = array();
		$shipper['Company']['Company']['name1'] = $this->getInfo()->getCompanyName();

		$shipper['Address'] = array();
		$shipper['Address']['streetName'] = $this->getInfo()->getStreetName();
		$shipper['Address']['streetNumber'] = $this->getInfo()->getStreetNumber();
		$shipper['Address']['Zip'] = array();
		$shipper['Address']['Zip'][$this->getInfo()->getCountry()] = $this->getInfo()->getZip();
		$shipper['Address']['city'] = $this->getInfo()->getLocation();

		$shipper['Address']['Origin'] = array('countryISOCode' => 'DE');

		$shipper['Communication'] = array();
		$shipper['Communication']['email'] = $this->getInfo()->getEmail();
		$shipper['Communication']['phone'] = $this->getInfo()->getPhone();
		$shipper['Communication']['internet'] = $this->getInfo()->getInternet();
		$shipper['Communication']['contactPerson'] = $this->getInfo()->getContactPerson();

		$shipment['ShipmentOrder']['Shipment']['Shipper'] = $shipper;

		$receiver = array();
		$receiver['Company'] = array();
		$receiver['Company']['Person'] = array();
		$receiver['Company']['Person']['firstname'] = $customer_details->getFirstName();
		$receiver['Company']['Person']['lastname'] = $customer_details->getLastName();

		$receiver['Address'] = array();
		$receiver['Address']['streetName'] = $customer_details->getStreetName();
		$receiver['Address']['streetNumber'] = $customer_details->getStreetNumber();
		$receiver['Address']['Zip'] = array();
		$receiver['Address']['Zip'][$customer_details->getCountry()] = $customer_details->getZip();
		$receiver['Address']['city'] = $customer_details->getLocation();
		$receiver['Communication'] = array();

		$receiver['Address']['Origin'] = array('countryISOCode' => 'DE');

		$shipment['ShipmentOrder']['Shipment']['Receiver'] = $receiver;

		$response = null;

		// Create Shipment
		try {
			$response = $this->getClient()->CreateShipmentDD($shipment);
		} catch(Exception $e) {
			$this->addError($e->getMessage());

			return false;
		}

		if(is_soap_fault($response) || $response->status->StatusCode != 0) {
			if(is_soap_fault($response))
				$this->addError($response->faultstring);
			else
				$this->addError($response->status->StatusMessage);

			return false;
		} else {
			$r = new DHL_Response($response);

			return $r;
		}
	}

	/**
	 * Build SOAP-Header
	 *
	 * @return SoapHeader
	 */
	private function buildAuthHeader() {
		$auth_params = array(
			'user' => $this->getCredentials()->getUser(),
			'signature' => $this->getCredentials()->getSignature(),
			'type' => 0
		);

		return new SoapHeader('http://dhl.de/webservice/cisbase', 'Authentification', $auth_params);
	}
}
