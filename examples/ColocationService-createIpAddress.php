<?php

/**
 * This example creates an IPAddress.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */


require_once('Transip/ColocationService.php');

try
{
	// Creates an IpAddress and will assign it to the current user. 
	// Please note that 127.0.0.1 is an example address.
	Transip_ColocationService::createIpAddress('127.0.0.1', 'reverse.example.com');
}
catch(Exception $e)
{
	print "error: {$e->getMessage()}\n";
}
?>
