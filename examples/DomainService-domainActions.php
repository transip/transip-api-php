<?php

/**
 * This example gets the running DomainAction for a domain
 * and based on the status, retries it with new nameservers.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */


require_once('Transip/DomainService.php');

try
{
	$currentDomainAction = Transip_DomainService::getCurrentDomainAction($domainName);

	$result = '';
	if(is_null($currentDomainAction))
	{
		// There is currently no action running on this domain
		$result = "Currently no action for domain {$domainName}\n";
	}

	if($currentDomainAction->hasFailed !== true)
	{
		// There is currently an action running, and it has not failed yet.
		$result = "Current action for domain is {$currentDomainAction->name}\n";
	}
	else
	{
		// There was an action running on the domain, and it has failed.
		// We retry with new nameservers for the domain.
		$result = "Current action for domain is {$currentDomainAction->name} and has failed with message {$currentDomainAction->message}\n";
		$result .= "Retrying....\n";

		$domain = Transip_DomainService::getInfo($domainName);

		// Create new nameserver entries we want
		$nameservers = array();
		$nameservers[] = new Transip_Nameserver('ns1.mydomain.com');
		$nameservers[] = new Transip_Nameserver('ns2.mydomain.com', '');
		// Since ns.thedomaintomodify.com is a subdomain of the domain we are saving,
		// the nameserver needs a glue record (ipv4 required, ipv6 optional)
		$nameservers[] = new Transip_Nameserver('ns.thedomaintomodify.com', '99.99.99.99');
		$domain->nameServers = $nameServers;

		// We try the current action again, but now with our modified Transip_Domain object.
		// Based on the error message one should modify the appropiate part of this object
		Transip_DomainService::retryCurrentDomainActionWithNewData($domain);

		// If you need to change the authcode, please use the call below
		// Transip_DomainService::retryTransferWithDifferentAuthCode($domain, $newAuthCode);

		// If you want to cancel the action use
		// Beware, all changes will be rollbacked.
		// Transip_DomainService::cancelDomainAction($domain)
	}

	echo $result;
}
catch(Exception $exception)
{
	// When something goes wrong, an Exception will be thrown with relevant information.
	echo "An Exception occured. Code: {$exception->getCode()}, message: {$exception->getMessage()}\n";
}
?>
