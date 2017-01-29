TODO: Change description if time

OLD-VERSION >.< Please wait until i updates the readme please or get the old version of this script:

[Download old Code](https://github.com/Petschko/dhl-php-sdk/releases/download/v0.1/dhl-php-sdk_v0.1.zip)

# DHL PHP SDK

This *unofficial* library is wrapping some functions of the DHL SOAP API in order to easy create shipments and labels.

## Motivation

I had a lot of pain studying and programming the DHL SOAP API - just to wrap some bits in a lot of XML. There is a lot, but not very helpful, documentation to the API. So I decided to create some functions in an easy to use and understand library.

## Prerequirements

You need a DHL developer account and - as long as you want to use the API in production systems - a DHL Intraship Account.

## Usage

First of all you need to create the Shipment Object with your credentials and some information from you as shipper.
````php
	// Your customer and api credentials from/for DHL
	$credentials = new DHL_Credentials();
	
	// If you wanna Test it you have to require a dev account on DHL
	$credentials->setUser('geschaeftskunden_api'); // DHL-User (Production: Your DHL-User in Lower-Case)
	$credentials->setSignature('Dhl_ep_test1'); // DHL-Password (Production: Your DHL-Password)
	$credentials->setEpk('5000000000'); // Customer Number (production: 10 first digits)
	$credentials->setApiUser(''); // API-User (dev: your dev ID | production: ApplicationID)
	$credentials->setApiPassword(''); // API-Password (dev: your dev password | production: ApplicationToken)
	
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
````

With these 2 Objects you can create the `DHLBusinessShipment` Object:

````php
	$dhl = new DHLBusinessShipment($credentials, $info, true);
	
	// If you want to have logging:
	$dhl->setLog(true);
````

To create a shipment and get the shipment number and label, just create the receiver details:

````php
	// Receiver details
	$customer_details = new DHL_Receiver();
	
	$customer_details->setFirstName('Tobias');
	$customer_details->setLastName('Redmann');
	$customer_details->setCO(''); // Whatever
	$customer_details->setFullStreet('Hocksteinweg 11');
	$customer_details->setZip('14165');
	$customer_details->setLocation('Berlin');
	$customer_details->setCountry('Germany');
````

You can use `setFullStreet` if you want the class to split street name and number automatic or just use the 2 separate Functions `setStreetName` and `setStreetNumber`

````php
	$address = new Address();
	
	// This here:
	$address->setFullStreet('Hocksteinweg 11');
	
	// Is the same as this:
	$address->setStreetName('Hocksteinweg');
	$address->setStreetNumber('11');
````
On the `setFullStreet` method you don't have to care about split the number from the street name.


And the create a shipment

````php
	$response = $dhl->createNationalShipment($customer_details);
````

You can also specify more stuff with your shipping but its optional. You have to create the `DHL_ShipmentDetails` Object:

````php
	$details = new DHL_ShipmentDetails();
	$details->setWeight(5); // Weight in KG (Default: 5)
	$details->setLength(50); // Length in CM (Default: 50)
	$details->setWidth(50); // Width in CM (Default: 50)
	$details->setHeight(50); // Height in CM (Default: 50)
	$details->setPackageType(DHL_ShipmentDetails::PACKAGE); // Package type (2 predefined constances but not sure if they correct)
	
	// Add Details as 2nd param
	$response = $dhl->createNationalShipment($customer_details, $details);
````

After that, you can read the Shipment Infos

````php
	if($response !== false)
		var_dump($response);
	else
		var_dump($dhl->getErrors());
````

The response (Here as `$response`) will stored in an Object `DHL_Response` you can get the 3 results:  
`getShipmentNumber`: Get the Shipment Number  
`getPieceNumber`: IDK what this is please edit if you know  
`getLabelUrl`: URL to the Label for your Shipment  

That's all.

## Using the live API

To use it in live environment, please create the Client as none sandboxed, just drop the last param:

````php
	$dhl = new DHLBusinessShipment($credentials, $info);
	
	// You can also log in the Non-Sandbox Mode, turn it on as before:
	$dhl->setLog(true);
````

You need also to change the credentials a bit:

````php
	// Your customer and api credentials from/for DHL
	$credentials = new DHL_Credentials();
	
	$credentials->setUser('geschaeftskunden_api');
	$credentials->setSignature('Dhl_ep_test1');
	$credentials->setEpk('5000000000');
	$credentials->setApiUser('');
	$credentials->setApiPassword('');
````

`setUser`: Use the intraship username  
`setSignature`: intraship password  
`setEkp`: Your DHL customer id (first 10 digits)  
`setApiUser`: App ID from developer account  
`setApiPassword`: App token from developer account

## WordPress and WooCommerce (From Origin creator)

I build several Plugins for WordPress and WooCommerce - feel free to ask me for that.

*Contact* (Origin creator)  

Check out my website: [www.tricd.de](http://www.tricd.de)
