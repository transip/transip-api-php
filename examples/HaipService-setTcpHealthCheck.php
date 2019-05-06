<?php

/**
 * This example configures the health check for a HA-IP to use TCP - this is a HA-IP Pro feature
 *
 * @copyright Copyright 2017 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include haipservice
require_once('Transip/HaipService.php');

try {
    // Configure the health check for the HA-IP to use TCP. This will disable a configured HTTP health check.
    Transip_HaipService::setTcpHealthCheck('example-haip');
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
