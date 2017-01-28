<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
 * Authors-Website: http://petschko.org/
 * Date: 26.01.2017
 * Time: 15:04
 * Update: -
 * Version: 0.0.1
 *
 * Notes: Contains all Version-Specific Functions
 */

/**
 * Class DHL_Version
 */
abstract class DHL_Version {
	/**
	 * Current-Version
	 *
	 * @var string $version - Current-Version
	 */
	private $version;

	/**
	 * Mayor-Version-Number
	 *
	 * @var int $mayor - Mayor-Version-Number
	 */
	private $mayor;

	/**
	 * Minor-Version-Number
	 *
	 * @var int $minor - Minor-Version-Number
	 */
	private $minor;

	/**
	 * DHL_Version constructor.
	 *
	 * @param string $version
	 */
	protected function __construct($version) {
		$this->setVersion($version);
	}

	/**
	 * Clears Memory
	 */
	protected function __destruct() {
		unset($this->version);
		unset($this->mayor);
		unset($this->minor);
	}

	/**
	 * @return string
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * Set/Change the Version and also Update Mayor and Minor-Fields
	 *
	 * @param string $version - Version
	 */
	protected function setVersion($version) {
		$this->version = $version;

		$numbers = explode('.', $version);

		// Update Mayor and Minor-Version-Numbers
		$this->setMayor((int) $numbers[0]);
		$this->setMinor((int) $numbers[1]);
	}

	/**
	 * @return int
	 */
	public function getMayor() {
		return $this->mayor;
	}

	/**
	 * @param int $mayor
	 */
	private function setMayor($mayor) {
		$this->mayor = $mayor;
	}

	/**
	 * @return int
	 */
	public function getMinor() {
		return $this->minor;
	}

	/**
	 * @param int $minor
	 */
	private function setMinor($minor) {
		$this->minor = $minor;
	}

	/**
	 * Returns the Version DHL-Class
	 *
	 * @return StdClass - Version DHL-Class
	 */
	protected function getVersionClass() {
		$class = new StdClass;

		$class->majorRelease = $this->getMayor();
		$class->minorRelease = $this->getMinor();

		return $class;
	}

	/**
	 * Gets the API-URL by Version
	 *
	 * @return string - API-Url
	 */
	protected abstract function getAPIUrl();
}
