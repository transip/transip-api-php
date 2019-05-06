<?php

/**
 * This example obtains the dnssec entries of a domain using the DnsService
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include dnsservice
require_once('Transip/DnsService.php');

$domainName = 'example.com';

try {
    // Get the dnssec entries from the transip system
    $entries = Transip_DnsService::getDnsSecEntries($domainName);
    var_dump($entries);
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
