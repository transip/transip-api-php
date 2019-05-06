<?php

/**
 * This example orders a Addon for a Vps,
 * Be aware that ordering a Addon will automatically trigger a restart of the VPS
 *
 * @copyright Copyright 2013 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    // order the addon for specific VPS, use array
    $addon = array('addon-name');
    Transip_VpsService::orderAddon('vps-name',$addon);
    echo 'Ordered addon';
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}