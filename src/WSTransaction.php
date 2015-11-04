<?php 

namespace jdavidbakr\ProfitStars;

class WSTransaction {
	public $PaymentOrigin = 'Internet';
	public $AccountType = 'Checking';
	public $OperationType = 'Sale';
	public $SettlementType = 'ACH';
	public $EffectiveDate;
	public $Description = null;
	public $TotalAmount;
	public $TerminalNumber = '__WebService';
	public $TransactionNumber;
	public $RoutingNumber;
	public $AccountNumber;
	public $NameOnAccount;
	public $BillingAddress1 = null;
	public $BillingAddress2 = null;
	public $BillingCity = null;
	public $BillingStateRegion = null;
	public $BillingPostalCode = null;
	public $BillingCountry = null;
	public $BillingPhone = null;
	public $IpAddressOfOriginator = null;
	public $EmailAddress = null;

}
