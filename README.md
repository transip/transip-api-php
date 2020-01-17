# TransIP PHP RestAPI Library 

## Requirements
PHP 7.1 and later.

## Composer
You can install the RestAPI Library using [Composer](http://getcomposer.org/). Run the following command:
```bash
composer require transip/restapi-php-library
```
To use the library in your code, use Composer's [autoloader](https://getcomposer.org/doc/01-basic-usage.md#autoloading):
```php
require_once('vendor/autoload.php');
```

## Dependencies
The PHP RestAPI Library requires the following extensions in order to work properly:
* [json](https://www.php.net/manual/en/book.json.php)
* [openssl](https://www.php.net/manual/en/book.openssl.php)

Please ensure that these PHP extensions are installed on your web server.

## Getting started
How to get authenticated:
```php
use Transip\Api\Client\TransipAPI;

require_once(__DIR__ . '/vendor/autoload.php');

// Your login name on the TransIP website.
$login = '';

// If the generated token should only be usable by whitelisted IP addresses in your Controlpanel
$generateWhitelistOnlyTokens = true;

// One of your private keys; these can be requested via your Controlpanel
$privateKey = '';

$api = new TransipAPI(
    $login,
    $privateKey,
    $generateWhitelistOnlyTokens
);

// Create a test connection to the api
$response = $api->test()->test();

if ($response === true) {
    echo 'API connection successful!';
}
```

Look into the examples/ directory for further information on how to use the PHP RestAPI Library.

## Documentation
See the [TransIP RestAPI docs](https://api.transip.nl/rest/docs.html)

# License
MIT License
