<?php

namespace Petschko\DHL;

/**
 * Author: Maximilian Stark [mail@dakror.de]
 * Authors-Website: http://dakror.de/
 * Date: 02.09.2018
 * Time: 13:17
 * Version: 1.0.2
 *
 * Notes: Contains the ProductInfo Class
 */

/**
 * Class ProductInfo
 *
 * @package Petschko\DHL
 */
class ProductInfo {
	/**
	 * was this Class Initiated
	 *
	 * @var bool $init - Is this Class initiated
	 */
	private static $init = false;

	/**
	 * Names for Services
	 *
	 * @var string[] $serviceNames - Service-Names
	 */
	public static $serviceNames = array(
		'preferredNeighbourEnabled' => 'Wunschnachbar',
		'preferredLocationEnabled' => 'Wunschort',
		'visualCheckOfAgeEnabled' => 'Alterssichtprüfung',
		'personalHandover' => 'Eigenhändig',
		'namedPersonOnly' => 'persönliche Übergabe',
		'identCheckEnabled' => 'Ident-Check',
		'endorsementEnabled' => 'Vorausverfügung',
		'returnReceipt' => 'Rückschein',
		'preferredDayEnabled' => 'Wunschtag',
		'preferredTimeEnabled' => 'Wunschzeit',
		'disableNeighbourDelivery' => 'keine Nachbarschaftszustellung',
		'goGreen' => 'GoGreen',
		'additionalInsuranceEnabled' => 'Transportversicherung',
		'bulkyGoods' => 'Sperrgut',
		'cashOnDeliveryEnabled' => 'Nachnahme',
		'dayOfDeliveryEnabled' => 'Zustelldatum',
		'deliveryTimeframeEnabled' => 'Zustellzeitfenster',
		'shipmentHandlingEnabled' => 'Sendungshandling',
		'perishables' => 'verderbliche Ware',
		'individualSenderRequiredmentsEnabled' => 'Individuelle Senderhinweise',
		'premium' => 'Premium',
		'packagingReturn' => 'Verpackungsrücknahme',
		'noticeNonDeliverability' => 'Unzustellbarkeitsnachricht',
		'returnImmediatlyIfShipmentFailed' => 'ReturnImmediately'
	);

	/**
	 * Contains all Products
	 *
	 * @var Product[] $dhlProducts - Products
	 */
	private static $dhlProducts = array();

	/**
	 * Disabled Clone-Function
	 */
	private function __clone() { /* VOID */ }

	/**
	 * Disabled ProductInfo constructor.
	 */
	private function __construct() { /* VOID */ }

