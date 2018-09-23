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
 *
 * @package Petschko\DHL
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
	 * @var string[] $services - All Services for this Product
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
	 * Get the Product-Type
	 *
	 * @return string - Product-Type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Set the Product-Type
	 *
	 * @param string $type - Product-Type
	 */
	private function setType($type) {
		$this->type = $type;
	}

	/**
	 * Get the Name
	 *
	 * @return string - Name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Set the Name
	 *
	 * @param string $name - Name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Shows if send to Austria is allowed
	 *
	 * @return bool - Is send to Austria allowed
	 */
	public function isAustria() {
		return $this->austria;
	}

	/**
	 * Set if send to Austria is allowed
	 *
	 * @param bool $austria - Is send to Austria allowed
	 */
	public function setAustria($austria) {
		$this->austria = $austria;
	}

	/**
	 * Get the Min-Length
	 *
	 * @return float|int - Min-Length
	 */
	public function getMinLength() {
		return $this->minLength;
	}

	/**
	 * Set the Min-Length
	 *
	 * @param float|int $minLength - Min-Length
	 */
	public function setMinLength($minLength) {
		$this->minLength = $minLength;
	}

	/**
	 * Get the Max-Length
	 *
	 * @return float|int - Max-Length
	 */
	public function getMaxLength() {
		return $this->maxLength;
	}

	/**
	 * Set the Max-Length
	 *
	 * @param float|int $maxLength - Max-Length
	 */
	public function setMaxLength($maxLength) {
		$this->maxLength = $maxLength;
	}

	/**
	 * Get the Min-Width
	 *
	 * @return float|int - Min-Width
	 */
	public function getMinWidth() {
		return $this->minWidth;
	}

	/**
	 * Set the Min-Width
	 *
	 * @param float|int $minWidth - Min-Width
	 */
	public function setMinWidth($minWidth) {
		$this->minWidth = $minWidth;
	}

	/**
	 * Get the Max-Width
	 *
	 * @return float|int - Max-Width
	 */
	public function getMaxWidth() {
		return $this->maxWidth;
	}

	/**
	 * Set the Max-Width
	 *
	 * @param float|int $maxWidth - Max-Width
	 */
	public function setMaxWidth($maxWidth) {
		$this->maxWidth = $maxWidth;
	}

	/**
	 * Get the Min-Height
	 *
	 * @return float|int - Min-Height
	 */
	public function getMinHeight() {
		return $this->minHeight;
	}

	/**
	 * Set the Min-Height
	 *
	 * @param float|int $minHeight - Min-Height
	 */
	public function setMinHeight($minHeight) {
		$this->minHeight = $minHeight;
	}

	/**
	 * Get the Max-Height
	 *
	 * @return float|int - Max-Height
	 */
	public function getMaxHeight() {
		return $this->maxHeight;
	}

	/**
	 * Set the Max-Height
	 *
	 * @param float|int $maxHeight - Max-Height
	 */
	public function setMaxHeight($maxHeight) {
		$this->maxHeight = $maxHeight;
	}

	/**
	 * Get the Max-Weight
	 *
	 * @return float|int - Max-Weight
	 */
	public function getMaxWeight() {
		return $this->maxWeight;
	}

	/**
	 * Set the Max-Weight
	 *
	 * @param float|int $maxWeight - Max-Weight
	 */
	public function setMaxWeight($maxWeight) {
		$this->maxWeight = $maxWeight;
	}

	/**
	 * Get the Services
	 *
	 * @return string[] - Services
	 */
	public function getServices() {
		return $this->services;
	}

	/**
	 * Set Services
	 *
	 * @param string[] $services - Services
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
