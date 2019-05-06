<?php

/**
 * This example registers a domain with custom nameservers.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */


try
{
	// Include domainservice
	require_once('Transip/DomainService.php');

	// setting nameservers can be done in a few ways
	// default nameservers require only the hostname
	$nameservers[] = new Transip_Nameserver('ns1.transip.nl');

	// if the hostname is a subdomain of the domain we are setting the nameservers
	// for, a gluerecord is required. ipv4 is required, ipv6 is optional.

	// without ipv6
	$nameservers[] = new Transip_Nameserver('ns1.yourdomain.com', '127.0.0.1');

	// with ipv6 (both adresses point to localhost)
	$nameservers[] = new Transip_Nameserver('ns2.yourdomain.com', '127.0.0.1', '::1');

	// you can now use the $nameservers array as the second parameter when instantiating
	// a new Transip_Domain. For example:
	$domain = new Transip_Domain('example.com', $nameservers);
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