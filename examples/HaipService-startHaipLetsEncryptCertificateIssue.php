<?php

/**
 * This example add a lets encrypt certificate to HA-IP
 *
 * @copyright Copyright 2017 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include haipservice
require_once('Transip/HaipService.php');

try {
    // issue a letsEncrypt certificate by HA-IP name and common Name
    Transip_HaipService::startHaipLetsEncryptCertificateIssue('example-haip', 'commonName');

} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
