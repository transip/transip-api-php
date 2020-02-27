<a href="https://transip.eu" target="_blank">
    <img width="200px" src="https://www.transip.nl/img/cp/transip-logo.svg">
</a>

# RestAPI library for PHP

This library is a complete implementation for communicating with the TransIP RestAPI. It covers all resource calls available in the [TransIP RestAPI Docs](https://api.transip.nl/rest/docs.html) and it allows your project(s) to connect to the TransIP RestAPI easily. Using this library you can order, update and remove products from your TransIP account. 

[![Latest Stable Version](https://poser.pugx.org/transip/transip-api-php/v/stable?format=flat-square)](https://packagist.org/packages/transip/transip-api-php)
[![Total Downloads](https://poser.pugx.org/transip/transip-api-php/downloads?format=flat-square)](https://packagist.org/packages/transip/transip-api-php)
[![License](https://poser.pugx.org/transip/transip-api-php/license?format=flat-square)](https://packagist.org/packages/transip/transip-api-php)

#### Deprecated SOAP API library (v5.x)
As of version 6.0 this library is no longer compatible with TransIP SOAP API because the library is now organized around REST. The SOAP API library versions 5.* are now deprecated and will no longer receive future updates.

## Requirements

The PHP RestAPI library requires the following in order to work properly:

* PHP 7.2.0 or later.
* [json](https://www.php.net/manual/en/book.json.php) (php extension)
* [openssl](https://www.php.net/manual/en/book.openssl.php) (php extension)

## Composer
You can install the RestAPI library using [Composer](http://getcomposer.org/). Run the following command:
```bash
composer require transip/transip-api-php
```
To use the library in your code, use Composer's [autoloader](https://getcomposer.org/doc/01-basic-usage.md#autoloading):
```php
require_once('vendor/autoload.php');
```

## Getting started
How to get authenticated:
```php
use Transip\Api\Library\TransipAPI;

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

## Get all domains
```php
$allDomains = $api->domains()->getAll();
```

## Update a single DNS record
```php
$homeIpAddress = '37.97.254.1'; 

$dnsEntry = new \Transip\Api\Library\Entity\Domain\DnsEntry();
$dnsEntry->setName('homeip'); // subdomain
$dnsEntry->setExpire(300);
$dnsEntry->setType('A');
$dnsEntry->setContent($homeIpAddress);

$api->domainDns()->updateEntry('example.com', $dnsEntry);
```

For basic examples, please take a look into the `examples/` directory. You can also see all resource calls implemented in our [command line application](https://github.com/transip/tipctl#how-php-resource-calls-are-implemented)
