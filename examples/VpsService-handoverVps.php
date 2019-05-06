<?php

/**
 * This example will initiate a push of a VPS in your account to another TransIP account
 *
 * @copyright Copyright 2014 TransIP BV
 * @author    TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    // handover the vps to another account
    Transip_VpsService::handoverVps('vps-name','target-account-name');

    echo 'handover process started';

} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
