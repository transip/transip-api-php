<?php

/**
 * This example adds new port configuration to a HA-IP
 *
 * @deprecated See HaipService-addPortConfiguration.php
 *
 * @copyright Copyright 2017 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include haipservice
require_once('Transip/HaipService.php');

try {
    // Add configuration by HA-IP name
    // mode ('tcp','http','https','proxy')
    Transip_HaipService::addHaipPortConfiguration('example-haip', 'HTTP', 80, 'http');

} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
