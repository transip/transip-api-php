<?php

/**
 * With this API call you can convert a backup to a snapshot for a VPS.
 */

require(__DIR__ . '/../../Authenticate.php');

$vpsName             = 'example-vps';
$backupId            = 123; // see examples/Vps/Backup/List.php
$snapshotDescription = ''; // optional

// Convert backup to snapshot
$api->vpsBackups()->convertBackupToSnapshot($vpsName, $backupId, $snapshotDescription);
