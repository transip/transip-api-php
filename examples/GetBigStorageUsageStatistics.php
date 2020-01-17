<?php

require('Authenticate.php');

// Get usage statistics
$usageStatistics = $api->bigStorageUsage()->getUsageStatistics('example-bigstorage');

print_r($usageStatistics);
