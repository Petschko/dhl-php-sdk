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

After that, you can read the shipment infos

````php
	if($response !== false)
		var_dump($response);
	else
		var_dump($dhl->getErrors());
````

That's all. More will be hopefully coming soon.

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
`setEkp`: Your dhl customer id  
`setApiUser`: App ID from developer account  
`setApiPassword`: App token from developer account

## WordPress and WooCommerce (From Origin creator)

I build several Plugins for WordPress and WooCommerce - feel free to ask me for that.

*Contact*  

Check out my website: [www.tricd.de](http://www.tricd.de)
