<?php

/**
 * This example reverts a backup for a given vps
 *
 * @copyright Copyright 2016 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try
{
    // Revert backup for vps
    Transip_VpsService::revertVpsBackup('vps-name', 'backup-id');
    echo 'Reverting backup';
}
catch(SoapFault $f)
{
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
