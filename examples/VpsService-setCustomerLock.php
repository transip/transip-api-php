<?php

/**
 * This example will enable and disable the CustomerLock for a Vps
 *
 * @copyright Copyright 2014 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {

    // enable customer lock
    Transip_VpsService::setCustomerLock('vps-name',true);
    echo 'vps is customer locked';
    // disable customer lock
    Transip_VpsService::setCustomerLock('vps-name',false);
    echo 'vps is unlocked';

} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
