<?php

namespace jdavidbakr\ProfitStars;

class WSRecurr {
	public $CustomerNumber;
	public $AccountReferenceID;
	public $Description = null;
	public $Amount;
	public $InvoiceNumber = null;
	public $Frequency = "Once_a_Month";
	public $PaymentDay;
	public $StartDate;
	public $NumPayments;
	public $PaymentsToDate;
	public $NotificationMethod;
	public $NextPaymentDate;
	public $Enabled = 1;
	public $RecurringReferenceID;
}
