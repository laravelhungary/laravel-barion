# Use the Barion API from Laravel

Laravel-Barion is provides an easy way to use the Barion API with Laravel applications.
Under the hood there is just a thin wrapper to make API calls simple.
 
## Installation

1. Install the package using composer: 

`composer require laravelhungary/laravel-barion`

2. Register the service provider in the `app.php` config file

`LaravelHungary\Barion\BarionServiceProvider::class,`

3. Register the Barion facade (optional)

`'Barion' =>  LaravelHungary\Barion\BarionFacade::class`

## Configuration

Laravel-Barion comes preconfigured, you only need to set your POS key in the
 .env file: 
 
 `BARION_POS_KEY=<my pos key>`
 
 If you'd like to tweak the configuration values, publish 
 the config file:
 
 `artisan vendor:publish --provider="LaravelHungary\Barion\BarionServiceProvider"`

## Usage
You can either resolve the `Barion` class from the Service Container using Laravel's
dependency injection, or simply use the provided Facade.

There are two convenience methods for the two most-often used API calls:

#### Get the payment status
`Barion::getPaymentState('my-payment-id')`

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

`Barion::get('/api/url')`

`Barion::post('/api/url', ['my-data' => 'some value'])`

POS Key is automatically appended to each request.

## License
Laravel-Barion is open source software licensed under the [MIT License](https://opensource.org/licenses/MIT).

