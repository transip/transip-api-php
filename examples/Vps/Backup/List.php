<?php

/**
 * TransIP offers multiple back-up types, every VPS has 4 hourly back-ups by default, weekly back-ups are available for
 * a small fee. This API call returns back-ups for both types.
 */

require(__DIR__ . '/../../Authenticate.php');

$vpsName = 'example-vps';

// Get all backups for VPS
$backups = $api->vpsBackups()->getByVpsName($vpsName);
// var_dump($backups);

$backupId = 0;
foreach ($backups as $backup) {

    // An example search
    if ($backup->getOperatingSystem() === 'OpenBSD 6.4') {
        $backupId = $backup->getId();
        break;
    }
}
echo $backupId;
