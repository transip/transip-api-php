<?php

/**
 * In order to extend a specific VPS with add-ons, use this API call. Add-ons are added and removed dynamically,
 * so changes are instant.
 *
 * The type of add-ons that can be ordered range from extra IP addresses to hardware add-ons such as an extra core or
 * additional SSD disk space.
 */

require(__DIR__ . '/../../Authenticate.php');

$vpsName   = 'example-vps';
$vpsAddons = [
    'vpsAddon-extra-memory',
    'vpsAddon-1-extra-cpu-core',
];

// Order addon(s)
$api->vpsAddons()->order($vpsName, $vpsAddons);
