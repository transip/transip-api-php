<?php

/**
 * This example sets the nameservers of a domain name.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include domainservice
require_once('Transip/DomainService.php');

// Create the nameserver entries we want
$nameservers = array();
$nameservers[] = new Transip_Nameserver('ns1.example.com');
$nameservers[] = new Transip_Nameserver('ns2.example.com', '');
// Since ns.thedomaintomodify.com is a subdomain of the domain we are saving,
// the nameserver needs a glue record (ipv4 required, ipv6 optional)
$nameservers[] = new Transip_Nameserver('ns.example.com', '99.99.99.99');

try
{
	// Save the nameservers in the transip system
	Transip_DomainService::setNameservers('example.com', $nameservers);
	echo 'The nameservers have been saved.';
}
catch(SoapFault $f)
{
	// It is possible that an error occurs when connecting to the TransIP Soap API,
	// those errors will be thrown as a SoapFault exception.
	echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
?>
