<?php

/**
 * This example will get a list for all available backups for a specific vps
 *
 * @copyright Copyright 2016 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    // Get backups
    $backupList = Transip_VpsService::getVpsBackupsByVps('vps-name');

    print_r($backupList);
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
