<?php

/**
 * This example returns a list of all the available addons that can be ordered for a VPS
 *
 * @copyright Copyright 2013 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    // Get a list of all available addons
    $addons = Transip_VpsService::getAvailableAddons();

    print_r($addons);
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
