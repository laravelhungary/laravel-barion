# Use the Barion API with Laravel

[![Travis](https://img.shields.io/travis/laravelhungary/laravel-barion.svg?style=flat-square)](https://travis-ci.org/laravelhungary/laravel-barion)
[![StyleCI](https://styleci.io/repos/72787922/shield?branch=master)](https://styleci.io/analyses/XZoNV6#)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/ec36151c-e892-46f4-9101-f83900bf3af2.svg?style=flat-square)](https://insight.sensiolabs.com/projects/ec36151c-e892-46f4-9101-f83900bf3af2)
[![license](https://img.shields.io/github/license/mashape/apistatus.svg?style=flat-square)](https://opensource.org/licenses/MIT)
[![Packagist](https://img.shields.io/packagist/v/laravelhungary/laravel-barion.svg?style=flat-square)](https://packagist.org/packages/laravelhungary/laravel-barion)

Laravel-Barion is provides an easy way to use the Barion API with Laravel applications.
Under the hood there is just a thin wrapper to make API calls simple.
 
## Installation

1. Install the package using composer: 

`composer require laravelhungary/laravel-barion`

2. Register the service provider in the `app.php` config file

```php
LaravelHungary\Barion\BarionServiceProvider::class,
```

3. Register the Barion facade (optional)

```php
'Barion' =>  LaravelHungary\Barion\BarionFacade::class
```

## Configuration

Laravel-Barion comes preconfigured, you only need to set your POS key in the
 .env file: 
 
 `BARION_POS_KEY=<my pos key>`
 
 The Barion environment defaults to `test.barion.com`. To use the live instead,
 set 
 
 `BARION_LIVE_ENV=true`.
 
 If you'd like to tweak the configuration values, publish 
 the config file:
 
 `artisan vendor:publish --provider="LaravelHungary\Barion\BarionServiceProvider"`

## Usage
You can either resolve the `Barion` class from the Service Container using Laravel's
dependency injection, or simply use the provided Facade.

There are two convenience methods for the two most-often used API calls:

#### Get the payment status
```php
Barion::getPaymentState('my-payment-id')
```

#### Start a Payment
```php
Barion::paymentStart([
    'PaymentType' => PaymentType::IMMEDIATE,
    'GuestCheckOut' => true,
    'FundingSources' => [FundingSource::ALL],
    'Locale' => Locale::HU,
    'Currency' => Currency::HUF,
    'Transactions' => [
        [
            'POSTransactionId' => 'ABC-1234',
            'Payee' => 'example@email.com',
            'Total' => 4990,
            'Items' => [
                [
                    'Name' => 'Example item',
                    'Description' => 'This is a sample description',
                    'Quantity' => 1,
                    'Unit' => 'db',
                    'UnitPrice' => 4990,
                    'ItemTotal' => 4990
                ]
            ]
         ]
    ]
])
```

All other API calls are accessible using either `get` or `post`:

```php
Barion::get('/api/url')
```

```php
Barion::post('/api/url', ['my-data' => 'some value'])
```

POS Key is automatically appended to each request.

## License
Laravel-Barion is open source software licensed under the [MIT License](https://opensource.org/licenses/MIT).

