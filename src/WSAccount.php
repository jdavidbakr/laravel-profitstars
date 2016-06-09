<?php

namespace jdavidbakr\ProfitStars;

class WSAccount {
	public $CustomerNumber;
	public $AccountType = 'Checking';
	public $NameOnAccount;
	public $AccountName;
	public $AccountNumber;
	public $RoutingNumber;
	public $BillAddress1 = null;
	public $BillAddress2 = null;
	public $BillCity = null;
	public $BillStateRegion = null;
	public $BillPostalCode = null;
	public $BillCountry = null;
	public $AccountReferenceID;
}
