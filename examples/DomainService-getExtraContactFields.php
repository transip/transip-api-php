<?php

/**
 * This example gets all optional contact fields if they are required for the given domain.
 *
 * @copyright Copyright 2020 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include domainservice
require_once('Transip/DomainService.php');

// Example domain with extra contact fields
$domain = 'example.com';

// Set the result variable
$extraContactFields = [];

try {
    // Call the API, the result will be an array of all required extra contact fields for the domain.
    // Empty array will be returned if no extra fields are required.
    $extraContactFields = Transip_DomainService::getExtraContactFields($domain);

    print_r($extraContactFields);
} catch (SoapFault $e) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $e->getMessage(), PHP_EOL;
}
