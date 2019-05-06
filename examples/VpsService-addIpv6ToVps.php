<?php

/**
 * This example adds a ipv6 Address to a VPS from the assigned ipv6 range
 *
 * @copyright Copyright 2013 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    // add ipv6 to specific VPS (Ipv6 has to be in you Ipv6 Range)
    Transip_VpsService::addIpv6ToVps('vps-name','ipv6-address');
    echo 'added ipv6 to Vps';
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
