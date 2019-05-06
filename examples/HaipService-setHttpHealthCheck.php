<?php

/**
 * This example configures a HTTP health check for a HA-IP - this is a HA-IP Pro feature
 *
 * @copyright Copyright 2017 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include haipservice
require_once('Transip/HaipService.php');

try {
    // Configure a HTTP health check for the HA-IP that will access '/health.php' on port 80
    Transip_HaipService::setHttpHealthCheck('example-haip', '/health.php', 80);
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
