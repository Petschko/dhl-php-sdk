<?php
/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: https://petschko.org/
 * Date: 06.02.2020
 * Time: 22:41
 *
 * Notes: Contains all deprecated information & methods
 */

namespace Petschko\DHL;

use Exception;

/**
 * Class Deprecated
 *
 * @package Petschko\DHL
 */
class Deprecated {
	const BUSINESS_SHIPMENT_BIG_FIELD_DEPRECATION_REASON = 'These details belong to the `ShipmentOrder` Object, please do them there';

	/**
	 * Deprecated constructor
	 */
	private function __construct() {
		// VOID
	}

	/**
	 * Deprecated clone
	 */
	private function __clone() {
		// VOID
	}

	/**
	 * Notes about a deprecated method
	 *
	 * @param string $method - Method-Name
	 * @param string|null $class - Class-Name or null for none
	 * @param string $message - Optional Message
	 */
	public static function methodIsDeprecated(string $method, $class = null, $message = '') {
		trigger_error(trim('[DHL-PHP-SDK]: Method ' . (($class) ? $class . '->' : '') . $method . ' is deprecated. ' . $message), E_USER_DEPRECATED);
		error_log(trim('[DHL-PHP-SDK]: Method ' . (($class) ? $class . '->' : '') . $method . ' is deprecated. ' . $message), E_USER_DEPRECATED);
	}

	/**
	 * Notes about a deprecated method, also throws an Exception
	 *
	 * @param string $method - Method-Name
	 * @param string|null $class - Class-Name or null for none
	 * @param string $message - Optional Message
	 * @throws Exception - Deprecated Exception
	 */
	public static function methodIsDeprecatedWithException(string $method, $class = null, $message = '') {
		self::methodIsDeprecated($method, $class, $message);

		throw new Exception(trim('[DHL-PHP-SDK]: Method ' . (($class) ? $class . '->' : '') . $method . ' is deprecated. ' . $message));
	}
}
