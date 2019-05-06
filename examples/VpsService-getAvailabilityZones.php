<?php

/**
 * This example returns a list of AvailabilityZones
 *
 * @copyright Copyright 2018 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    // Get a vps by name
    $zones = Transip_VpsService::getAvailableAvailabilityZones();

    print_r($zones);
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
