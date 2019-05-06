<?php

/**
 * This example adds VPS to a private network
 *
 * @copyright Copyright 2013 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    // add the VPS to private network
    Transip_VpsService::addVpsToPrivateNetwork('vps-name','private-network-name');
    echo 'added Vps to private network';
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}