<?php

/**
 * This example transfers a domain.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */


// Include domainservice
require_once('Transip/DomainService.php');

try
{
	// Transfers a domain with your default settings
	// It's also possible to transfer with custom settings,
	// for this the call should be like:
	// $domain = new Transip_Domain('transip.nl', <array of nameservers>, <array of contacts>,
	//                   <array of dns entries>);

	$domainName = 'example.com';
	$authCode = '[AUTHCODE]';


	$domain = new Transip_Domain($domainName);

	$tldName = strstr($domainName, '.');
	$tldInfo = Transip_DomainService::getTldInfo($tldName);
	if(in_array(Transip_Tld::CAPABILITY_CANTRANSFERWITHOWNERCHANGE, $tldInfo->capabilities))
	{
		Transip_DomainService::transferWithOwnerChange($domain, $authCode);
	}
	elseif(in_array(Transip_Tld::CAPABILITY_CANTRANSFERWITHOUTOWNERCHANGE, $tldInfo->capabilities))
	{
		Transip_DomainService::transferWithoutOwnerChange($domain, $authCode);
	}
	else
	{
		// The TLD does not support transfers at all
		throw new Exception('TLD ' . $tldName . ' does not support domain transfers');
	}

	echo 'The domain ' . $domain->name . ' has been requested.';
}
catch(SoapFault $f)
{
	// It is possible that an error occurs when connecting to the TransIP Soap API,
	// those errors will be thrown as a SoapFault exception.
	echo 'An error occurred: ' . htmlspecialchars($f->getMessage());
}
catch(Exception $e)
{
	echo htmlspecialchars($e->getMessage());
}

?>
