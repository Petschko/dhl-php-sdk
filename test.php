<?php

// Require the Main-Class (other classes will included by this file)
require_once('includes' . DIRECTORY_SEPARATOR . 'DHL_BusinessShipment.php');

$testModus = true;
$version = '2.2';

// Set this to true then you can skip set the "User§, "Signature" and "EPK" (Just for test-Modus) else false or empty
$credentials = new DHL_Credentials($testModus);

if(! $testModus) {
	$credentials->setUser('Your-DHL-Account');	// Don't need if initialed with true - Test-Modus
	$credentials->setSignature('Your-DHL-Account-Password'); // Don't need if initialed with true - Test-Modus
	$credentials->setEpk('EPK-Account-Number');	// Don't need if initialed with true - Test-Modus
}

// Set your api login
$credentials->setApiUser('');			// Test-Modus: Your DHL-Dev-Account | Production: Your Applications-ID
$credentials->setApiPassword('');		// Test-Modus: Your DHL-Dev-Account Password | Production: Your Applications-Token

// Set Shipment Details
$shipmentDetails = new DHL_ShipmentDetails($credentials->getEpk(10) . '0101');
$shipmentDetails->setShipmentDate('2017-01-30'); // Need to be in the future and NOT on a sunday
//$shipmentDetails->setReturnAccountNumber(return EPK 14 len); // Needed if you want to print a return label

// Set Sender
$sender = new DHL_Sender();
$sender->setName('Peter Muster');
$sender->setFullStreet('Test Straße 12a');
$sender->setZip('21037');
$sender->setCity('Hamburg');
$sender->setCountry('Germany');
$sender->setCountryISOCode('DE');

// Set Receiver
$receiver = new DHL_Receiver();
$receiver->setName('Test Empfänger');
$receiver->setFullStreet('Test Straße 23b');
$receiver->setZip('21037');
$receiver->setCity('Hamburg');
$receiver->setCountry('Germany');
$receiver->setCountryISOCode('DE');

$returnReceiver = new DHL_ReturnReceiver(); // Needed if you want to print an return label

// Set Service stuff (look at the class member - many settings here - just set them you need)
$service = new DHL_Service();
$service->setGoGreen(false); // Sadly don't work yet... i have to made a ticked bec the documentation is may wrong about this

// Required just Credentials also accept test-modus and version
$dhl = new DHL_BusinessShipment($credentials, $testModus, $version);
// Don't forget to assign the created objects to the DHL_BusinessShipment!
$dhl->setSequenceNumber('1'); // Just needed for ajax or such stuff can dynamic an other value
$dhl->setSender($sender);
$dhl->setReceiver($receiver);
//$dhl->setReturnReceiver($returnReceiver); // Needed if you want print a return label
$dhl->setService($service);
$dhl->setShipmentDetails($shipmentDetails);
$dhl->setReceiverEmail('receiver@mail.com'); // Needed if you want inform the receiver via mail
$dhl->setLabelResponseType(DHL_BusinessShipment::RESPONSE_TYPE_URL);

$response = $dhl->createShipment(); // Create the request

// For deletion you just need the shipment number and credentials
// $dhlDel = new DHL_BusinessShipment($credentials, $testModus, $version);
// $response_del = $dhlDel->deleteShipment('shipment_number'); // Deletes a Shipment

// Get the result
if($response !== false)
	var_dump($response);
else
	var_dump($dhl->getErrors());

// You can show the XML-Request as string
var_dump($dhl->getLastXML());
