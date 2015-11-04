# laravel-profitstars

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Jack Henry ProfitStars provides an API for handling ACH transactions. This package is a Laravel wrapper
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

Then publish the config file:

``` bash
php artisan vendor:publish
```

This will place a file in the config directory that will manage your connection credentials.

## Usage

``` php

```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

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
[ico-travis]: https://img.shields.io/travis/thephpleague/laravel-profitstars/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/thephpleague/laravel-profitstars.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/thephpleague/laravel-profitstars.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/jdavidbakr/laravel-profitstars.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/jdavidbakr/laravel-profitstars
[link-travis]: https://travis-ci.org/thephpleague/laravel-profitstars
[link-scrutinizer]: https://scrutinizer-ci.com/g/thephpleague/laravel-profitstars/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/thephpleague/laravel-profitstars
[link-downloads]: https://packagist.org/packages/jdavidbakr/laravel-profitstars
[link-author]: https://github.com/jdavidbakr
[link-contributors]: ../../contributors
