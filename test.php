<?php

require_once __DIR__.'/vendor/autoload.php';

// Require the Main-Class (other classes will included by this file)
use Petschko\DHL\BusinessShipment;
use Petschko\DHL\Credentials;
use Petschko\DHL\Receiver;
use Petschko\DHL\ReturnReceiver;
use Petschko\DHL\Sender;
use Petschko\DHL\Service;
use Petschko\DHL\ShipmentOrder;
use Petschko\DHL\ShipmentDetails;

$testMode = Credentials::TEST_NORMAL; // Uses the normal test user
//$testMode = Credentials::DHL_BUSINESS_TEST_USER_THERMO; // Uses the thermo-printer test user
$version = '2.2'; // Can be specified or just left out (uses newest by default)
$reference = '1'; // You can use anything here (max 35 chars)

// Set this to true then you can skip set the "User", "Signature" and "EKP" (Just for test-Mode) else false or empty
$credentials = new Credentials($testMode);

if(! $testMode) {
	$credentials->setUser('Your-DHL-Account');	// Don't needed if initialed with Test-Mode
	$credentials->setSignature('Your-DHL-Account-Password'); // Don't needed if initialed with Test-Mode
	$credentials->setEkp('EKP-Account-Number');	// Don't needed if initialed with Test-Mode
}

// Set your API-Login
$credentials->setApiUser('');			// Test-Mode: Your DHL-Dev-Account (Developer-ID NOT E-Mail!!) | Production: Your Applications-ID
$credentials->setApiPassword('');		// Test-Mode: Your DHL-Dev-Account Password | Production: Your Applications-Token

// Set Service stuff (look at the class member - many settings here - just set them you need)
$service = new Service();
// Set stuff you want in that class - This is very optional

// Set Shipment Details
$shipmentDetails = new ShipmentDetails($credentials->getEkp(10) . '0101'); // Create a Shipment-Details with the first 10 digits of your EKP-Number and 0101 (?)
$shipmentDetails->setShipmentDate('2018-09-20'); // Optional: Need to be in the future and NOT on a sunday | null or drop it, to use today
$shipmentDetails->setNotificationEmail('mail@inform.me'); // Needed if you want inform the receiver via mail
//$shipmentDetails->setReturnAccountNumber($credentials->getEkp(10) . '0701'); // Needed if you want to print a return label
//$shipmentDetails->setReturnReference($reference); // Only needed if you want to print a return label
$shipmentDetails->setService($service); // Optional, just needed if you add some services
// $shipmentDetails->setBank($bank); // Very optional, you need to add the Bank Object, whenever you need it here

// Set Sender
$sender = new Sender();
$sender->setName('Peter Muster');
$sender->setStreetName('Test Straße');
$sender->setStreetNumber('12a');
$sender->setZip('21037');
$sender->setCity('Hamburg');
$sender->setCountry('Germany');
$sender->setCountryISOCode('DE');
// $sender->setEmail('peter@petschko.org'); // These are super optional, it will printed on the label, can set under receiver as well
// $sender->setPhone('015774121861');
// $sender->setContactPerson('Anna Muster');

// Set Receiver
$receiver = new Receiver();
$receiver->setName('Test Empfänger');
$receiver->setStreetName('Test Straße');
$receiver->setStreetNumber('23b');
$receiver->setZip('21037');
$receiver->setCity('Hamburg');
$receiver->setCountry('Germany');
$receiver->setCountryISOCode('DE');

$returnReceiver = new ReturnReceiver(); // Needed if you want to print an return label
// If want to use it, please set Address etc of the return receiver to!

// Required just Credentials also accept Test-Mode and Version
$dhl = new BusinessShipment($credentials, /*Optional*/$testMode, /*Optional*/$version);

// You can add your own API-File (if you want to use a remote one or your own) - else you don't need this
//$dhl->setCustomAPIURL('http://myserver.com/myAPIFile.wsdl');

// Don't forget to assign the created objects to the ShipmentOrder Object!
$shipmentOrder = new ShipmentOrder();
$shipmentOrder->setSequenceNumber($reference); // Just needed to identify the shipment if you do multiple
$shipmentOrder->setSender($sender);
$shipmentOrder->setReceiver($receiver); // You can set these Object-Types here: DHL_Filial, DHL_Receiver & DHL_PackStation
//$shipmentOrder->setReturnReceiver($returnReceiver); // Needed if you want print a return label
$shipmentOrder->setShipmentDetails($shipmentDetails);
$shipmentOrder->setLabelResponseType(BusinessShipment::RESPONSE_TYPE_URL);

// Add the ShipmentOrder to the BusinessShipment Object, you can add up to 30 ShipmentOrder Objects in 1 call
$dhl->addShipmentOrder($shipmentOrder);

$response = $dhl->createShipment(); // Creates the request

// For deletion you just need the shipment number and credentials
// $dhlDel = new BusinessShipment($credentials, $testMode, $version);
// $response_del = $dhlDel->deleteShipment('shipment_number'); // Deletes a Shipment
// $response_del = $dhlDel->deleteShipment(array('shipment_number1', 'shipment_number2')); // Deletes multiple Shipments (up to 30)

// To re-get the Label you can use the getShipmentLabel method - the shipment must be created with createShipment before
//$dhlReGetLabel = new BusinessShipment($credentials, $testMode, $version);
//$dhlReGetLabel->setLabelResponseType(DHL_BusinessShipment::RESPONSE_TYPE_B64); // Optional: Set the Label-Response-Type
//$reGetLabelResponse = $dhlReGetLabel->getLabel('shipment_number'); // ReGet a single Label
//$reGetLabelResponse = $dhlReGetLabel->getLabel(array('shipment_number1', 'shipment_number2')); // ReGet multiple Labels (up to 30)

// To do a Manifest-Request you can use the doManifest method - you have to provide a Shipment-Number
//$manifestDHL = new BusinessShipment($credentials, $testMode, $version);
//$manifestResponse = $manifestDHL->doManifest('shipment_number'); // Does Manifest on a Shipment
//$manifestResponse = $manifestDHL->doManifest(array('shipment_number1', 'shipment_number2')); // Does Manifest on multiple Shipments (up to 30)

// To do a Manifest-Request you can use the doManifest method - you have to provide a Shipment-Number
//$getManifestDHL = new BusinessShipment($credentials, $testMode, $version);
//$getManifestResponse = $getManifestDHL->getManifest('YYYY-MM-DD'); // Need to be in the past or today after doManifest()

// Get the result (just use var_dump to show all results)
if($response !== false)
	var_dump($response);
else
	var_dump($dhl->getErrors());

// You can show yourself also the XML-Request as string
var_dump($dhl->getLastXML());
