<?php

/**
 * This example deletes an active IPAddress.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */


require_once('Transip/ColocationService.php');

try
{
	// Please note that 127.0.0.1 is an example address
	Transip_ColocationService::deleteIpAddress('127.0.0.1');
}
catch(Exception $e)
{
	print "error: {$e->getMessage()}\n";
}
?>
