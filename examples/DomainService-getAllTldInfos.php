<?php

/**
 * This example gets information about the Tlds that
 * can be registered or transfered.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */


// Include domainservice
require_once('Transip/DomainService.php');

try
{
	// Call the API, the result will be an array of all Tlds
	$tldList = Transip_DomainService::getAllTldInfos();

	// Output the Tlds
	print_r($tldList);
}
catch(SoapFault $f)
{
	// It is possible that an error occurs when connecting to the TransIP Soap API,
	// those errors will be thrown as a SoapFault exception.
	echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}

?>
