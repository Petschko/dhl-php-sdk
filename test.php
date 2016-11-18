<?php

// Require the MAin-Class (other classes will included by this file)
require_once('includes' . DIRECTORY_SEPARATOR . 'DHL_BusinessShipment.php');

// Your customer and api credentials from/for DHL
$credentials = new DHL_Credentials();

$credentials->setUser('geschaeftskunden_api');	// DHL-User (Production: Your DHL-User in Lower-Case)
$credentials->setSignature('Dhl_ep_test1');		// DHL-Password (Production: Your DHL-Password)
$credentials->setEpk('5234167890');				// Customer Number (production: 10 first digits)
$credentials->setApiUser('');					// API-User (dev: your dev ID | production: ApplicationID)
$credentials->setApiPassword('');				// API-Password (dev: your dev password | production: ApplicationToken)


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
