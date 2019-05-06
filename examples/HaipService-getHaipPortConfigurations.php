<?php

/**
 * This example returns all port configurations for HA-IP
 *
 * @deprecated See HaipService-getPortConfigurations.php
 *
 * @copyright Copyright 2017 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include haipservice
require_once('Transip/HaipService.php');

try {
    // Get all port configuration by HA-IP name
    $haip = Transip_HaipService::getHaipPortConfigurations('example-haip');

    print_r($haip);
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
