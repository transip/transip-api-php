<?php

/**
 * This example checks the availability of one domain.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

require_once('Transip/DomainService.php');

if(isset($_GET['domain']) && strlen($_GET['domain']) > 0)
{
	$domain = $_GET['domain'];

	try
	{
		// Request the availability of a domain by using the Transip_DomainService API;
		// we can get the following different statusses back with different meanings.
		$availability = Transip_DomainService::checkAvailability($domain);
		switch($availability)
		{
			case Transip_DomainService::AVAILABILITY_INYOURACCOUNT:
				$result = htmlspecialchars($domain) 
							. ' is not available.';
			break;

			case Transip_DomainService::AVAILABILITY_UNAVAILABLE:
				$result = htmlspecialchars($domain) 
							. ' is not available for transfer.';
			break;

			case Transip_DomainService::AVAILABILITY_FREE:
				$result = htmlspecialchars($domain) 
							. ' is available for registration.';
			break;


			case Transip_DomainService::AVAILABILITY_NOTFREE:
				$result = htmlspecialchars($domain) 
							. ' is registered. If you are the owner,
									you could transfer it.';
			break;
		}
	}
	catch(SoapFault $e)
	{
		// It is possible that an error occurs when connecting to the TransIP Soap API,
		// those errors will be thrown as a SoapFault exception.
		$result = 'An error occurred: ' . htmlspecialchars($e->getMessage());
	}
}
else
{
	$domain = '';
	$result = '';
}

?>
<html>
<head>
</head>

<body>
	<h2>TransIP API DomainChecker Example</h2>
	Fill in the domain you want to check and press Check.
	<form name="domainChecker">
		<input type="text" name="domain" value="<?=htmlspecialchars($domain)?>">
		<input type="submit" value="Check"/><br/>
		<b><?=$result?></b>
	</form>
	
</body>

</html>
