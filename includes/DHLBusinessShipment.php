<?php

// Set correct encoding
mb_internal_encoding('UTF-8');

// Get required classes
require_once('Address.php');
require_once('DHL_Credentials.php');
require_once('DHL_Company.php');
require_once('DHL_Receiver.php');

/**
 * Class DHLBusinessShipment
 */
class DHLBusinessShipment {
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
		$this->credentials = $api_credentials;
		$this->info = $customer_info;
		$this->sandbox = $sandbox;
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
	 * @param array $errors
	 */
	private function setErrors($errors) {
		$this->errors = $errors;
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
	 * todo doc
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
	 * todo doc
	 *
	 * @param DHL_Receiver $customer_details
	 * @param null $shipment_details - todo param not used yet? leave it to null
	 * @return array|bool
	 */
	function createNationalShipment($customer_details, $shipment_details = null) {
		$this->buildClient();

		$shipment = array();

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

		if($shipment_details == null) {
			$s['ShipmentItem'] = array();
			$s['ShipmentItem']['WeightInKG'] = '5';
			$s['ShipmentItem']['LengthInCM'] = '50';
			$s['ShipmentItem']['WidthInCM'] = '50';
			$s['ShipmentItem']['HeightInCM'] = '50';
			// FIXME/TODO: What is this - maybe pk for international pl is palette? see https://github.com/tobias-redmann/dhl-php-sdk/issues/2
			// $s['ShipmentItem']['PackageType'] = 'PL'; may removed?
		}

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


		$response = $this->getClient()->CreateShipmentDD($shipment);

		if(is_soap_fault($response) || $response->status->StatusCode != 0) {
			if(is_soap_fault($response))
				$this->addError($response->faultstring);
			else
				$this->addError($response->status->StatusMessage);

			return false;
		} else {
			$r = array();
			$r['shipment_number'] = (String) $response->CreationState->ShipmentNumber->shipmentNumber;
			$r['piece_number'] = (String) $response->CreationState->PieceInformation->PieceNumber->licensePlate;
			$r['label_url'] = (String) $response->CreationState->Labelurl;

			return $r;
		}
	}

	/**
	 * todo doc
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

	/*
	*function getVersion() {
	*	$this->buildClient();
	*	$this->log("Response: \n");
	*	$response = $this->client->getVersion(array('majorRelease' => '1', 'minorRelease' => '0'));
	*	$this->log($response);
	*}
	*/
}
