<?php

// Require the MAin-Class (other classes will included by this file)
require_once('includes' . DIRECTORY_SEPARATOR . 'DHLBusinessShipment.php');

// Your customer and api credentials from/for DHL
$credentials = new DHL_Credentials();

$credentials->setUser('geschaeftskunden_api');
$credentials->setSignature('Dhl_ep_test1');
$credentials->setEpk('5000000000');
$credentials->setApiUser('');
$credentials->setApiPassword('');

/* Old one:
 * $credentials = array(
	'user' => 'geschaeftskunden_api',
	'signature' => 'Dhl_ep_test1',
	'ekp' => '5000000000',
	'api_user'  => '',
	'api_password'  => '',
	'log' => true
);*/


// Your Company Info
$info = new DHL_Company();

$info->setCompanyName('Kindehochdrei GmbH');
$info->setStreetName('Clayallee');
$info->setStreetNumber('241');
$info->setZip('14165');
$info->setLocation('Berlin');
$info->setCountry('Germany'); // doesn't matter if you write something upper case
$info->setEmail('bestellung@kindhochdrei.de');
$info->setPhone('01788338795');
$info->setInternet('http://www.kindhochdrei.de');
$info->setContactPerson('Nina Boeing');

/* Old one:
 * $info = array(
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
);*/


// Receiver details
$customer_details = new DHL_Receiver();

$customer_details->setFirstName('Tobias');
$customer_details->setLastName('Redmann');
$customer_details->setCO(''); // Whatever
$customer_details->setFullStreet('Hocksteinweg 11');
$customer_details->setZip('14165');
$customer_details->setLocation('Berlin');
$customer_details->setCountry('Germany');

/* Old one:
* $customer_details = array(
	'first_name'    => 'Tobias',
	'last_name'     => 'Redmann',
	'c/o'           => '',
	'street_name'   => 'Hocksteinweg',
	'street_number' => '11',
	'country'       => 'germany',
	'zip'           => '14165',
	'city'          => 'Berlin'
);*/


$dhl = new DHLBusinessShipment($credentials, $info);

$response = $dhl->createNationalShipment($customer_details);

if($response !== false)
	var_dump($response);
else
	var_dump($dhl->getErrors());
