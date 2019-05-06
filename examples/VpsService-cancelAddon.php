<?php

/**
 * This example cancels a addon,
 * Be aware that cancelling a addon will automatically trigger a restart of the VPS
 *
 * @copyright Copyright 2013 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    // cancel the addon for specific VPS
    Transip_VpsService::cancelAddon('vps-name','addon-name');
    echo 'Cancelled addon';
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}