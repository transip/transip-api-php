<?php

/**
 * This example add certificate to haip
 *
 * @copyright Copyright 2017 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include haipservice
require_once('Transip/HaipService.php');

try {
    // Aad certificate to haip by haip name and certificate id
    Transip_HaipService::addCertificateToHaip('example-haip', 1);
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
