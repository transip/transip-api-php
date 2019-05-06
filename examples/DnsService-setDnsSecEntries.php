<?php

/**
 * This example changes the dnssec entries of a domain using the DnsService
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include domainservice
require_once('Transip/DnsService.php');

$domainName = 'example.com';

$keyTag = '';
/**
 * @var $flag
 * @see Transip_DnsSecEntry::ALL_FLAGS
 */
$flag = '';
/**
 * @var $algorithm
 * @see Transip_DnsSecEntry::ALL_ALGORITHMS
 */
$algorithm = '';
$publicKey = '';

if (!Transip_DnsService::canEditDnsSec($domainName)) {
    die("Unable to update DNSSEC data.");
}

// Create the dnssec entries we want
$dnsSecEntries = [];
$dnsSecEntries[] = new Transip_DnsSecEntry(
    $keyTag,
    $flag,
    $algorithm,
    $publicKey
);

try {
    // Save the dnssec entries in the transip system
    Transip_DnsService::setDnsSecEntries($domainName, $dnsSecEntries);
    echo 'The DNSSEC Entries have been saved.';
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
