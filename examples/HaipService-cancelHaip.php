<?php

/**
 * This example cancel your haip
 *
 * @copyright Copyright 2017 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include haipservice
require_once('Transip/HaipService.php');

try {
    // Cancel your haip by name at end of contract, use
    // end-time is either: 'immediately' or 'end' (end means end of contract)
    $haip = Transip_HaipService::cancelHaip('example-haip', 'end');

    print_r($haip);
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
