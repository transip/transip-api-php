<?php

/**
 * This example returns all traffic information for the current contract period per VPS
 *
 * @copyright Copyright 2014 TransIP BV
 * @author    TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    // Get all the traffic information for the current contract period by vps name

    /**
     * Returns Array with the following Elements:
     *
     * 'startDate'
     * 'endDate'
     * 'usedInBytes'
     * 'usedTotalBytes'
     * 'maxBytes'
     */

    $trafficInformation = Transip_VpsService::getTrafficInformationForVps('vps-name');
    print_r($trafficInformation);

} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
