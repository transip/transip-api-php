<?php

/**
 * Get usage statistics for a big storage. You can specify a dateTimeStart and dateTimeEnd parameter in the UNIX
 * timestamp format. When none given, traffic for the past 24 hours are returned. The maximum period is one month.
 */

require_once('Authenticate.php');

// Get usage statistics
$usageStatistics = $api->bigStorageUsage()->getUsageStatistics('example-bigstorage');

print_r($usageStatistics);


// Get usage statistics with start and end dates
$dateTimeStart = DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-01 13:37:00');
$dateTimeEnd   = DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-20 20:58:00');

$usageStatistics = $api->bigStorageUsage()->getUsageStatistics(
    'example-bigstorage',
    $dateTimeStart->getTimestamp(),
    $dateTimeEnd->getTimestamp()
);

print_r($usageStatistics);
