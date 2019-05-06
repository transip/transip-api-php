<?php

/**
 * This example creates a mailbox for a webhosting package.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include webhostingservice
require_once('Transip/WebhostingService.php');

try
{
	// Create a MailBox for a webhosting package.
	// with default settings
	// It's also possible to create a mailbox with custom settings,
	// for this the MailBox should be created with:
	// $mailBox = new Transip_MailBox('info', <spamCheckerStrength (LOW,AVERAGE,HIGH)>, <maxDiskUsage in MB>)
	$mailBox = new Transip_MailBox('info');
	Transip_WebhostingService::createMailBox('example.com', $mailBox);
}
catch(SoapFault $f)
{
	// It is possible that an error occurs when connecting to the TransIP Soap API,
	// those errors will be thrown as a SoapFault exception.
	echo  'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
