<?php

/**
 * This example registers a domain.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include domainservice
require_once('Transip/DomainService.php');


try
{
	$types = array(
		Transip_WhoisContact::TYPE_REGISTRANT,
		Transip_WhoisContact::TYPE_ADMINISTRATIVE,
		Transip_WhoisContact::TYPE_TECHNICAL
	);

	// setting up whois records is quite easy
	$contacts = array();
	foreach($types AS $type)
	{
		$contact = new Transip_WhoisContact();
		$contact->type = $type;
		// please note that 'Sjaak de Waal' is a fictional character
		// any resemblances to real persons are unintentional and coincidential
		// Also, please note that the middleName field is not used, so you should
		// put any middleName/infix in the lastName field.
		$contact->firstName   = 'Sjaak';
		$contact->lastName    = 'de Waal';
		$contact->companyName = 'TransIP';
		$contact->companyKvk  = '24345899';
		$contact->companyType = 'BV';
		$contact->street      = 'Schipholweg';
		$contact->number      = '11e';
		$contact->postalCode  = '2316XB';
		$contact->city        = 'Leiden';
		$contact->phoneNumber = '+31715241919';
		$contact->faxNumber   = '+31715241918';
		$contact->email       = 'support@transip.nl';
		$contact->country     = 'NL';
		$contacts[] = $contact;
	}

	// you can now use the $contacts array as the third parameter when instantiating
	// a new Transip_Domain. For example:
	$domain = new Transip_Domain($name, $nameservers, $contacts, $dnsEntries, $branding);
	Transip_DomainService::register($domain);
}
catch(Exception $e)
{
	echo 'An error occured: '. $e->getMessage(), PHP_EOL;
}


?>
