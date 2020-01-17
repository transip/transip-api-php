<?php

require('Authenticate.php');

// Example 1: Required fields
$productName               = 'vps-bladevps-x1';
$operatingSystemToInstall  = 'debian-9';

// Example 1: Order a VPS
$api->vps()->order(
    $productName,
    $operatingSystemToInstall
);


// Example 2: Usage of optional fields
$addons           = ['vpsAddon-1-extra-ip-address'];
$hostName         = 'server.yoursite.com';
$availabilityZone = 'ams0';
$description       = 'My email server';

// Example 2: Order with optional fields
$api->vps()->order(
    $productName,
    $operatingSystemToInstall,
    $addons,
    $hostName,
    $availabilityZone,
    $description
);
