<?php

require_once __DIR__.'/vendor/autoload.php';

// Require the Main-Class (other classes will included by this file)
use Petschko\DHL\BusinessShipment;
use Petschko\DHL\Credentials;
use Petschko\DHL\Receiver;
use Petschko\DHL\ReturnReceiver;
use Petschko\DHL\Sender;
use Petschko\DHL\Service;
use Petschko\DHL\ShipmentDetails;

$testModus = true;
$version = '2.2';
$reference = '1'; // You can use anything here (max 35 chars)

// Set this to true then you can skip set the "User", "Signature" and "EKP" (Just for test-Modus) else false or empty
$credentials = new Credentials($testModus);

if(! $testModus) {
	$credentials->setUser('Your-DHL-Account');	// Don't needed if initialed with true - Test-Modus
	$credentials->setSignature('Your-DHL-Account-Password'); // Don't needed if initialed with true - Test-Modus
	$credentials->setEkp('EKP-Account-Number');	// Don't needed if initialed with true - Test-Modus
}

// Set your API-Login
$credentials->setApiUser('');			// Test-Modus: Your DHL-Dev-Account (Developer-ID NOT E-Mail!!) | Production: Your Applications-ID
$credentials->setApiPassword('');		// Test-Modus: Your DHL-Dev-Account Password | Production: Your Applications-Token

// Set Shipment Details
$shipmentDetails = new ShipmentDetails($credentials->getEkp(10) . '0101'); // Create a Shipment-Details with the first 10 digits of your EKP-Number and 0101 (?)
$shipmentDetails->setShipmentDate('2017-01-30'); // Optional: Need to be in the future and NOT on a sunday | null or drop it, to use today
$shipmentDetails->setNotificationEmail('peter-91@hotmail.de'); // Needed if you want inform the receiver via mail
//$shipmentDetails->setReturnAccountNumber($credentials->getEkp(10) . '0701'); // Needed if you want to print a return label
//$shipmentDetails->setReturnReference($reference); // Only needed if you want to print a return label

// Set Sender
$sender = new Sender();
$sender->setName('Peter Muster');
$sender->setStreetName('Test Straße');
$sender->setStreetNumber('12a');
$sender->setZip('21037');
$sender->setCity('Hamburg');
$sender->setCountry('Germany');
$sender->setCountryISOCode('DE');

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

// Set Service stuff (look at the class member - many settings here - just set them you need)
$service = new Service();
// Set stuff you want in that class - This is very optional

// Required just Credentials also accept Test-Modus and Version
$dhl = new BusinessShipment($credentials, /*Optional*/$testModus, /*Optional*/$version);

// You can add your own API-File (if you want to use a remote one or your own) - else you don't need this
//$dhl->setCustomAPIURL('http://myserver.com/myAPIFile.wsdl');

// Don't forget to assign the created objects to the DHL_BusinessShipment!
$dhl->setSequenceNumber($reference); // Just needed for ajax or such stuff can dynamic an other value
$dhl->setSender($sender);
$dhl->setReceiver($receiver); // You can set these Object-Types here: DHL_Filial, DHL_Receiver & DHL_PackStation
//$dhl->setReturnReceiver($returnReceiver); // Needed if you want print a return label
$dhl->setService($service);
$dhl->setShipmentDetails($shipmentDetails);
$dhl->setLabelResponseType(BusinessShipment::RESPONSE_TYPE_URL);

$response = $dhl->createShipment(); // Creates the request

// For deletion you just need the shipment number and credentials
// $dhlDel = new BusinessShipment($credentials, $testModus, $version);
// $response_del = $dhlDel->deleteShipment('shipment_number'); // Deletes a Shipment

// To re-get the Label you can use the getShipmentLabel method - the shipment must be created with createShipment before
//$dhlReGetLabel = new BusinessShipment($credentials, $testModus, $version);
//$dhlReGetLabel->setLabelResponseType(DHL_BusinessShipment::RESPONSE_TYPE_B64); // Optional: Set the Label-Response-Type
//$reGetLabelResponse = $dhlReGetLabel->getShipmentLabel('shipmentNumber'); // ReGet Label

// To do a Manifest-Request you can use the doManifest method - you have to provide a Shipment-Number
//$manifestDHL = new BusinessShipment($credentials, $testModus, $version);
//$manifestResponse = $manifestDHL->doManifest('shipmentNumber');

// To do a Manifest-Request you can use the doManifest method - you have to provide a Shipment-Number
//$getManifestDHL = new BusinessShipment($credentials, $testModus, $version);
//$getManifestResponse = $getManifestDHL->getManifest('YYYY-MM-DD'); // Need to be in the past or today after doManifest()

// Get the result (just use var_dump to show all results)
if($response !== false)
	var_dump($response);
else
	var_dump($dhl->getErrors());

// You can show yourself also the XML-Request as string
var_dump($dhl->getLastXML());
