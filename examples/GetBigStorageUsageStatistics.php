<?php

/**
 * Get usage statistics for a big storage. You can specify a dateTimeStart and dateTimeEnd parameter in the UNIX
 * timestamp format. When none given, traffic for the past 24 hours are returned. The maximum period is one month.
 */

require_once('Authenticate.php');

// Your big storage name
$bigStorageName = 'example-bigstorage38';


/**
 * Example 1: Get usage statistics for 1 day
 */
// $usageStatistics = $api->bigStorageUsage()->getUsageStatistics($bigStorageName);
// print_r($usageStatistics);


/**
 * Example 2: Get usage statistics for last three days
 */
$dateToday        = new \DateTimeImmutable();
$dateThreeDaysAgo = $dateToday->sub(new \DateInterval('P3D'));

$dateTimeStart    = $dateThreeDaysAgo;
$dateTimeEnd      = $dateToday;

// Get usage statistics from the API
$usageStatistics = $api->bigStorageUsage()->getUsageStatistics(
    $bigStorageName,
    $dateTimeStart->getTimestamp(),
    $dateTimeEnd->getTimestamp()
);

foreach ($usageStatistics as $statistic) {

    // Convert unix timestamp to human readable date
    $date = new DateTime("@{$statistic->getDate()}");

    // Render statistics
    echo "IO Operations per second - Date: {$date->format('Y-m-d H:i')}, Read: {$statistic->getIopsRead()}, Write: {$statistic->getIopsWrite()} \n";
}
