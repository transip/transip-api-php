<?php

/**
 * This example returns a list of all Ptr for a given HA-IP
 *
 * @copyright Copyright 2017 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include haipservice
require_once('Transip/HaipService.php');

try {
    // Get PTR's for Haip
    $ptrs = Transip_HaipService::getPtrForHaip('example-haip');

    print_r($ptrs);
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
