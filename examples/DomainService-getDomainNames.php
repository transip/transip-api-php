<?php

/**
 * This example gets information about a domain name.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */


// Include domainservice
require_once('Transip/DomainService.php');

// Set the result variable
$domainList = array();

try
{
	// Call the API, the result will be an array of all your domain names
	$domainList = Transip_DomainService::getDomainNames();

	// Output the domain names
	print_r($domainList);
}
catch(SoapFault $e)
{
		// It is possible that an error occurs when connecting to the TransIP Soap API,
		// those errors will be thrown as a SoapFault exception.
		echo 'An error occurred: ' . $e->getMessage(), PHP_EOL;
}

?>
