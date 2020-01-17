<?php

/**
 * Using this API call, you are able to order a new VPS. After the order process has been completed (payment will occur
 * at a later stage should direct debit be used) the VPS will automatically be provisioned and deployed. Values
 * associated to the newly delivered VPS will be returned in a new call respectively.
 */

require_once('Authenticate.php');

// Order a VPS with only required fields
$productName               = 'vps-bladevps-x1';
$operatingSystemToInstall  = 'debian-9';

$api->vps()->order(
    $productName,
    $operatingSystemToInstall
);


// Order a VPS with optional fields
$addons           = ['vpsAddon-1-extra-ip-address'];
$hostName         = 'server.yoursite.com';
$availabilityZone = 'ams0';
$description       = 'My email server';

$api->vps()->order(
    $productName,
    $operatingSystemToInstall,
    $addons,
    $hostName,
    $availabilityZone,
    $description
);
