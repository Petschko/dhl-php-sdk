<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: http://petschko.org/
 * Date: 26.01.2017
 * Time: 20:14
 * Update: 14.07.2018
 * Version: 0.0.3
 *
 * Notes: Contains BankData Class
 */

use stdClass;

/**
 * Class BankData
 */
class BankData {
	/**
	 * Name of the Account-Owner
	 *
	 * Min-Len: -
	 * Max-Len: 80
	 *
	 * @var string $accountOwnerName - Account-Owner Name
	 */
	private $accountOwnerName;

	/**
	 * Name of the Bank
	 *
	 * Min-Len: -
	 * Max-Len: 80
	 *
	 * @var string $bankName - Name of the Bank
	 */
	private $bankName;

	/**
	 * IBAN of the Account
	 *
	 * Min-Len: -
	 * Max-Len: 34
	 *
	 * @var string $iban - IBAN of the Account
	 */
	private $iban;

	/**
	 * Purpose of bank information
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $note1 - Purpose of bank information or null for none
	 */
	private $note1 = null;

	/**
	 * Purpose of more bank information
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $note2 - Purpose of more bank information or null for none
	 */
	private $note2 = null;

	/**
	 * Bank-Information-Code (BankCCL) of bank account.
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 11
	 *
	 * @var string|null $bic - Bank-Information-Code (BankCCL) of bank account or null for none
	 */
	private $bic = null;

	/**
	 * Account reference to customer profile
	 *
	 * Note: Optional
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $accountReference - Account reference to customer profile
	 */
	private $accountReference = null;

	/**
	 * BankData constructor.
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
	 * Returns a DHL-Bank-Class for API v1
	 *
	 * @return stdClass - DHL-Bank-Class
	 *
	 * @deprecated - DHL-API-Version 1 Method
	 */
	public function getBankClass_v1() {
		trigger_error('[DHL-PHP-SDK]: Version 1 Methods are deprecated and will removed soon (Called method ' . __METHOD__ . ')!', E_USER_DEPRECATED);
		trigger_error('[DHL-PHP-SDK]: Called Version 1 Method: ' . __METHOD__ . ' is incomplete (does nothing)!', E_USER_WARNING);

		// TODO: Implement getBankClass_v1() method.

		return new StdClass;
	}

	/**
	 * Returns a DHL-Bank-Class for API v2
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
