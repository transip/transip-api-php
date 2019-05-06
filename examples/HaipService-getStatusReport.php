<?php

/**
 * This example retrieves a status report for a HA-IP - this is a HA-IP Pro feature
 *
 * @copyright Copyright 2017 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include haipservice
require_once('Transip/HaipService.php');

try {
    // Retrieve status report data for a HA-IP as an array
    $statusReport = Transip_HaipService::getStatusReport('example-haip');
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
