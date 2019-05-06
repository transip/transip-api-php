<?php

/**
 * This example returns a list of all possible upgrades for a specific VPS
 *
 * @copyright Copyright 2013 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    // Get a list of the possible upgrades for a specific VPS
    $upgrades = Transip_VpsService::getAvailableUpgrades('vps-name');

    print_r($upgrades);
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
