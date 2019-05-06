<?php

/**
 * This example changes the dns entries of a domain using the DnsService
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include dnsservice
require_once('Transip/DnsService.php');

$domainName = 'example.com';

// Create the dns entries we want
$dnsEntries = [];
$dnsEntries[] = new Transip_DnsEntry('@', 86400, Transip_DnsEntry::TYPE_A, '127.0.0.1');
$dnsEntries[] = new Transip_DnsEntry('www', 86400, Transip_DnsEntry::TYPE_CNAME, '@');
$dnsEntries[] = new Transip_DnsEntry('mail', 86400, Transip_DnsEntry::TYPE_CNAME, '@');
$dnsEntries[] = new Transip_DnsEntry('@', 86400, Transip_DnsEntry::TYPE_MX, '10 mail.');

try {
    // Save the dns entries in the transip system
    Transip_DnsService::setDnsEntries($domainName, $dnsEntries);
    echo 'The DNS Entries have been saved.';
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
