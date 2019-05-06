<?php

/**
 * This example cancels a private network,
 *
 * @copyright Copyright 2013 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    // cancel private network
    // end-time is either: 'immediately' or 'end' (end means end of contract)
    Transip_VpsService::cancelPrivateNetwork('privateNetwork-name', 'end-time');
    echo 'Cancelled private network';
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}