<?php

/**
 * Use this API call in order to clone an existing VPS.
 */

require_once(__DIR__ . '/../Authenticate.php');

$vpsName          = 'testtransip-vps90';
$availabilityZone = 'rtm0'; // see examples/GetAllAvailabilityZones.php
$targetProductName = 'vps-bladevps-x8';
$addons = [
    'vps-addon-flex-100-gb-extra-harddisk'
];

$api->vps()->cloneVps($vpsName, $availabilityZone, $targetProductName, $addons);
