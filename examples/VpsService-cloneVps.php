<?php

/**
 * This example clones a vps.
 *
 * @copyright Copyright 2016 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try
{
	// clone this VPS to a new VPS with the same specs
	Transip_VpsService::cloneVps('vps-name');
	echo 'The vps clone has been started.';
}
catch(SoapFault $f)
{
	// It is possible that an error occurs when connecting to the TransIP Soap API,
	// those errors will be thrown as a SoapFault exception.
	echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
