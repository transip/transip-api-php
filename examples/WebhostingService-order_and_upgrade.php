<?php

/**
 * This example orders a webhosting package for a domain name.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include webhostingservice
require_once('Transip/WebhostingService.php');

try
{
	// Order webhosting for a domain you own
	//
	// We first need to get the available webhosting packages, so
	// we can pick one to order
	// This returns an array with the available WebhostingPackage objects.
	//
	// If we want to order an upgrade, we need to get the available upgrade packages and
	// this call would be:
	// $packages = Transip_WebhostingService::getAvailableUpgrades('transip.nl');
	$packages = Transip_WebhostingService::getAvailablePackages();

	// Now order the first available package
	//
	// If we want to upgrade this call would be
	// Transip_WebhostingService::upgrade('transip.nl', $packages[0]);
	Transip_WebhostingService::order('example.com', $packages[0]);
}
catch(SoapFault $f)
{
	// It is possible that an error occurs when connecting to the TransIP Soap API,
	// those errors will be thrown as a SoapFault exception.
	echo 'An error occurred: ' . $f->getMessage() . PHP_EOL;
}
