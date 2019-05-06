<?php

/**
 * This example fetches all domain names which have a webhosting package enabled.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include webhosting service
require_once('Transip/WebhostingService.php');

// Set the result variable
$webhostingList = array();

try
{
	// Call the API, the result will be an array of all your webhosting names
	$webhostingList = Transip_WebhostingService::getWebhostingDomainNames();

	// Output the webhosting names
	print_r($webhostingList);
}
catch(SoapFault $e)
{
		// It is possible that an error occurs when connecting to the TransIP Soap API,
		// those errors will be thrown as a SoapFault exception.
		echo 'An error occurred: ' . $e->getMessage(), PHP_EOL;
}

?>