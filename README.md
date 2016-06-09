# laravel-profitstars

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

Jack Henry ProfitStars provides an API for handling ACH transactions. This package is a Laravel/Lumen wrapper
to access these transactions.

The package is currently not exhaustive in terms of what is available from the API; I have only implemented
parts of the API that are needed for my use.  That said, expanding this package should be fairly trivial
and if you should need additional pieces please feel free to modify and submit a pull request.

## Install

Via Composer

``` bash
$ composer require jdavidbakr/laravel-profitstars
```

After installing via Composer, add the service provider:

``` php
jdavidbakr\ProfitStars\ProfitStarsServiceProvider::class
```
###Laravel Configuration

Publish the config file:

``` bash
php artisan vendor:publish
```

This will place a file in the config directory that will manage your connection credentials. 

###Lumen Configuration

Add the following to your .env file:

```
PROFIT_STARS_STORE_ID=YOUR STORE ID
PROFIT_STARS_STORE_KEY=YOUR STORE KEY
PROFIT_STARS_ENTITY_ID=YOUR ENTITY ID
PROFIT_STARS_LOCATION_ID=YOUR LOCATION ID
```

## Usage - Testing

``` php
$proc = new \jdavidbakr\ProfitStars\ProcessTransaction;

// Test connection
if($proc->TestConnection()) {
	// Success
}

// Test credentials
if($proc->TestCredentials()) {
	// Success
}

```

## Usage - Processing Transactions

$proc = new \jdavidbakr\ProfitStars\ProcessTransaction;
$trans = new \jdavidbakr\ProfitStars\WSTransaction;

// AuthorizeTransaction
$trans->RoutingNumber = 111000025;
$trans->AccountNumber = 5637492437;
$trans->TotalAmount = 9.95;
$trans->TransactionNumber = 12334;
$trans->NameOnAccount = 'Joe Smith';
$trans->EffectiveDate = '2015-11-04';
if($proc->AuthorizeTransaction($tras)) {
	// ReferenceNumber in $proc->ReferenceNumber	
} else {
	// Error message in $proc->ResponseMessage
}

// CaptureTransaction
$proc->ReferenceNumber = 'reference number';
if($proc->CaptureTransaction(9.95)) {
	// Success 
} else {
	// Error message in $proc->ResponseMessage
}

// VoidTransaction
$proc->ReferenceNumber = 'reference number';
if($proc->VoidTransaction()) {
	// Success;
} else {
	// Error message in $proc->ResponseMessage
}

// RefundTransaction
$proc->ReferenceNumber = 'reference number';
if($proc->RefundTransaction()) {
	// Success, refund info in $proc->ResponseMessage
} else {
	// Error message in $proc->ResponseMessage
}

```

## Usage - Recurring Payments

```

$proc = new \jdavidbakr\ProfitStars\ProcessTransaction;
$recur = new \jdavidbakr\ProfitStars\WSRecurr;
$cust = new \jdavidbakr\ProfitStars\WSCustomer;
$account = new \jdavidbakr\ProfitStars\WSAccount;

// RegisterCustomer
$cust->IsCompany = false;
$cust->CustomerNumber = 12345;
$cust->FirstName = 'Alex';
$cust->LastName = 'Ramirez';
$cust->Email = 'test@example.com';
$cust->Address1 = '1234 N Sunny Ln';
$cust->City = 'Tulsa';
$cust->StateRegion = 'OK';
$cust->PostalCode = '12345';
if($proc->RegisterCustomer($cust)) {
	// Success;
} else {
	// Error message in $proc->ResponseMessage
}

// RegisterAccount
$account->CustomerNumber = 12345; // Should match the RegisterCustomer value
$account->NameOnAccount = 'Joe Smith';
$account->RoutingNumber = 111000025;
$account->AccountNumber = 5637492437;
$account->AccountReferenceID = 67890; // This must be unique and will be used to setup the recurring payment
if($proc->RegisterAccount($account)) {
	// Success
} else {
	// Error message in $proc->ResponseMessage
}

// SetupRecurringPayment
$recur->CustomerNumber = 12345; // What you used in RegisterCustomer
$recur->AccountReferenceID = 67890; // What you used in RegisterAccount
$recur->Amount = 1.23; // The amount that will be charged each time
$recur->InvoiceNumber = 09876; // Optional
$recur->Frequency = 'Once_a_Month'; // Once_a_Month, Twice_a_Month, Once_a_Week, Every_2_Weeks, Once_a_Quarter, Twice_a_Year, Once_a_Year
$recur->PaymentDay = 1; // See notes below
$recur->NumPayments = 10; // Valid values are 1 - 100, or 999 for indefinite
$recur->PaymentsToDate = 0; // Should be zero
$recur->NextPaymentDate = '2015-11-04'; // Must not be before tomorrow
$recur->RecurringReferenceID = 12345; // Must set a value here like you did in the customer and account calls
if($proc->SetupRecurringPayment($recur)) {
	// Success
} else {
	// Error message is $proc->ResponseMessage
}

```

### Recurring Notes

For recurring, a Customer Number and Account Reference ID is required.

The Frequency and the PaymentDay define the schedule of the recurring payment.  Payment Day is defined as follows:

* Once_a_Month: 1 - 31, or 32 for the last day of the month
* Once_a_Quarter: Same as above
* Twice_a_year: Same as above
* Once_a_Year: Same as above
* Twice_a_Month: 1 = 1st and 15th, 2 = 15th and last
* Once_a_Week: 0 - Sun, 1 = Mon, ... 5 = Fri, 6 = Sat
* Every_2_Weeks: same as Once_a_Week

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email me@jdavidbaker.com instead of using the issue tracker.

## Credits

- [J David Baker][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/jdavidbakr/laravel-profitstars.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/jdavidbakr/laravel-profitstars.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/jdavidbakr/laravel-profitstars
[link-downloads]: https://packagist.org/packages/jdavidbakr/laravel-profitstars
[link-author]: https://github.com/jdavidbakr
[link-contributors]: ../../contributors
