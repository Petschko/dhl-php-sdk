<?php
/**
 * Author: Peter Dragicevic [peter-91@hotmail.de]
 * Authors-Website: http://petschko.org/
 * Date: 26.01.2017
 * Time: 20:14
 * Update: -
 * Version: 0.0.1
 *
 * Notes: Contains DHL_BankData Class
 */

/**
 * Class DHL_BankData
 */
class DHL_BankData {
	/**
	 * Min-Len: -
	 * Max-Len: 80
	 *
	 * @var string $accountOwnerName
	 */
	private $accountOwnerName;

	/**
	 * Min-Len: -
	 * Max-Len: 80
	 *
	 * @var string $bankName
	 */
	private $bankName;

	/**
	 * Min-Len: -
	 * Max-Len: 34
	 *
	 * @var string $iban
	 */
	private $iban;

	/**
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null
	 */
	private $note1 = null;

	/**
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null
	 */
	private $note2 = null;

	/**
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 11
	 *
	 * @var string|null
	 */
	private $bic = null;

	/**
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null
	 */
	private $accountReference = null;

	/**
	 * DHL_BankData constructor.
	 */
	public function __construct() {
		// VOID
	}

	/**
	 * Clears Memory
	 */
	public function __destruct() {
		unset($this->accountOwnerName);
		unset($this->bankName);
		unset($this->iban);
		unset($this->note1);
		unset($this->note2);
		unset($this->bic);
		unset($this->accountReference);
	}

	/**
	 * @return string
	 */
	public function getAccountOwnerName() {
		return $this->accountOwnerName;
	}

	/**
	 * @param string $accountOwnerName
	 */
	public function setAccountOwnerName($accountOwnerName) {
		$this->accountOwnerName = $accountOwnerName;
	}

	/**
	 * @return string
	 */
	public function getBankName() {
		return $this->bankName;
	}

	/**
	 * @param string $bankName
	 */
	public function setBankName($bankName) {
		$this->bankName = $bankName;
	}

	/**
	 * @return string
	 */
	public function getIban() {
		return $this->iban;
	}

	/**
	 * @param string $iban
	 */
	public function setIban($iban) {
		$this->iban = $iban;
	}

	/**
	 * @return null|string
	 */
	public function getNote1() {
		return $this->note1;
	}

	/**
	 * @param null|string $note1
	 */
	public function setNote1($note1) {
		$this->note1 = $note1;
	}

	/**
	 * @return null|string
	 */
	public function getNote2() {
		return $this->note2;
	}

	/**
	 * @param null|string $note2
	 */
	public function setNote2($note2) {
		$this->note2 = $note2;
	}

	/**
	 * @return null|string
	 */
	public function getBic() {
		return $this->bic;
	}

	/**
	 * @param null|string $bic
	 */
	public function setBic($bic) {
		$this->bic = $bic;
	}

	/**
	 * @return null|string
	 */
	public function getAccountReference() {
		return $this->accountReference;
	}

	/**
	 * @param null|string $accountReference
	 */
	public function setAccountReference($accountReference) {
		$this->accountReference = $accountReference;
	}

	/**
	 * Returns a DHL-Bank-Class
	 *
	 * @return StdClass - DHL-Bank-Class
	 */
	public function getBankClass_v2() {
		$class = new StdClass;

		$class->accountOwner = $this->getAccountOwnerName();
		$class->bankName = $this->getBankName();
		$class->iban = $this->getIban();
		if($this->getNote1() !== null)
			$class->note1 = $this->getNote1();
		if($this->getNote2() !== null)
			$class->note2 = $this->getNote2();
		if($this->getBic() !== null)
			$class->bic = $this->getBic();
		if($this->getAccountReference() !== null)
			$class->accountreference = $this->getAccountReference();

		return $class;
	}
}
