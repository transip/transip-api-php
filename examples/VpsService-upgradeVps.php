<?php

/**
 * This example upgrades a VPS to a better product
 * Note: this will erase and reinstall your VPS
 *
 * @copyright Copyright 2013 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    // Upgrade a VPS
    $operatingSystemList = Transip_VpsService::upgradeVps('vps-name','product-name');

    echo 'Upgrading VPS';
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
