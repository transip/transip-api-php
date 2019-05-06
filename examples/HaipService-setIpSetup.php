<?php

/**
 * This example sets the IP configuration for a HA-IP
 *
 * @copyright Copyright 2017 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include haipservice
require_once('Transip/HaipService.php');

try {
    // Enable both IPv4 and IPv6 for the HA-IP
    Transip_HaipService::setIpSetup('example-haip', 'both');

    // ...

    // Disable IPv6 for the HA-IP
    Transip_HaipService::setIpSetup('example-haip', 'noipv6');

    // ...

    // Forward all IPv6 for the HA-IP to the IPv4 address on the VPS
    Transip_HaipService::setIpSetup('example-haip', 'ipv6to4');

} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
