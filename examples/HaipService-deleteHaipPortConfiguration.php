<?php

/**
 * This example removes a port configuration from a HA-IP
 *
 * @deprecated See HaipService-deletePortConfiguration.php
 *
 * @copyright Copyright 2017 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include haipservice
require_once('Transip/HaipService.php');

try {
    // Remove a port configuration by HA-IP name and port config id
    $haip = Transip_HaipService::deleteHaipPortConfiguration('example-haip', 1);

    print_r($haip);
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
