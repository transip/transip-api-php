<?php

// Include domainservice
require_once('Transip/DomainService.php');

try
{
	// Register a domain with your default settings
	// It's also possible to register with custom settings,
	// for this the call should be like:
	// $domain = new Transip_Domain('transip.nl', <array of nameservers>, <array of contacts>,
	//                   <array of dns entries>);
	$domain = new Transip_Domain('transip.nl');
	$propositionNumber = Transip_DomainService::register($domain);
	echo 'The domain ' . $domain->name . ' has been requested with proposition number ' . $propositionNumber;
}
catch(SoapFault $e)
{
	// It is possible that an error occurs when connecting to the TransIP Soap API,
	// those errors will be thrown as a SoapFault exception.
	echo 'An error occured: '. $e->getMessage(), PHP_EOL;
}

?>