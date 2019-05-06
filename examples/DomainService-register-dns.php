<?php

/**
 * This example registers a domain with custom nameservers.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include domainservice
require_once('Transip/DomainService.php');

try
{
	// obviously, there are several DNS entry types. these are defined in
	// the class constants for ease of use
	$dnsEntries[] = new Transip_DnsEntry('@', 86400,    Transip_DnsEntry::TYPE_A,     '80.69.67.46');
	$dnsEntries[] = new Transip_DnsEntry('@', 86400,    Transip_DnsEntry::TYPE_MX,    '10 @');
	$dnsEntries[] = new Transip_DnsEntry('@', 86400,    Transip_DnsEntry::TYPE_MX,    '20 relay.transip.nl.');
	$dnsEntries[] = new Transip_DnsEntry('ftp', 86400,  Transip_DnsEntry::TYPE_CNAME, '@');
	$dnsEntries[] = new Transip_DnsEntry('mail', 86400, Transip_DnsEntry::TYPE_CNAME, '@');
	$dnsEntries[] = new Transip_DnsEntry('www', 86400,  Transip_DnsEntry::TYPE_CNAME, '@');

	// you can now use the $dnsEntries array as the fourth parameter when instantiating
	// a new Transip_Domain. For example:
	$domain = new Transip_Domain('example.com', $nameservers = null, $contacts = null, $dnsEntries);
	$propositionNumber = Transip_DomainService::register($domain);
	echo 'The domain ' . $domain->name . ' has been requested with proposition number ' . $propositionNumber;
}
catch(SoapFault $f)
{
	// It is possible that an error occurs when connecting to the TransIP Soap API,
	// those errors will be thrown as a SoapFault exception.
	echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}

?>