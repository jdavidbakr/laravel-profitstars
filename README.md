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

## Usage

``` php
$proc = new \jdavidbakr\ProfitStars\ProcessTransaction;
$trans = new \jdavidbakr\ProfitStars\WSTransaction;

// Test connection
if($proc->TestConnection()) {
	// Success
}

// Test credentials
if($proc->TestCredentials()) {
	// Success
}

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
