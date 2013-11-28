# DHL PHP SDK

This *unofficial* library is wrapping some functions of the DHL SOAP API in order to easy create shipments and labels.

## Motivation

I had a lot of pain studying and programming the DHL SOAP API - just to wrap some bits in a lot of XML. There is a lot, but not very helpful, documentation to the API. So I decided to create some functions in an easy to use and understand library.

## Prerequirements

You need a DHL developer account and - as long as you want to use the API in production systems - a DHL Intraship Account.

## Usage

First of all you need to create the Shipment Object with your credentials and some information from you as shipper.

	// your customer and api credentials from/for dhl
	$credentials = array(
    	'user' => 'geschaeftskunden_api', 
    	'signature' => 'Dhl_ep_test1', 
    	'ekp' => '5000000000',
    	'api_user'  => '',
    	'api_password'  => '',
    	'log' => true
    );


	// your company info
	$info = array(
    	'company_name'    => 'Kindehochdrei GmbH',
    	'street_name'     => 'Clayallee',
    	'street_number'   => '241',
    	'zip'             => '14165',
    	'country'         => 'germany',
    	'city'            => 'Berlin',
    	'email'           => 'bestellung@kindhochdrei.de',
    	'phone'           => '01788338795',
    	'internet'        => 'http://www.kindhochdrei.de',
    	'contact_person'  => 'Nina Boeing'
	);

With these infos you can create the object:

	$dhl = new DHLBusinessShipment($credentials, $info);
	
To create a shipment and get the shipment number and label, just create the receiver details:

	// receiver details
	$customer_details = array(
    	'first_name'    => 'Tobias',
    	'last_name'     => 'Redmann',
    	'c/o'           => '',
    	'street_name'   => 'Hocksteinweg',
    	'street_number' => '11',
    	'country'       => 'germany',
    	'zip'           => '14165',
    	'city'          => 'Berlin'
	);
	
And the create a shipment

	$response = $dhl->createNationalShipment($customer_details);
	
After that, you can read the shipment infos

	if($response !== false) {
  
  		var_dump($response);
  
	} else {
  
  		var_dump($dhl->errors);
  
	}
	
That's all. More will be hopefully coming soon.

Check out my website: [www.tricd.de](http://www.tricd.de)