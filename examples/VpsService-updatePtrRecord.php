<?php

/**
 * This example updates a Ptr Record for a IP address
 *
 * @copyright Copyright 2013 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try
{
	// Update the PTR Record for a IP
	Transip_VpsService::updatePtrRecord('ip-address','ptr-string');
    echo 'ptr string updated';
}
catch(SoapFault $f)
{
	// It is possible that an error occurs when connecting to the TransIP Soap API,
	// those errors will be thrown as a SoapFault exception.
	echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
