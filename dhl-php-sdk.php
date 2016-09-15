<?php

define('API_URL', 'https://cig.dhl.de/cig-wsdls/com/dpdhl/wsdl/geschaeftskundenversand-api/1.0/geschaeftskundenversand-api-1.0.wsdl');
define('DHL_SANDBOX_URL', 'https://cig.dhl.de/services/sandbox/soap');
define('DHL_PRODUCTION_URL', 'https://cig.dhl.de/services/production/soap');


/**
 * Class DHLBusinessShipment
 */
class DHLBusinessShipment {

	private $credentials;

	private $info;

	private $client;

	public $errors;

	protected $sandbox;

	/**
	 * Constructor for Shipment SDK
	 *
	 * @param type $api_credentials
	 * @param type $customer_info
	 * @param boolean $sandbox use sandbox or production environment
	 */
	function __construct($api_credentials, $customer_info, $sandbox = true) {

		$this->credentials = $api_credentials;
		$this->info = $customer_info;

		$this->sandbox = $sandbox;

		$this->errors = array();

	}

	private function log($message) {

		if(isset($this->credentials['log'])) {

			if(is_array($message) || is_object($message)) {

				error_log(print_r($message, true));

			} else {

				error_log($message);

			}

		}

	}

	private function buildClient() {

		$header = $this->buildAuthHeader();

		if($this->sandbox) {
			$location = DHL_SANDBOX_URL;
		} else {
			$location = DHL_PRODUCTION_URL;
		}

		$auth_params = array(
			'login' => $this->credentials['api_user'],
			'password' => $this->credentials['api_password'],
			'location' => $location,
			'trace' => 1

		);

		$this->log($auth_params);

		$this->client = new SoapClient(API_URL, $auth_params);

		$this->client->__setSoapHeaders($header);

		$this->log($this->client);


	}

	function createNationalShipment($customer_details, $shipment_details = null) {

		$this->buildClient();

		$shipment = array();

		// Version
		$shipment['Version'] = array('majorRelease' => '1', 'minorRelease' => '0');


		// Order
		$shipment['ShipmentOrder'] = array();

		// Fixme
		$shipment['ShipmentOrder']['SequenceNumber'] = '1';

		// Shipment
		$s = array();
		$s['ProductCode'] = 'EPN';
		$s['ShipmentDate'] = date('Y-m-d');
		$s['EKP'] = $this->credentials['ekp'];

		$s['Attendance'] = array();
		$s['Attendance']['partnerID'] = '01';

		if($shipment_details == null) {

			$s['ShipmentItem'] = array();
			$s['ShipmentItem']['WeightInKG'] = '5';
			$s['ShipmentItem']['LengthInCM'] = '50';
			$s['ShipmentItem']['WidthInCM'] = '50';
			$s['ShipmentItem']['HeightInCM'] = '50';
			// FIXME: What is this
			$s['ShipmentItem']['PackageType'] = 'PL';

		}


		$shipment['ShipmentOrder']['Shipment']['ShipmentDetails'] = $s;


		$shipper = array();
		$shipper['Company'] = array();
		$shipper['Company']['Company'] = array();
		$shipper['Company']['Company']['name1'] = $this->info['company_name'];

		$shipper['Address'] = array();
		$shipper['Address']['streetName'] = $this->info['street_name'];
		$shipper['Address']['streetNumber'] = $this->info['street_number'];
		$shipper['Address']['Zip'] = array();
		$shipper['Address']['Zip'][strtolower($this->info['country'])] = $this->info['zip'];
		$shipper['Address']['city'] = $this->info['city'];

		$shipper['Address']['Origin'] = array('countryISOCode' => 'DE');

		$shipper['Communication'] = array();
		$shipper['Communication']['email'] = $this->info['email'];
		$shipper['Communication']['phone'] = $this->info['phone'];
		$shipper['Communication']['internet'] = $this->info['internet'];
		$shipper['Communication']['contactPerson'] = $this->info['contact_person'];


		$shipment['ShipmentOrder']['Shipment']['Shipper'] = $shipper;

		$receiver = array();

		$receiver['Company'] = array();
		$receiver['Company']['Person'] = array();
		$receiver['Company']['Person']['firstname'] = $customer_details['first_name'];
		$receiver['Company']['Person']['lastname'] = $customer_details['last_name'];

		$receiver['Address'] = array();
		$receiver['Address']['streetName'] = $customer_details['street_name'];
		$receiver['Address']['streetNumber'] = $customer_details['street_number'];
		$receiver['Address']['Zip'] = array();
		$receiver['Address']['Zip'][strtolower($customer_details['country'])] = $customer_details['zip'];
		$receiver['Address']['city'] = $customer_details['city'];
		$receiver['Communication'] = array();

		$receiver['Address']['Origin'] = array('countryISOCode' => 'DE');

		$shipment['ShipmentOrder']['Shipment']['Receiver'] = $receiver;


		$response = $this->client->CreateShipmentDD($shipment);

		if(is_soap_fault($response) || $response->status->StatusCode != 0) {

			if(is_soap_fault($response)) {

				$this->errors[] = $response->faultstring;

			} else {

				$this->errors[] = $response->status->StatusMessage;

			}

			return false;

		} else {

			$r = array();
			$r['shipment_number'] = (String) $response->CreationState->ShipmentNumber->shipmentNumber;
			$r['piece_number'] = (String) $response->CreationState->PieceInformation->PieceNumber->licensePlate;
			$r['label_url'] = (String) $response->CreationState->Labelurl;

			return $r;
		}

	}


	/*
	  function getVersion() {

		$this->buildClient();

		$this->log("Response: \n");

		$response = $this->client->getVersion(array('majorRelease' => '1', 'minorRelease' => '0'));

		$this->log($response);

	  }
	  */


	private function buildAuthHeader() {

		$head = $this->credentials;

		$auth_params = array(
			'user' => $this->credentials['user'],
			'signature' => $this->credentials['signature'],
			'type' => 0

		);

		return new SoapHeader('http://dhl.de/webservice/cisbase', 'Authentification', $auth_params);


	}


}

?>
