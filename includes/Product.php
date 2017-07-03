<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 10.06.2017
 * Time: 19:34
 *
 * Notes: Contains Product-Class
 */

/**
 * Class Product
 */
class Product {
	/**
	 * Contains the Product-Type
	 *
	 * @var string $type - Product-Type
	 */
	private $type;

	/**
	 * Contains the Name of the Product
	 *
	 * @var string $name - Name of the Product
	 */
	private $name = '';

	/**
	 * Can this Product Send to Austria
	 *
	 * @var boolean $austria - Is send to Austria allowed
	 */
	private $austria = false;

	/**
	 * Contains the Min-Length of this Product
	 *
	 * @var float|int $minLength - Min-Length of this Product
	 */
	private $minLength = 0;

	/**
	 * Contains the Max-Length of this Product
	 *
	 * @var float|int $maxLength - Max-Length of this Product
	 */
	private $maxLength = 0;

	/**
	 * Contains the Min-Width of this Product
	 *
	 * @var float|int $minWidth - Min-Width of this Product
	 */
	private $minWidth = 0;

	/**
	 * Contains the Max-Width of this Product
	 *
	 * @var float|int $maxWidth - Max-Width of this Product
	 */
	private $maxWidth = 0;

	/**
	 * Contains the Min-Height of the Product
	 *
	 * @var float|int $minHeight - Min-Height of the Product
	 */
	private $minHeight = 0;

	/**
	 * Contains the Max-Height of the Product
	 *
	 * @var float|int $maxHeight - Max-Height of the Product
	 */
	private $maxHeight = 0;

	/**
	 * Contains the Max-Weight of this Product
	 *
	 * @var float|int $maxWeight - Max-Weight of this Product
	 */
	private $maxWeight = 0;

	/**
	 * Contains all Services for this Product
	 *
	 * @var array $services - All Services for this Product
	 */
	private $services = array();

	/**
	 * Product constructor.
	 *
	 * @param string $type - Product-Type
	 */
	public function __construct($type) {
		$this->setType($type);
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		unset($this->type);
		unset($this->name);
		unset($this->austria);
		unset($this->minLength);
		unset($this->maxLength);
		unset($this->minWidth);
		unset($this->maxWidth);
		unset($this->minHeight);
		unset($this->maxHeight);
		unset($this->maxWeight);
		unset($this->services);
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	private function setType($type) {
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return bool
	 */
	public function isAustria() {
		return $this->austria;
	}

	/**
	 * @param bool $austria
	 */
	public function setAustria($austria) {
		$this->austria = $austria;
	}

	/**
	 * @return float|int
	 */
	public function getMinLength() {
		return $this->minLength;
	}

	/**
	 * @param float|int $minLength
	 */
	public function setMinLength($minLength) {
		$this->minLength = $minLength;
	}

	/**
	 * @return float|int
	 */
	public function getMaxLength() {
		return $this->maxLength;
	}

	/**
	 * @param float|int $maxLength
	 */
	public function setMaxLength($maxLength) {
		$this->maxLength = $maxLength;
	}

	/**
	 * @return float|int
	 */
	public function getMinWidth() {
		return $this->minWidth;
	}

	/**
	 * @param float|int $minWidth
	 */
	public function setMinWidth($minWidth) {
		$this->minWidth = $minWidth;
	}

	/**
	 * @return float|int
	 */
	public function getMaxWidth() {
		return $this->maxWidth;
	}

	/**
	 * @param float|int $maxWidth
	 */
	public function setMaxWidth($maxWidth) {
		$this->maxWidth = $maxWidth;
	}

	/**
	 * @return float|int
	 */
	public function getMinHeight() {
		return $this->minHeight;
	}

	/**
	 * @param float|int $minHeight
	 */
	public function setMinHeight($minHeight) {
		$this->minHeight = $minHeight;
	}

	/**
	 * @return float|int
	 */
	public function getMaxHeight() {
		return $this->maxHeight;
	}

	/**
	 * @param float|int $maxHeight
	 */
	public function setMaxHeight($maxHeight) {
		$this->maxHeight = $maxHeight;
	}

	/**
	 * @return float|int
	 */
	public function getMaxWeight() {
		return $this->maxWeight;
	}

	/**
	 * @param float|int $maxWeight
	 */
	public function setMaxWeight($maxWeight) {
		$this->maxWeight = $maxWeight;
	}

	/**
	 * @return array
	 */
	public function getServices() {
		return $this->services;
	}

	/**
	 * @param array $services
	 */
	public function setServices($services) {
		$this->services = $services;
	}

	/**
	 * Adds a Service
	 *
	 * @param string $service - Service to add
	 */
	public function addService($service) {
		$this->services[] = $service;
	}

	/**
	 * Checks if this Products has a Service
	 *
	 * @param string $service - Service to check
	 * @return bool - Has this Product this Service
	 */
	public function hasService($service) {
		return in_array($service, $this->services);
	}
}
