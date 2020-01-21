<?php

/**
 * Reverting a VPS back-up will restore the VPS to an earlier state. Use this API call with care, as data created after
 * the back-up creation date can be wiped when a back-up is restored.
 */

require(__DIR__ . '/../../Authenticate.php');

$vpsName  = 'example-vps';
$backupId = 0; // see examples/Vps/Backup/List.php

$api->vpsBackups()->revertBackup($vpsName, $backupId);
