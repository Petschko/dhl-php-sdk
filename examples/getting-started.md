# Getting started

## Install the Project
- **With** [Composer](https://getcomposer.org/): `composer require petschko/dhl-php-sdk`

- **Without** Composer: [Download the newest Version](https://github.com/Petschko/dhl-php-sdk/releases) and put it manually to your Project

## Include the Project

You need to add a small snipped, which autoload all the required files for you. Wherever you want to use it, you have to add this line:

- **With** Composer:
```php
require_once __DIR__ . '/vendor/autoload.php';
```

- **Without** Composer:
```php
require_once(__DIR__ . '/includes/_nonComposerLoader.php');
```

That's it, now you can start to do all the Configuration for you DHL-Logic (Explained in the next steps)

## Usage

_This is just a very basic Tutorial how you can use the DHL-PHP-SDK, I will add more tutorials & examples to the [example](https://github.com/Petschko/dhl-php-sdk/tree/master/examples) to the directory._

First you need to setup your DHL-Credentials:

**TEST**-Credentials:
```php
// You can initial the Credentials-Object with one of the pre-set Test-Accounts
$credentials = new \Petschko\DHL\Credentials(/* Optional: Test-Modus */ \Petschko\DHL\Credentials::TEST_NORMAL); // Normal-Testuser
$credentials = new \Petschko\DHL\Credentials(/* Optional: Test-Modus */ \Petschko\DHL\Credentials::TEST_THERMO_PRINTER); // Thermo-Printer-Testuser

// Now you just need to set your DHL-Developer-Data to it
$credentials->setApiUser('myuser'); // Set the USERNAME (not E-Mail!) of your DHL-Dev-Account
$credentials->setApiPassword('myPasswd'); // Set the Password of your DHL-Dev-Account
```

**LIVE**-Credentials

```php
// Just create the Credentials-Object
$credentials = new \Petschko\DHL\Credentials();

// Setup these Infos: (ALL Infos are Case-Sensitive!)
$credentials->setUser('Your-DHL-Account'); // DHL-Account (Same as if you Login with then to create Manual-Labels)
$credentials->setSignature('Your-DHL-Account-Password'); // DHL-Account-Password
$credentials->setEkp('EKP-Account-Number'); // Number of your Account (Provide at least the first 10 digits)
$credentials->setApiUser('appId'); // Your Applications-ID (You can find it in your DHL-Dev-Account)
$credentials->setApiPassword('appToken'); // Your Applications-Token (You can find it also where you found the App-Id) 
```

You've set all of the Required Information so far. Now you can Perform several Actions.

### Create a Shipment

_Please note, that you need the `\Petschko\DHL\Credentials` Object with Valid Login-Information for that._

#### Classes used:

- `\Petschko\DHL\Credentials` **(Req)** - Login Information
- `\Petschko\DHL\ShipmentDetails` **(Req)** - Details of a Shipment
- `\Petschko\DHL\ShipmentOrder` **(Req)** - A whole Shipment
- `\Petschko\DHL\Sender` **(Req)** - Sender Details
	- `\Petschko\DHL\SendPerson` (Parent)
		- `\Petschko\DHL\Address` (Parent)
- `\Petschko\DHL\ReturnReceiver` (Optional) - Return Receiver Details
	- `\Petschko\DHL\SendPerson` (Parent)
		- `\Petschko\DHL\Address` (Parent)
- `\Petschko\DHL\Service` (Optional) - Service Details (Many Configurations for the Shipment)
- `\Petschko\DHL\IdentCheck` (Very Optional) - Ident-Check Details, only needed if turned on in Service
- `\Petschko\DHL\BankData` (Optional) - Bank-Information
- `\Petschko\DHL\ExportDocument` (Optional) - Export-Document Information
- `\Petschko\DHL\ExportDocPosition` (Optional) - Export-Document Position Item details
- `\Petschko\DHL\BusinessShipment` **(Req)** - Manages all Actions + Information
	- `\Petschko\DHL\Version` (Parent)
- `\Petschko\DHL\Response` **(Req|Auto)** - Response Information
	- `\Petschko\DHL\Version` (Parent)
- `\Petschko\DHL\LabelData` **(Req|Auto)** - Label Response Information
	- `\Petschko\DHL\Version` (Parent)

And one of them:
- `\Petschko\DHL\Receiver` **(Req)** - Receiver Details
	- `\Petschko\DHL\SendPerson` (Parent)
		- `\Petschko\DHL\Address` (Parent)
- `\Petschko\DHL\Filial` (Optional) - Receiver-Details (Post-Filial)
	- `\Petschko\DHL\Receiver` **(Req|Parent)** - Receiver Details
		- `\Petschko\DHL\SendPerson` (Parent)
			- `\Petschko\DHL\Address` (Parent)
- `\Petschko\DHL\PackStation` (Optional) - Receiver-Details (Pack-Station)
	- `\Petschko\DHL\Receiver` **(Req|Parent)** - Receiver Details
		- `\Petschko\DHL\SendPerson` (Parent)
			- `\Petschko\DHL\Address` (Parent)

#### How to create

##### `\Petschko\DHL\Sender`, `\Petschko\DHL\Receiver` & `\Petschko\DHL\ReturnReceiver` Object(s)

You have to create a Sender and a Receiver. They are similar to set, just the XML creation is different so you have to use different Objects for that.

If you want to lookup all values, you can search trough the `\Petschko\DHL\SendPerson` & `\Petschko\DHL\Address` Classes.

Lets start with the Sender, in the most cases you =). Create a `\Petschko\DHL\Sender` Object:

```php
$sender = new \Petschko\DHL\Sender();
```

Setup all **Required** Information

```php
$sender->setName((string) 'Organisation Petschko'); // Can be a Person-Name or Company Name

// You need to seperate the StreetName from the Number and set each one to its own setter
// Example Full Address: "Oberer Landweg 12a" 
$sender->setStreetName((string) 'Oberer Landweg');
$sender->setStreetNumber((string) '12a'); // A Number is ALWAYS needed

$sender->setZip((string) '21035');
$sender->setCity((string) 'Hamburg');
$sender->setCountry((string) 'Germany');
$sender->setCountryISOCode((string) 'DE'); // 2 Chars ONLY
```

You can also add more Information, but they are **Optional**:

```php
// You can specify the delivery location
$sender->setAddressAddition((string) 'Etage 1'); // Default: null -> Disabled
$sender->setDispatchingInfo((string) 'Additional dispatching info'); // Default: null -> Disabled
$sender->setState((string) 'State'); // Default: null -> Disabled

// You can add more Personal-Info
$sender->setName2((string) 'Name Line 2'); // Default: null -> Disabled
$sender->setName3((string) 'Name Line 3'); // Default: null -> Disabled
$sender->setPhone((string) '04073409677'); // Default: null -> Disabled
$sender->setEmail((string) 'sendermail@domain.org'); // Default: null -> Disabled

// Mostly used in bigger Companies (Contact-Person)
$sender->setContactPerson((string) 'Peter Dragicevic'); // Default: null -> Disabled
```

This was the sender Object, you can set all the same Information with the `\Petschko\DHL\Receiver` + `\Petschko\DHL\ReturnReceiver` Class.

**Note**: You can also use `\Petschko\DHL\PackStation` or `\Petschko\DHL\Filial` instead of `\Petschko\DHL\Receiver`.
Please note, that they need some extra information.

You don't need to create the `\Petschko\DHL\ReturnReceiver` Object if you don't want a return Label.

##### `\Petschko\DHL\Service` Object

You can also setup more details for your Shipment by using the `\Petschko\DHL\Service` Object. It's an optional Object but may you should look, what you can set to this Object.

I'll not explain the Service-Object because there are too many settings. Please look into the Service-PHP-File by yourself. The fields are well documented.

##### `\Petschko\DHL\BankData` Object

You can also use the `\Petschko\DHL\BankData` Object. Bank data can be provided for different purposes. E.g. if COD (Cash on Delivery) is booked as service, bank data must be provided by DHL customer (mandatory server logic). The collected money will be transferred to specified bank account.

You can look to the PHP-File of the `\Petschko\DHL\BankData`-Object, and checkout what you can set there. I will not explain it here.

##### `\Petschko\DHL\ExportDocument` & `\Petschko\DHL\ExportDocPosition` Object(s)

Sometimes you need to create a Export-Document, in that case you need these both Objects. Please inform yourself what you need to do here.

##### `\Petschko\DHL\ShipmentDetails` Object

Now you need to setup the Shipment-Details for your Shipment (like Size/Weight etc). You can do that with the `\Petschko\DHL\ShipmentDetails` Object.

```php
// Create the Object with the first 10 Digits of your Account-Number (EKP).
// You can use the \Petschko\DHL\Credentials function "->getEkp((int) amount)" to get just the first 10 digits if longer
$shipmentDetails = new \Petschko\DHL\ShipmentDetails((string) $credentials->getEkp(10) . '0101'); // Ensure the 0101 at the end (or the number you need for your Product)
```

You can setup details for that, if you need. If you don't set them, it uses the default values _(This Part is Optional)_

```php
// Setup details

// -- Product
/* Setup the Product-Type that you need. Possible Values are:
* PRODUCT_TYPE_NATIONAL_PACKAGE = 'V01PAK';
* PRODUCT_TYPE_INTERNATIONAL_PACKAGE = 'V53WPAK';
* PRODUCT_TYPE_EUROPA_PACKAGE = 'V54EPAK';
* PRODUCT_TYPE_SAME_DAY_PACKAGE = 'V06PAK';
* PRODUCT_TYPE_SAME_DAY_MESSENGER = 'V06TG';
* PRODUCT_TYPE_WISH_TIME_MESSENGER = 'V06WZ';
* PRODUCT_TYPE_AUSTRIA_PACKAGE = 'V86PARCEL';
* PRODUCT_TYPE_AUSTRIA_INTERNATIONAL_PACKAGE = 'V82PARCEL';
* PRODUCT_TYPE_CONNECT_PACKAGE = 'V87PARCEL';
*/
$shipmentDetails->setProduct((string) \Petschko\DHL\ShipmentDetails::{ProductType}); // Default: PRODUCT_TYPE_NATIONAL_PACKAGE

// Example:
$shipmentDetails->setProduct((string) \Petschko\DHL\ShipmentDetails::PRODUCT_TYPE_INTERNATIONAL_PACKAGE);
// or (the same)
$shipmentDetails->setProduct((string) 'V53WPAK');

// -- Date
// You can set a Shipment-Date you have to provide it in this Format: YYYY-MM-DD
// -> The Date MUST be Today or in the future AND NOT a Sunday
$shipmentDetails->setShipmentDate((string) '2017-01-30'); // Default: Today or 1 day higher if Today is a Sunday
// You can also use a timestamp as value, just set the 2nd param to true (Default is false)
$shipmentDetails->setShipmentDate((int) time(), /* useTimeStamp = false */ true);

// -- Return Account-Number (EKP)
// Provide your Return-Account-Number here. If not needed don't set it!
// Its usually the same Account-Number like your DHL-Account, just set the end to 0701
$shipmentDetails->setReturnAccountNumber((string) $credentials->getEkp(10) . 0701); // Default: null -> Disabled

// -- References
$shipmentDetails->setCustomerReference((string) 'freetext 35 len'); // Default: null -> Disabled
// Only used if return receiver is used (ONLY if you want to print a return label)
$shipmentDetails->setReturnReference((string) 'freetext 35 len'); // Default: null -> Disabled

// Sizes/Weight
$shipmentDetails->setWeight((float) $weightInKG); // Default: 5.0 (KG)
$shipmentDetails->setLength((int) $lengthInCM); // Default: null -> Unset|none
$shipmentDetails->setWidth((int) $widthInCM); // Default: null -> Unset|none
$shipmentDetails->setHeight((int) $heightInCM); // Default: null -> Unset|none

// Notification E-Mail for this Shipping
$shipmentDetails->setNotificationEmail((string) $email); // Default: null -> Disabled

// When you had setup some services with the \Petschko\DHL\Service Class, you can add them here
$shipmentDetails->setService($service); \Petschko\DHL\Service Object - Default: null -> All Services have default settings

// When this Shipment need the Bank data because COD (Cash on Delivery) you can set them here
$shipmentDetails->setBank($bankObj); // \Petschko\DHL\BankData Object - Default: null -> Disabled
```

##### `\Petschko\DHL\ShipmentOrder` Object

Now you need to create the ShipmentOrder, which is explained here. First we need to create the Object

```php
$shipmentOrder = new \Petschko\DHL\ShipmentOrder();
```

This is the main Object of our Shipment, so we need to add all Child-Object to it. These are **Required**

```php
// Add all the required informations from previous Objects
$shipmentOrder->setShipmentDetails($shipmentDetails); // \Petschko\DHL\ShipmentDetails Object
$shipmentOrder->setSender($sender); // \Petschko\DHL\Sender Object
$shipmentOrder->setReceiver($receiver); // \Petschko\DHL\Receiver, \Petschko\DHL\PackStation or the \Petschko\DHL\Filial Object
```

If you want to add even more details, there are some more **optional** values to set

```php
// If you want to setup a return receiver, you can add it like this:
$shipmentOrder->setReturnReceiver($returnReceiver); // \Petschko\DHL\ReturnReceiver Object - Default: null -> Disabled

// If you need to add an Export-Document you can add it here
$shipmentOrder->setExportDocument($exportDocument); // \Petschko\DHL\ExportDocument Object - Default: null -> None

// Set a Sequence-Number if you need a referrence when you get the response (useful on multi-label requests)
$shipmentOrder->setSequenceNumber((string) '1'); // Default: '1'

$shipmentOrder->setPrintOnlyIfReceiverIsValid((bool) true); // Only print label on a valid adress - Default: null -> Uses DHL-Default

/* 
* You can get the Label as URL or as Base64-Data-String - set it how you want to have it
* Possible Values:
* \Petschko\DHL\BusinessShipment::RESPONSE_TYPE_URL = 'URL';
* \Petschko\DHL\BusinessShipment::RESPONSE_TYPE_B64 = 'B64';
*/
$shipmentOrder->setLabelResponseType((string) \Petschko\DHL\BusinessShipment::RESPONSE_TYPE_URL); // Default: null -> Uses DHL-Default
```

##### `\Petschko\DHL\BusinessShipment` Object

Finally you can add all together. You have to create the `\Petschko\DHL\BusinessShipment` Object

```php
/*
* Creates the Object:
* - 1st param is the \Petschko\DHL\Credentials Object
* - 2nd param (Optional - Default: false) defines if a test-modus should be used possible values:
* 		Test-Mode (Normal): Credentials::TEST_NORMAL, 'test', true
* 		Test-Mode (Thermo-Printer): Credentials::TEST_THERMO_PRINTER, 'thermo'
* 		Live (No-Test-Mode): false - default
* - 3rd param (Optional - Default: null -> newest) is a float value, that assigns the Version to use
*/
$dhl = new \Petschko\DHL\BusinessShipment($credentials);
```

If you want to use a specific WSDL-File (or remote), you can set it: _(Else you don't need this part)_

```php
$dhl->setCustomAPIURL('http://myserver.com/myAPIFile.wsdl');
```

Here you can add the ShipmentOrder:

````php
// Add all Required (For a CREATE-Shipment-Request) Classes
$dhl->addShipmentOrder($shipmentOrder);
$dhl->addShipmentOrder($shipmentOrder2); // You can add multiple shipments in one call (up to 30)
````

Now you can set how the Label should get returned and some other stuff:

```php
/*
* You can set a Global response-type, which aplies to all ShipmentOrders (Response-Types defined in Shipments have more prio than this)
* Possible Values:
* \Petschko\DHL\BusinessShipment::RESPONSE_TYPE_URL = 'URL';
* \Petschko\DHL\BusinessShipment::RESPONSE_TYPE_B64 = 'B64';
*/
$dhl->setLabelResponseType((string) \Petschko\DHL\BusinessShipment::RESPONSE_TYPE_URL); // Default: null -> Uses DHL-Default
```

#### Create the Request

All set? Fine, now you can finally made the Create-Shipment-Order-Request. Save the Response to a var
````php
// Returns false if the Request failed or \Petschko\DHL\Response on success
$response = $dhl->createShipment();
````

#### Handling the response
First you have to check if the Value is not false
```php
if($response === false) {
	// Do your Error-Handling here

	// Just to show all Errors
	var_dump($dhl->getErrors()); // Get the Error-Array
} else {
	// Handle the Response here

	// Just to show the whole Response-Object
	var_dump($response);
}
```

You can get several Information from the `\Petschko\DHL\Response` Object. Please have a look down where I describe the `\Petschko\DHL\Response` Class.


### Update a Shipment

It works the same like creating a Shipment, but you need to specify the Shipment number, you want to update! You call this 
request via `$dhl->updateShipmentOrder($shipmentNumber)`.
```php
	$dhl->updateShipmentOrder((string) $shipmentNumber)
```


### Delete one or multiple Shipment(s)

_Please note, that you need the `\Petschko\DHL\Credentials` Object with Valid Login-Information for that._

You also need the Shipment-Number(s), from the Shipment(s), that you want to cancel/delete.

#### Classes used

- `\Petschko\DHL\Credentials` **(Req)** - Login Information
- `\Petschko\DHL\BusinessShipment` **(Req)** - Manages all Actions + Information
	- `\Petschko\DHL\Version` (Parent)
- `\Petschko\DHL\Response` **(Req|Auto)** - Response Information
	- `\Petschko\DHL\Version` (Parent)
- `\Petschko\DHL\LabelData` **(Req|Auto)** - Label Response Information
	- `\Petschko\DHL\Version` (Parent)

#### How to create

Deleting one or multiple Shipment(s) is not very hard, it just works like this:
```php
// Create a \Petschko\DHL\BusinessShipment Object with your credentials
$dhl = new \Petschko\DHL\BusinessShipment($credentials);

// Send a deletetion Request for ONE Shipment
$response = $dhl->deleteShipment((string) 'shipment_number');

// You can also delete MULTIPLE Shipments at once (up to 30) it looks like this:
$response = $dhl->deleteShipment((array) array('shipment_number1', 'shipment_number2'));
```

Same like when creating a Shipment-Order, the Response is `false` if the Request failed.
For more Information about the Response, look down where I describe the `\Petschko\DHL\Response` Class.

### Re-Get one or multiple Label(s)

_Please note, that you need the `\Petschko\DHL\Credentials` Object with Valid Login-Information for that._

You also need the Shipment-Number(s), from the Shipment(s), where you want to Re-Get Label(s).

#### Classes used

- `\Petschko\DHL\Credentials` **(Req)** - Login Information
- `\Petschko\DHL\BusinessShipment` **(Req)** - Manages all Actions + Information
	- `\Petschko\DHL\Version` (Parent)
- `\Petschko\DHL\Response` **(Req|Auto)** - Response Information
	- `\Petschko\DHL\Version` (Parent)
- `\Petschko\DHL\LabelData` **(Req|Auto)** - Label Response Information
	- `\Petschko\DHL\Version` (Parent)

#### How to create

Same like deleting, re-getting Labels is not this hard. You can simply re-get Labels:

```php
// As usual create a \Petschko\DHL\BusinessShipment Object with your Credentials
$dhl = new \Petschko\DHL\BusinessShipment($credentials);

// This is the only setting you can do here: (Change Label-Response Type) - Optional
$dhl->setLabelResponseType((string) \Petschko\DHL\BusinessShipment::RESPONSE_TYPE_B64); // Default: null -> DHL-Default

// And here comes the Request for ONE Shipment
$response = $dhl->getShipmentLabel((string) 'shipment_number');

// And for MULTI-Requests (up to 30)
$response = $dhl->getShipmentLabel((array) array('shipment_number1', 'shipment_number2'));
```

If the request failed, you get `false` as usual else a `\Petschko\DHL\Response` Object.

### DoManifest

_Please note, that you need the `\Petschko\DHL\Credentials` Object with Valid Login-Information for that._

You also need the Shipment-Number for the Manifest _(If you need it, you will know how to use this)_.

I personally don't know for what is this for, but it works!

#### Classes used

- `\Petschko\DHL\Credentials` **(Req)** - Login Information
- `\Petschko\DHL\BusinessShipment` **(Req)** - Manages all Actions + Information
	- `\Petschko\DHL\Version` (Parent)
- `\Petschko\DHL\Response` **(Req|Auto)** - Response Information
	- `\Petschko\DHL\Version` (Parent)
- `\Petschko\DHL\LabelData` **(Req|Auto)** - Label Response Information
	- `\Petschko\DHL\Version` (Parent)

#### How to create

It works like deleting Shipments:
```php
// Create a \Petschko\DHL\BusinessShipment Object with your credentials
$dhl = new \Petschko\DHL\BusinessShipment($credentials);

// Do the Manifest-Request for ONE Shipment
$response = $dhl->doManifest((string) 'shipment_number');

// MULTI-Request (up to 30)
$response = $dhl->doManifest((array) array('shipment_number1', 'shipment_number2'));
```

If the request failed, you get `false` else a `\Petschko\DHL\Response` Object.
For more Information about the Response, look down where I describe the `\Petschko\DHL\Response` Class.

### GetManifest

_Please note, that you need the `\Petschko\DHL\Credentials` Object with Valid Login-Information for that._

I personally also don't know for what is this for, but it works!

#### Classes used

- `\Petschko\DHL\Credentials` **(Req)** - Login Information
- `\Petschko\DHL\BusinessShipment` **(Req)** - Manages all Actions + Information
	- `\Petschko\DHL\Version` (Parent)
- `\Petschko\DHL\Response` **(Req|Auto)** - Response Information
	- `\Petschko\DHL\Version` (Parent)

#### How to create

The syntax is quite simple, you just need to specify the date where you want to have the manifest:

```php
// Create a \Petschko\DHL\BusinessShipment Object with your credentials
$dhl = new \Petschko\DHL\BusinessShipment($credentials);

// Request to get the manifest from a specific date, the date can be given with an ISO-Date String (YYYY-MM-DD) or with the `time()` value of the day
$response = $dhl->getManifest('2018-08-06');
```

If the request failed, you get `false` else a `\Petschko\DHL\Response` Object.
For more Information about the Response, look down where I describe the `\Petschko\DHL\Response` Class.

### `\Petschko\DHL\Response` Object

If you get a Response that is not `false`, you have to mess with the `\Petschko\DHL\Response` Object.

This Object helps you, to get easy to your Goal. You can easily get the Values you need by using the getters. _(IDEs will detect them automatic)_

I will explain which values you can get from the Response-Object

```php
// You can get the GLOBAL-Status of all Labels by using these functions
(int) $response->getStatusCode(); // Returns the Status-Code (Difference to DHL - Weak-Validation is 1 not 0) - See below
(string) $response->getStatusText(); // Returns the Status-Text or null
(string) $response->getStatusMessage(); // Returns the Status-Message (More details) or null

// You can get the "getManifest"-Data always by using this function after the getManifest call
(string) $response->getManifestData(); // Returns the Manifest PDF-Data as Base64 String (Can be obtained via getManifest) or null

// You can still use these for SINGLE-Requests
(string) $response->getShipmentNumber(); // Returns the Shipment-Number of the Request or null
(string) $response->getLabel(); // Returns the Label URL or Base64-Label-String or null
(string) $response->getReturnLabel(); // Returns the ReturnLabel (URL/B64) or null
(string) $response->getExportDoc(); // Returns the Export-Document (URL/B64) or null (Can only be obtained if the Export-Doc Object was added to the Shipment request)
(string) $response->getSequenceNumber(); // Returns your provided sequence number or null
(string) $response->getCodLabel(); // Returns the Cod-Label or null
```

You can get all these values for MULTI-Requests as well, but it's a bit different...
First you can request how many items we got from the response by using:
```php
(int) $response->countLabelData(); // Returns how many items are in the response object - Return values: 0 - 30
```

You can access every item by using  `$response->getLabelData((null|int) $index);`. When you use `null`, you get the whole array, else the specific `\Petschko\DHL\LabelData`-Item chosen by the index.

You can get the values like this: (For the first item for example)

```php
// Status Values of each request (Every Request-Item has their own status)
(int) $response->getLabelData(0)->getStatusCode(); // Returns the Status-Code of the 1st Request (Difference to DHL - Weak-Validation is 1 not 0) - See below
(string) $response->getLabelData(0)->getStatusText(); // Returns the Status-Text of the 1st Request or null
(string) $response->getLabelData(0)->getStatusMessage(); // Returns the Status-Message (More details) of the 1st Request or null

// Info-Values
(string) $response->getLabelData(0)->getShipmentNumber(); // Returns the Shipment-Number of the 1st Request or null
(string) $response->getLabelData(0)->getLabel(); // Returns the Label URL or Base64-Label-String of the 1st Request or null
(string) $response->getLabelData(0)->getReturnLabel(); // Returns the ReturnLabel (URL/B64) of the 1st Request or null
(string) $response->getLabelData(0)->getExportDoc(); // Returns the Export-Document (URL/B64) of the 1st Request or null (Can only be obtained if the Export-Doc Object was added to the Shipment request)
(string) $response->getLabelData(0)->getSequenceNumber(); // Returns your provided sequence number of the 1st Request or null
(string) $response->getLabelData(0)->getCodLabel(); // Returns the Cod-Label of the 1st Request or null
```

Just to show you a simple loop, how you can handle every Request-Item:
```php
for($i = 0; $i < $response->countLabelData(); $i++) {
	// For example get the Shipment-Number of every item
	$shipmentNumber = $response->getLabelData($i)->getShipmentNumber();

	// (...) Do stuff with every Request-Item here
}
```

If a value is not set you get usually `null` as result. Not every Action fills out all of these values!

You can also take a look at the Class Constants, they are helping you to identify the Status-Codes:

```php
const \Petschko\DHL\Response::ERROR_NOT_SET = -1;
const \Petschko\DHL\Response::ERROR_NO_ERROR = 0;
const \Petschko\DHL\Response::ERROR_WEAK_WARNING = 1;
const \Petschko\DHL\Response::ERROR_SERVICE_TMP_NOT_AVAILABLE = 500;
const \Petschko\DHL\Response::ERROR_GENERAL = 1000;
const \Petschko\DHL\Response::ERROR_AUTH_FAILED = 1001;
const \Petschko\DHL\Response::ERROR_HARD_VAL_ERROR = 1101;
const \Petschko\DHL\Response::ERROR_UNKNOWN_SHIPMENT_NUMBER = 2000;
```

## Important helper functions

It can happen that you want to see the XML-Code, which was created from your request, there is a function, which can show this to you! Sometimes you need this to debug or send this code to the DHL-Support, when you have issues.

```php
$dhl = new \Petschko\DHL\BusinessShipment($credentials);

// (...) Code to call an DHL-Action

$dhl->getLastXML(); // You get a string with the XML-Code from this function, you can save it to a file or display it
```

There is also a function, which shows you the Response-XML from DHL. Can be helpful for debug or when the DHL-Support ask for it.

```php
$dhl = new \Petschko\DHL\BusinessShipment($credentials);

// (...) Code to call an DHL-Action

$dhl->getLastDhlXMLResponse(); // You get a string with the XML-Code from this function, you can save it to a file or display it
```

You get `null` as response, when you didn't called any DHL Action

That's all so far
