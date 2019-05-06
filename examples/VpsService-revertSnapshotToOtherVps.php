<?php

/**
 * This example reverts a snapshot to a given vps
 *
 * @copyright Copyright 2016 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try
{
	// Revert snapshot taken from vps-name to destination-vps-name
	Transip_VpsService::revertSnapshotToOtherVps('vps-name', 'snapshot-name', 'destination-vps-name');
	echo 'Reverting snapshot from vps-name';
}
catch(SoapFault $f)
{
	// It is possible that an error occurs when connecting to the TransIP Soap API,
	// those errors will be thrown as a SoapFault exception.
	echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
