<?php

/**
 * This example checks a batch of domain names for availability information
 * and shows the result.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

require_once('../Transip/DomainService.php');

if(isset($_GET['domains']) && strlen($_GET['domains']) > 0)
{
	// seperate each line into a domain and trim off any whitespace
	$domains = explode("\n", $_GET['domains']);
	$domains = array_map('trim', $domains);
	$result = '';

	try
	{
		// Request the availability of multiple domains by using the Transip_DomainService API;
		// we can get the following different statusses back with different meanings, wrapped in a Transip_DomainCheckResult.
		$domainCheckResults = Transip_DomainService::batchCheckAvailability($domains);
		foreach($domainCheckResults as $domainCheckResult)
		{
			switch($domainCheckResult->status)
			{
				case Transip_DomainService::AVAILABILITY_INYOURACCOUNT:
					$result .= htmlspecialchars($domainCheckResult->domainName) 
								. ' is not available.<br/>';
				break;

				case Transip_DomainService::AVAILABILITY_UNAVAILABLE:
					$result .= htmlspecialchars($domainCheckResult->domainName) 
								. ' is not available for transfer.<br/>';
				break;

				case Transip_DomainService::AVAILABILITY_FREE:
					$result .= htmlspecialchars($domainCheckResult->domainName) 
								. ' is available for registration.<br/>';
				break;


				case Transip_DomainService::AVAILABILITY_NOTFREE:
					$result .= htmlspecialchars($domainCheckResult->domainName) 
								. ' is registered. If you are the owner,
										you could transfer it.<br/>';
				break;
			}
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
	$domains = array();
	$result = '';
}

?>
<html>
<head>
</head>

<body>
	<h2>TransIP API Batch DomainChecker Example</h2>
	Fill in each domain on a seperate line. The maximum of domains is 20.
	<form name="domainChecker">
		<textarea name="domains"><?=htmlspecialchars(implode("\n", $domains))?></textarea>
		<input type="submit" value="Check"/><br/>
		<b><?=$result?></b>
	</form>
	
</body>

</html>
