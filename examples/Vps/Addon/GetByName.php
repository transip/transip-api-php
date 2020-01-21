<?php

/**
 * List active, cancellable and available addons for a VPS.
 */

require(__DIR__ . '/../../Authenticate.php');

$vpsName   = 'example-vps';

// Get all available addons
$vpsAddons = $api->vpsAddons()->getByVpsName($vpsName);
// print_r($vpsAddons);

// You can use getter methods like demonstrated below
foreach ($vpsAddons as $addon) {
    echo <<<ADDON
    Name: {$addon->getName()}
    Description: {$addon->getDescription()}
    Price: {$addon->getPrice()}
    Recurring Price: {$addon->getRecurringPrice()}
    Category: {$addon->getCategory()}\n\n
ADDON;
}
