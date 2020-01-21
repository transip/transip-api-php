<?php

/**
 * Use this API call in order to clone an existing VPS.
 */

require_once(__DIR__ . '/../Authenticate.php');

$vpsName          = 'testtransip-vps90';
$availabilityZone = 'rtm0'; // see examples/GetAllAvailabilityZones.php

$api->vps()->cloneVps($vpsName, $availabilityZone);
