<?php

/**
 * This example changes the balancing mode for a HA-IP - this is a HA-IP Pro feature
 *
 * @copyright Copyright 2017 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include haipservice
require_once('Transip/HaipService.php');

try {
    // Change the HA-IP balancing mode to 'cookie', and pin sessions on the PHPSESSID cookie
    Transip_HaipService::setBalancingMode('example-haip', 'cookie', 'PHPSESSID');

    // ...

    // Change the HA-IP balancing mode to 'roundrobin' (this is the default mode)
    Transip_HaipService::setBalancingMode('example-haip', 'roundrobin', '');

    // ...

    // Change the HA-IP balancing mode to 'source'
    Transip_HaipService::setBalancingMode('example-haip', 'source', '');

} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
