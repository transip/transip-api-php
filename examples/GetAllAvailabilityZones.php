<?php

/**
 * List all availability zones
 */

require('Authenticate.php');

$availabilityZones = $api->availabilityZone()->getAll();
//print_r($availabilityZones);

foreach ($availabilityZones as $zone) {
    if ($zone->getCountry() === 'nl') {
        echo $zone->getName();
    }
}
