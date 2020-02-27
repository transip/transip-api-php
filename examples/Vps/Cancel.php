<?php

/**
 * Using the cancel method on a VPS will cancel the VPS, thus deleting it. this will do a couple of things:
 * - Cancel future invoices for the VPS (including add-ons if applicable);
 * - Remove the ability to control the VPS or alter it in any way through the control panel
 * Most importantly, though, this will wipe all data on the VPS and permanently destroy it.
 */

require_once(__DIR__ . '/../Authenticate.php');

$vpsName = 'example-vps';
$endTime = 'end'; // Cancellation time, either ‘end’ or ‘immediately’

// Cancel the VPS
$api->vps()->cancel($vpsName, $endTime);
