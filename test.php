<?php

require_once('includes' . DIRECTORY_SEPARATOR . 'DHLBusinessShipment.php');

// Your customer and api credentials from/for DHL
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


$dhl = new DHLBusinessShipment($credentials, $info);

$response = $dhl->createNationalShipment($customer_details);

if($response !== false)
	var_dump($response);
else
	var_dump($dhl->errors);
