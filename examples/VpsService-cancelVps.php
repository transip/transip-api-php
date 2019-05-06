<?php

/**
 * This example cancels a VPS
 *
 * @copyright Copyright 2013 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    // cancel VPS
    // end-time is either: 'immediately' or 'end' (end means end of contract)
    Transip_VpsService::cancelVps('vps-name', 'immediately');
    echo 'Cancelled Vps';
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
