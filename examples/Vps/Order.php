<?php

/**
 * Using this API call, you are able to order a new VPS. After the order process has been completed (payment will occur
 * at a later stage should direct debit be used) the VPS will automatically be provisioned and deployed. Values
 * associated to the newly delivered VPS will be returned in a new call respectively.
 */

require_once(__DIR__ . '/../Authenticate.php');

/**
 * Example 1: Simply order a VPS
 */
$productName               = 'vps-bladevps-x1';
$operatingSystemToInstall  = 'debian-9';

// Order VPS
// $api->vps()->order(
//     $productName,
//     $operatingSystemToInstall
// );

/**
 * Example 2: Order a VPS with an addon and choose your data center
 */
$addons           = ['vpsAddon-1-extra-ip-address'];
$hostName         = 'server.yoursite.com';
$availabilityZone = 'ams0';
$description      = 'My email server';

// Order VPS
$api->vps()->order(
    $productName,
    $operatingSystemToInstall,
    $addons,
    $hostName,
    $availabilityZone,
    $description
);
