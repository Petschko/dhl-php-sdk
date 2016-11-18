<?php

// Require the MAin-Class (other classes will included by this file)
require_once('includes' . DIRECTORY_SEPARATOR . 'DHL_BusinessShipment.php');

// Your customer and api credentials from/for DHL
$credentials = new DHL_Credentials();

$credentials->setUser('geschaeftskunden_api');
$credentials->setSignature('Dhl_ep_test1');
$credentials->setEpk('5000000000');
$credentials->setApiUser('');
$credentials->setApiPassword('');


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


// Receiver details
$customer_details = new DHL_Receiver();

$customer_details->setFirstName('Tobias');
$customer_details->setLastName('Redmann');
$customer_details->setCO(''); // Whatever
$customer_details->setFullStreet('Hocksteinweg 11');
$customer_details->setZip('14165');
$customer_details->setLocation('Berlin');
$customer_details->setCountry('Germany');


$dhl = new DHL_BusinessShipment($credentials, $info);

$response = $dhl->createNationalShipment($customer_details);

if($response !== false)
	var_dump($response);
else
	var_dump($dhl->getErrors());
