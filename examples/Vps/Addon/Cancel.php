<?php

/**
 * While using this API call, you can cancel an add-on based on its name, specifying the VPS name as well. This will
 * instantly cancel the given add-on. Add-ons can only be cancelled immediately as most of them require a restart of
 * the VPS. Due to technical restrictions (possible dataloss) storage add-ons cannot be cancelled.
 */

require(__DIR__ . '/../../Authenticate.php');

$vpsName   = 'example-vps';
$addonName = 'vpsAddon-extra-memory';

// Cancel an addon
$api->vpsAddons()->cancel($vpsName, $addonName);
