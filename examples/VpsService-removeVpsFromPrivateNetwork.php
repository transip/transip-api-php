<?php

/**
 * This example removes a VPS from a Private Network
 *
 * @copyright Copyright 2013 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try
{
    // Remove the VPS from a private Network
    Transip_VpsService::removeVpsFromPrivateNetwork('vps-name', 'private-network-name');
    echo 'Removing VPS from Private Network';
}
catch(SoapFault $f)
{
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
