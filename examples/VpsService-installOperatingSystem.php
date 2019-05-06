<?php

/**
 * This example installs a operating on Vps
 * Note: if the operating system requires a licence, it will be billed automatically
 *
 * @copyright Copyright 2013 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    // hostname is only used when installing a "preinstalled image" like plesk, directadmin or cpanel
    Transip_VpsService::installOperatingSystem('vps-name','operating-system-name','hostname');
    echo 'Operating system install in progress';
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
