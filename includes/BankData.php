<?php

namespace Petschko\DHL;

/**
 * Author: Peter Dragicevic [peter@petschko.org]
 * Authors-Website: https://petschko.org/
 * Date: 26.01.2017
 * Time: 20:14
 *
 * Notes: Contains BankData Class
 */

use stdClass;

/**
 * Class BankData
 *
 * @package Petschko\DHL
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
	private $accountOwnerName = '';

	/**
	 * Name of the Bank
	 *
	 * Min-Len: -
	 * Max-Len: 80
	 *
	 * @var string $bankName - Name of the Bank
	 */
	private $bankName = '';

	/**
	 * IBAN of the Account
	 *
	 * Min-Len: -
	 * Max-Len: 34
	 *
	 * @var string $iban - IBAN of the Account
	 */
	private $iban = '';

	/**
	 * Purpose of bank information
	 *
	 * Note: Optional
	 *
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $note1 - Purpose of bank information | null for none
	 */
	private $note1 = null;

	/**
	 * Purpose of more bank information
	 *
	 * Note: Optional
	 *
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $note2 - Purpose of more bank information | null for none
	 */
	private $note2 = null;

	/**
	 * Bank-Information-Code (BankCCL) of bank account.
	 *
	 * Note: Optional
	 *
	 * Min-Len: -
	 * Max-Len: 11
	 *
	 * @var string|null $bic - Bank-Information-Code (BankCCL) of bank account | null for none
	 */
	private $bic = null;

	/**
	 * Account reference to customer profile
	 *
	 * Note: Optional
	 *
	 * Min-Len: -
	 * Max-Len: 35
	 *
	 * @var string|null $accountReference - Account reference to customer profile | null for none
	 */
	private $accountReference = null;

	/**
	 * BankData constructor.
	 */
	public function __construct() {
		// VOID
	}

	/**
	 * Get the Account Owner Name
	 *
	 * @return string - Account Owner Name
	 */
	public function getAccountOwnerName() {
		return $this->accountOwnerName;
	}

	/**
	 * Set the Account Owner Name
	 *
	 * @param string $accountOwnerName - Account Owner Name
	 */
	public function setAccountOwnerName($accountOwnerName) {
		$this->accountOwnerName = $accountOwnerName;
	}

	/**
	 * Get the Bank-Name
	 *
	 * @return string - Bank-Name
	 */
	public function getBankName() {
		return $this->bankName;
	}

	/**
	 * Set the Bank-Name
	 *
	 * @param string $bankName - Bank-Name
	 */
	public function setBankName($bankName) {
		$this->bankName = $bankName;
	}

	/**
	 * Get the IBAN
	 *
	 * @return string - IBAN
	 */
	public function getIban() {
		return $this->iban;
	}

	/**
	 * Set the IBAN
	 *
	 * @param string $iban - IBAN
	 */
	public function setIban($iban) {
		$this->iban = $iban;
	}

	/**
	 * Get additional Bank-Note (1)
	 *
	 * @return null|string - Bank-Note (1) or null for none
	 */
	public function getNote1() {
		return $this->note1;
	}

	/**
	 * Set addition Bank-Note (1)
	 *
	 * @param null|string $note1 - Bank-Note (1) or null for none
	 */
	public function setNote1($note1) {
		$this->note1 = $note1;
	}

	/**
	 * Get additional Bank-Note (2)
	 *
	 * @return null|string - Bank-Note (2) or null for none
	 */
	public function getNote2() {
		return $this->note2;
	}

	/**
	 * Set additional Bank-Note (2)
	 *
	 * @param null|string $note2 - Bank-Note (2) or null for none
	 */
	public function setNote2($note2) {
		$this->note2 = $note2;
	}

	/**
	 * Get the BIC
	 *
	 * @return null|string - BIC or null for none
	 */
	public function getBic() {
		return $this->bic;
	}

	/**
	 * Set the BIC
	 *
	 * @param null|string $bic - BIC or null for none
	 */
	public function setBic($bic) {
		$this->bic = $bic;
	}

	/**
	 * Get the Account reference
	 *
	 * @return null|string - Account reference or null for none
	 */
	public function getAccountReference() {
		return $this->accountReference;
	}

	/**
	 * Set the Account reference
	 *
	 * @param null|string $accountReference - Account reference or null for none
	 */
	public function setAccountReference($accountReference) {
		$this->accountReference = $accountReference;
	}

	/**
	 * Returns a DHL-Bank-Class for API v2
	 *
	 * @return StdClass - DHL-Bank-Class
	 * @since 2.0
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

	/**
	 * Returns a DHL-Bank-Class for API v3
	 *
	 * @return StdClass - DHL-Bank-Class
	 * @since 3.0
	 */
	public function getBankClass_v3() {
		return $this->getBankClass_v2();
	}
}
