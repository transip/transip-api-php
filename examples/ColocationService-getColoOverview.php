<?php

/**
 * This example retrieves all colocation items,
 * the related IP information per item and prints
 * it on the console.
 *
 * Functions used:
 *	Transip_ColocationService::getColoNames()
 *  Transip_ColocationService::getIpRanges()
 *  Transip_ColocationService::getIpAddresses()
 *  Transip_ColocationService::getReverseDns()
 *
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

require_once('Transip/ColocationService.php');

try
{
	// retrieve all colocation items and loop 
	$coloNames = Transip_ColocationService::getColoNames();
	foreach($coloNames as $coloName)
	{
		echo $coloName . ':' . PHP_EOL;

		// for each colo, get the IPRanges used by this colo
		$ipRanges = Transip_ColocationService::getIpRanges($coloName);
		foreach($ipRanges as $ipRange)
		{
			echo '- IP range: ' . $ipRange . PHP_EOL;
		}
		
		// get all IPAddresses attached to this colo and iterate over
		// the addresses to get the reverse dns and print information.
		$ipAddresses = Transip_ColocationService::getIpAddresses($coloName);
		foreach($ipAddresses as $ipAddress)
		{
			$reverseDns = Transip_ColocationService::getReverseDns($ipAddress);
			echo '- IP address: ' . $ipAddress . ' (rDNS "' . $reverseDns . '")' . PHP_EOL;
		}

		echo PHP_EOL;
	}
}
catch(Exception $exception)
{
	// When something goes wrong, an Exception will be thrown with relevant information.
	echo "An Exception occured. Code: {$exception->getCode()}, message: {$exception->getMessage()}\n";
}

?>