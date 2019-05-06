<?php

/**
 * This example attaches multiple VPSes to a HA-IP
 *
 * @copyright Copyright 2017 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include haipservice
require_once('Transip/HaipService.php');

try {
    // Replaces currently attached VPSes to the HA-IP with the provided list of VPSes
    Transip_HaipService::setHaipVpses('example-haip', ['example-vps1', 'example-vps2']);
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
