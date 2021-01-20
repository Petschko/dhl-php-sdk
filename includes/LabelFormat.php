<?php
/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: https://petschko.org/
 * Date: 09.06.2019
 * Time: 16:05
 *
 * Notes: Contains the class for the Label-Format
 */

namespace Petschko\DHL;

use stdClass;

/**
 * Class LabelFormat
 *
 * @package Petschko\DHL
 * @since 3.0
 */
class LabelFormat {
	/**
	 * DHL uses sometimes strings instead of int values for true/false, these are set here
	 */
	const DHL_FALSE_STR = 'False';
	const DHL_TRUE_STR = 'True';

	/**
	 * DHL-Label-Format Values
	 */
	const FORMAT_DEFAULT = 'GUI';
	const FORMAT_A4 = 'A4';
	const FORMAT_910_300_700 = '910-300-700';
	const FORMAT_910_300_700_OZ = '910-300-700-oZ';
	const FORMAT_910_300_600 = '910-300-600';
	const FORMAT_910_300_610 = '910-300-610';
	const FORMAT_910_300_710 = '910-300-710';

	/**
	 * Contains the Group-Profile name - Choose between multiple user groups.
	 *
	 * Note: Optional
	 *
	 * @var string|null $groupProfileName - Group-Profile name (null uses default)
	 */
	private $groupProfileName = null;

	/**
	 * Contains the Label-Format
	 *
	 * Note: Optional
	 *
	 * Values:
	 * A4
	 * 910-300-700
	 * 910-300-700-oZ
	 * 910-300-600
	 * 910-300-610
	 * 910-300-710
	 *
	 * @var string|null $labelFormat - Label-Format (null uses default)
	 */
	private $labelFormat = null;

	/**
	 * Contains the Return-Label-Format
	 *
	 * Note: Optional
	 * Values:
	 * A4
	 * 910-300-700
	 * 910-300-700-oZ
	 * 910-300-600
	 * 910-300-610
	 * 910-300-710
	 *
	 * @var string|null $labelFormatRetoure - Return-Label-Format (null uses default)
	 */
	private $labelFormatRetoure = null;

	/**
	 * Contains if Shipment label and return label get printed together
	 *
	 * Note: Optional
	 *
	 * @var bool|null $combinedPrinting - Are both labels printed together (null uses default)
	 */
	private $combinedPrinting = null;

	/**
	 * Has no use currently
	 *
	 * Note: Optional
	 *
	 * @var string|null $feederSystem - Unused
	 */
	private $feederSystem = null;

	/**
	 * Get the Group-Profile name - Choose between multiple user groups
	 *
	 * @return string|null - Group-Profile name | null uses default from DHL
	 */
	public function getGroupProfileName(): ?string {
		return $this->groupProfileName;
	}

	/**
	 * Set the Group-Profile name - Choose between multiple user groups
	 *
	 * @param string|null $groupProfileName - Group-Profile name | null uses default from DHL
	 */
	public function setGroupProfileName(?string $groupProfileName): void {
		$this->groupProfileName = $groupProfileName;
	}

	/**
	 * Get the Label-Format
	 *
	 * @return string|null - Label-Format | null uses default from DHL
	 */
	public function getLabelFormat(): ?string {
		return $this->labelFormat;
	}

	/**
	 * Set the Label-Format
	 *
	 * @param string|null $labelFormat - Label-Format | null uses default from DHL
	 */
	public function setLabelFormat(?string $labelFormat): void {
		$this->labelFormat = $labelFormat;
	}

	/**
	 * Get the Return-Label-Format
	 *
	 * @return string|null - Return-Label-Format | null uses default from DHL
	 */
	public function getLabelFormatRetoure(): ?string {
		return $this->labelFormatRetoure;
	}

	/**
	 * Get the Return-Label-Format
	 *
	 * @param string|null $labelFormatRetoure - Return-Label-Format | null uses default from DHL
	 */
	public function setLabelFormatRetoure(?string $labelFormatRetoure): void {
		$this->labelFormatRetoure = $labelFormatRetoure;
	}

	/**
	 * Get if both labels (label & return label) should printed together
	 *
	 * @return bool|null - Should labels printed together | null uses default from DHL
	 */
	public function getCombinedPrinting(): ?bool {
		return $this->combinedPrinting;
	}

	/**
	 * Set if both labels (label & return label) should printed together
	 *
	 * @param bool|null $combinedPrinting - Should labels printed together | null uses default from DHL
	 */
	public function setCombinedPrinting(?bool $combinedPrinting): void {
		$this->combinedPrinting = $combinedPrinting;
	}

	/**
	 * Get the FeederSystem value - Unused
	 *
	 * @return string|null - Unused | null uses default from DHL
	 */
	private function getFeederSystem(): ?string {
		return $this->feederSystem;
	}

	/**
	 * Set the FeederSystem value - Unused
	 *
	 * @param string|null $feederSystem - Unused | null uses default from DHL
	 */
	private function setFeederSystem(?string $feederSystem): void {
		$this->feederSystem = $feederSystem;
	}

	/**
	 * Get the value for the Label (needs a string)
	 *
	 * @return string|null - DHL-Bool string or null for default
	 */
	public function getCombinedPrintingLabel(): ?string {
		if($this->getCombinedPrinting() === null)
			return null;

		return ($this->getCombinedPrinting()) ? self::DHL_TRUE_STR : self::DHL_FALSE_STR;
	}

	/**
	 * Gets the Label-Format-Class for Version 3
	 *
	 * @param StdClass $classToExtend - Class to extend with this info
	 * @return StdClass - Label-Format-Class
	 * @since 3.0
	 */
	public function addLabelFormatClass_v3($classToExtend) {
		if($this->getGroupProfileName() !== null)
			$classToExtend->groupProfileName = $this->getGroupProfileName();
		if($this->getLabelFormat() !== null)
			$classToExtend->labelFormat = $this->getLabelFormat();
		if($this->getLabelFormatRetoure() !== null)
			$classToExtend->labelFormatRetoure = $this->getLabelFormatRetoure();
		if($this->getCombinedPrinting() !== null)
			$classToExtend->combinedPrinting = $this->getCombinedPrintingLabel();
		if($this->getFeederSystem() !== null)
			$classToExtend->feederSystem = $this->getFeederSystem();

		return $classToExtend;
	}
}