	/**
	 * Initiates the Class
	 */
	private static function init() {
		self::setInit(true);

		// Initiates Products
		$obj = new Product(ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE);
		$obj->setName('DHL Paket');
		$obj->setMinLength(15);
		$obj->setMaxLength(200);
		$obj->setMinWidth(11);
		$obj->setMaxWidth(200);
		$obj->setMinHeight(1);
		$obj->setMaxHeight(200);
		$obj->setMaxWeight(31.5);
		$obj->setServices(array(
			'preferredNeighbourEnabled',
			'preferredLocationEnabled',
			'visualCheckOfAgeEnabled',
			'personalHandover',
			'namedPersonOnly',
			'identCheckEnabled',
			'preferredDayEnabled',
			'preferredTimeEnabled',
			'disableNeighbourDelivery',
			'goGreen',
			'additionalInsuranceEnabled',
			'bulkyGoods',
			'cashOnDeliveryEnabled',
			'individualSenderRequiredmentsEnabled',
			'packagingReturn',
			'noticeNonDeliverability'
		));
		self::addProduct($obj);

		$obj = new Product(ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE_PRIO);
		$obj->setName('DHL Paket PRIO');
		$obj->setMinLength(15);
		$obj->setMaxLength(200);
		$obj->setMinWidth(11);
		$obj->setMaxWidth(200);
		$obj->setMinHeight(1);
		$obj->setMaxHeight(200);
		$obj->setMaxWeight(31.5);
		$obj->setServices(array(
			'preferredNeighbourEnabled',
			'preferredLocationEnabled',
			'visualCheckOfAgeEnabled',
			'namedPersonOnly',
			'identCheckEnabled',
			'preferredDayEnabled',
			'preferredTimeEnabled',
			'disableNeighbourDelivery',
			'goGreen',
			'additionalInsuranceEnabled',
			'cashOnDeliveryEnabled',
			'individualSenderRequiredmentsEnabled',
			'packagingReturn',
			'noticeNonDeliverability'
		));
		self::addProduct($obj);

		$obj = new Product(ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE);
		$obj->setName('DHL Paket Taggleich');
		$obj->setMinLength(15);
		$obj->setMaxLength(200);
		$obj->setMinWidth(11);
		$obj->setMaxWidth(200);
		$obj->setMinHeight(1);
		$obj->setMaxHeight(200);
		$obj->setMaxWeight(31.5);
		$obj->setServices(array(
			'preferredNeighbourEnabled',
			'preferredLocationEnabled',
			'visualCheckOfAgeEnabled',
			'namedPersonOnly',
			'identCheckEnabled',
			'preferredDayEnabled',
			'preferredTimeEnabled',
			'disableNeighbourDelivery',
			'goGreen',
			'additionalInsuranceEnabled',
			'bulkyGoods',
			'cashOnDeliveryEnabled',
			'individualSenderRequiredmentsEnabled',
			'packagingReturn',
			'noticeNonDeliverability',
			'returnImmediatlyIfShipmentFailed'
		));
		self::addProduct($obj);

		$obj = new Product(ShipmentDetails::PRODUCT_TYPE_INTERNATIONAL_PACKAGE);
		$obj->setName('DHL Paket International');
		$obj->setMinLength(15);
		$obj->setMaxLength(120);
		$obj->setMinWidth(11);
		$obj->setMaxWidth(60);
		$obj->setMinHeight(1);
		$obj->setMaxHeight(60);
		$obj->setMaxWeight(31.5);
		$obj->setServices(array(
			'endorsementEnabled',
			'returnReceipt',
			'goGreen',
			'additionalInsuranceEnabled',
			'bulkyGoods',
			'cashOnDeliveryEnabled',
			'premium'
		));
		self::addProduct($obj);

		$obj = new Product(ShipmentDetails::PRODUCT_TYPE_EUROPA_PACKAGE);
		$obj->setName('DHL Europapaket');
		$obj->setMinLength(15);
		$obj->setMaxLength(120);
		$obj->setMinWidth(11);
		$obj->setMaxWidth(60);
		$obj->setMinHeight(3.5);
		$obj->setMaxHeight(60);
		$obj->setMaxWeight(31.5);
		$obj->setServices(array(
			'goGreen',
			'additionalInsuranceEnabled'
		));
		self::addProduct($obj);

		$obj = new Product(ShipmentDetails::PRODUCT_TYPE_PACKED_CONNECT);
		$obj->setName('DHL Paket Connect');
		$obj->setMinLength(15);
		$obj->setMaxLength(120);
		$obj->setMinWidth(11);
		$obj->setMaxWidth(60);
		$obj->setMinHeight(3.5);
		$obj->setMaxHeight(60);
		$obj->setMaxWeight(31.5);
		$obj->setServices(array(
			'goGreen',
			'additionalInsuranceEnabled',
			'bulkyGoods'
		));
		self::addProduct($obj);

		$obj = new Product(ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER);
		$obj->setName('DHL Kurier Taggleich');
		$obj->setMinLength(15);
		$obj->setMaxLength(200);
		$obj->setMinWidth(11);
		$obj->setMaxWidth(200);
		$obj->setMinHeight(1);
		$obj->setMaxHeight(200);
		$obj->setMaxWeight(31.5);
		$obj->setServices(array(
			'preferredNeighbourEnabled',
			'visualCheckOfAgeEnabled',
			'endorsementEnabled',
			'goGreen',
			'dayOfDeliveryEnabled',
			'deliveryTimeframeEnabled',
			'shipmentHandlingEnabled',
			'perishables',
			'individualSenderRequiredmentsEnabled'
		));
		self::addProduct($obj);

		$obj = new Product(ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER);
		$obj->setName('DHL Kurier Wunschzeit');
		$obj->setMinLength(15);
		$obj->setMaxLength(200);
		$obj->setMinWidth(11);
		$obj->setMaxWidth(200);
		$obj->setMinHeight(1);
		$obj->setMaxHeight(200);
		$obj->setMaxWeight(31.5);
		$obj->setServices(array(
			'preferredNeighbourEnabled',
			'visualCheckOfAgeEnabled',
			'endorsementEnabled',
			'goGreen',
			'dayOfDeliveryEnabled',
			'deliveryTimeframeEnabled',
			'shipmentHandlingEnabled',
			'perishables',
			'individualSenderRequiredmentsEnabled'
		));
		self::addProduct($obj);

		$obj = new Product(ShipmentDetails::PRODUCT_TYPE_AUSTRIA_PACKAGE);
		$obj->setName('DHL Paket Austria');
		$obj->setAustria(true);
		$obj->setMinLength(15);
		$obj->setMaxLength(120);
		$obj->setMinWidth(11);
		$obj->setMaxWidth(60);
		$obj->setMinHeight(1);
		$obj->setMaxHeight(60);
		$obj->setMaxWeight(31.5);
		$obj->setServices(array(
			'additionalInsuranceEnabled',
			'bulkyGoods',
			'cashOnDeliveryEnabled'
		));
		self::addProduct($obj);

		$obj = new Product(ShipmentDetails::PRODUCT_TYPE_CONNECT_PACKAGE);
		$obj->setName('DHL Paket Connect');
		$obj->setAustria(true);
		$obj->setMinLength(15);
		$obj->setMaxLength(120);
		$obj->setMinWidth(11);
		$obj->setMaxWidth(60);
		$obj->setMinHeight(3.5);
		$obj->setMaxHeight(60);
		$obj->setMaxWeight(31.5);
		$obj->setServices(array(
			'additionalInsuranceEnabled',
			'bulkyGoods',
			'cashOnDeliveryEnabled'
		));
		self::addProduct($obj);

		$obj = new Product(ShipmentDetails::PRODUCT_TYPE_AUSTRIA_INTERNATIONAL_PACKAGE);
		$obj->setName('DHL Paket International');
		$obj->setAustria(true);
		$obj->setMinLength(15);
		$obj->setMaxLength(120);
		$obj->setMinWidth(11);
		$obj->setMaxWidth(60);
		$obj->setMinHeight(1);
		$obj->setMaxHeight(60);
		$obj->setMaxWeight(31.5);
		$obj->setServices(array(
			'additionalInsuranceEnabled',
			'bulkyGoods',
			'cashOnDeliveryEnabled'
		));
		self::addProduct($obj);
	}

	/**
	 * Returns if the Object is initiated
	 *
	 * @return bool - Is this Object initiated
	 */
	private static function isInit() {
		return self::$init;
	}

	/**
	 * Set if the Object is initiated
	 *
	 * @param bool $init - Is this Object initiated
	 */
	private static function setInit($init) {
		self::$init = $init;
	}

	/**
	 * Get the DHL-Products
	 *
	 * @return Product[] - DHL-Product-Objects
	 */
	public static function getDhlProducts() {
		if(! self::isInit())
			self::init();

		return self::$dhlProducts;
	}

	/**
	 * Adds a Product to Info-Class
	 *
	 * @param Product $product - Product to add
	 */
	private static function addProduct($product) {
		self::$dhlProducts[$product->getType()] = $product;
	}

	/**
	 * Get the Product-Object by Type
	 *
	 * @param string $productType - ProductType
	 * @return Product|null - DHL-Product Object or null if not exists in Info-Class
	 */
	public static function getInfo($productType) {
		if(! self::isInit())
			self::init();

		if(! array_key_exists($productType, self::$dhlProducts))
			return null;

		return self::$dhlProducts[$productType];
	}
}
