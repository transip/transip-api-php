<?php

/**
 * This example orders a Forward for an existing domain name.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include forwardservice
require_once('Transip/ForwardService.php');

// Order a forward service for a domain name
try
{
	// Create a new forward object that directly forwards to example.org.
	$forward = new Transip_Forward();
	$forward->domainName = 'example.com';
	$forward->forwardTo = 'http://www.example.org';
	$forward->forwardEmailTo = 'test@example.com';
	// Order the forward
	Transip_ForwardService::order($forward);
}
catch(Exception $exception)
{
	// When something goes wrong, an Exception will be thrown with relevant information.
	echo "An Exception occured. Code: {$exception->getCode()}, message: {$exception->getMessage()}\n";
}

?>
