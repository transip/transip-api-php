<?php

/**
 * This example sets the reverse dns for an IPAddress.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

require_once('Transip/ColocationService.php');

try
{
	// Change the reverse dns of an already active IPAddress assigned to the current user
	// Please note that 127.0.0.1 is a example addresss
	Transip_ColocationService::setReverseDns('127.0.0.1', 'reverse.example.com');
}
catch(Exception $e)
{
	print "error: {$e->getMessage()}\n";
}
?>
