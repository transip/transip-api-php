<?php

/**
 * This example converts a backup to a snapshot for a given vps
 *
 * @copyright Copyright 2019 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    $vpsName             = 'example-vps';
    $snapshotDescription = 'My new snapshot';

    // Get disk backups for given vps
    $diskBackups         = Transip_VpsService::getVpsBackupsByVps($vpsName);
    // print_r($vpsBackups);
    $vpsDiskBackupId     = $diskBackups[0]->id;

    // Convert vps backup to a snapshot
    Transip_VpsService::convertVpsBackupToSnapshot($vpsName, $snapshotDescription, $vpsDiskBackupId);
    echo 'Starting backup to snapshot conversion';
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
