<?php
/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 13.07.2017
 * Time: 21:17
 *
 * Notes:	Require this File if you don't have Composer installed... It will load ALL Classes for this Lib
 * 			But I suggest using Composer instead of this File - Get it here: https://getcomposer.org/
 * 			------------------------------------
 * 			IMPORTANT: Don't use this File, if you use Composer!
 */

// Set correct encoding
mb_internal_encoding('UTF-8');

// Get required classes
// Abstract classes & interfaces first
require_once('Version.php');
require_once('Address.php');
require_once('SendPerson.php');
require_once('LabelResponse.php');

// Now all other classes
require_once('Receiver.php');
require_once('Filial.php');
require_once('PackStation.php');

require_once('BankData.php');
require_once('BusinessShipment.php');
require_once('Credentials.php');
require_once('ExportDocPosition.php');
require_once('ExportDocument.php');
require_once('IdentCheck.php');
require_once('LabelData.php');
require_once('Product.php');
require_once('ProductInfo.php');
require_once('Response.php');
require_once('ReturnReceiver.php');
require_once('Sender.php');
require_once('Service.php');
require_once('ShipmentDetails.php');
require_once('ShipmentOrder.php');
