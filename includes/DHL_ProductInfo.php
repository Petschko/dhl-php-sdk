<?php
/**
 * Author: Maximilian Stark [mail@dakror.de]
 * Authors-Website: http://dakror.de/
 * Date: 07.06.2017
 * Time: 13:17
 * Version: 1.0.0
 *
 * Notes: Contains the DHL_Products class
 */

/**
 * Class DHL_ProductInfo
 */
class DHL_ProductInfo {
	public static $services = array(
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
	
	public static $dhl_products = array(
		DHL_ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE => array(
			'austria' => false,
			'name' => 'DHL Paket',
			'length' => array(
				'min' => 15,
				'max' => 200),
			'width' => array(
				'min' => 11,
				'max' => 200),
			'height' => array(
				'min' => 1,
				'max' => 200),
			'weight' => 31.5,
			'services' => array(
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
			)
		),

		'V01PRIO' => array(
			'austria' => false,
			'name' => 'DHL Paket PRIO',
			'length' => array(
				'min' => 15,
				'max' => 200),
			'width' => array(
				'min' => 11,
				'max' => 200),
			'height' => array(
				'min' => 1,
				'max' => 200),
			'weight' => 31.5,
			'services' => array(
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
			)
		),

		DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE => array(
			'austria' => false,
			'name' => 'DHL Paket Taggleich',
			'length' => array(
				'min' => 15,
				'max' => 200),
			'width' => array(
				'min' => 11,
				'max' => 200),
			'height' => array(
				'min' => 1,
				'max' => 200),
			'weight' => 31.5,
			'services' => array(
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
			)
		),

		DHL_ShipmentDetails::PRODUCT_TYPE_INTERNATIONAL_PACKAGE => array(
			'austria' => false,
			'name' => 'DHL Paket International',
			'length' => array(
				'min' => 15,
				'max' => 120),
			'width' => array(
				'min' => 11,
				'max' => 60),
			'height' => array(
				'min' => 1,
				'max' => 60),
			'weight' => 31.5,
			'services' => array(
				'endorsementEnabled',
				'returnReceipt',
				'goGreen',
				'additionalInsuranceEnabled',
				'bulkyGoods',
				'cashOnDeliveryEnabled',
				'premium'
			)
		),

		DHL_ShipmentDetails::PRODUCT_TYPE_EUROPA_PACKAGE => array(
			'austria' => false,
			'name' => 'DHL Europapaket',
			'length' => array(
				'min' => 15,
				'max' => 120),
			'width' => array(
				'min' => 11,
				'max' => 60),
			'height' => array(
				'min' => 3.5,
				'max' => 60),
			'weight' => 31.5,
			'services' => array(
				'goGreen',
				'additionalInsuranceEnabled')),

		'V55PAK' => array(
			'austria' => false,
			'name' => 'DHL Paket Connect',
			'length' => array(
				'min' => 15,
				'max' => 120),
			'width' => array(
				'min' => 11,
				'max' => 60),
			'height' => array(
				'min' => 3.5,
				'max' => 60),
			'weight' => 31.5,
			'services' => array(
				'goGreen',
				'additionalInsuranceEnabled',
				'bulkyGoods'
			)
		),

		DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER => array(
			'austria' => false,
			'name' => 'DHL Kurier Taggleich',
			'length' => array(
				'min' => 15,
				'max' => 200),
			'width' => array(
				'min' => 11,
				'max' => 200),
			'height' => array(
				'min' => 1,
				'max' => 200),
			'weight' => 31.5,
			'services' => array(
				'preferredNeighbourEnabled',
				'visualCheckOfAgeEnabled',
				'endorsementEnabled',
				'goGreen',
				'dayOfDeliveryEnabled',
				'deliveryTimeframeEnabled',
				'shipmentHandlingEnabled',
				'perishables',
				'individualSenderRequiredmentsEnabled'
			)
		),

		DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER => array(
			'austria' => false,
			'name' => 'DHL Kurier Wunschzeit',
			'length' => array(
				'min' => 15,
				'max' => 200),
			'width' => array(
				'min' => 11,
				'max' => 200),
			'height' => array(
				'min' => 1,
				'max' => 200),
			'weight' => 31.5,
			'services' => array(
				'preferredNeighbourEnabled',
				'visualCheckOfAgeEnabled',
				'endorsementEnabled',
				'goGreen',
				'dayOfDeliveryEnabled',
				'deliveryTimeframeEnabled',
				'shipmentHandlingEnabled',
				'perishables',
				'individualSenderRequiredmentsEnabled'
			)
		),

		DHL_ShipmentDetails::PRODUCT_TYPE_AUSTRIA_PACKAGE => array(
			'austria' => true,
			'name' => 'DHL Paket Austria',
			'length' => array(
				'min' => 15,
				'max' => 120),
			'width' => array(
				'min' => 11,
				'max' => 60),
			'height' => array(
				'min' => 1,
				'max' => 60),
			'weight' => 31.5,
			'services' => array(
				'additionalInsuranceEnabled',
				'bulkyGoods',
				'cashOnDeliveryEnabled'
			)
		),

		DHL_ShipmentDetails::PRODUCT_TYPE_CONNECT_PACKAGE => array(
			'austria' => true,
			'name' => 'DHL Paket Connect',
			'length' => array(
				'min' => 15,
				'max' => 120),
			'width' => array(
				'min' => 11,
				'max' => 60),
			'height' => array(
				'min' => 3.5,
				'max' => 60),
			'weight' => 31.5,
			'services' => array(
				'additionalInsuranceEnabled',
				'bulkyGoods',
				'cashOnDeliveryEnabled'
			)
		),

		DHL_ShipmentDetails::PRODUCT_TYPE_AUSTRIA_INTERNATIONAL_PACKAGE => array(
			'austria' => true,
			'name' => 'DHL Paket International',
			'length' => array(
				'min' => 15,
				'max' => 120),
			'width' => array(
				'min' => 11,
				'max' => 60),
			'height' => array(
				'min' => 1,
				'max' => 60),
			'weight' => 31.5,
			'services' => array(
				'additionalInsuranceEnabled',
				'bulkyGoods',
				'endorsementEnabled'
			)
		)
	);
}
