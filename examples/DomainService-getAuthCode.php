<?php

/**
 * This example gets the authcode for a domain.
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
		// Request the authcode of a domain by using the Transip_DomainService API;
		$info = Transip_DomainService::getInfo($domain);
		if($info != null)
		{
			$authCode = $info->authCode;
		}
		else
		{
			$authCode = 'unknown';
		}

		$result = 'The authcode for the domain ' . htmlspecialchars($domain) 
					. ' is: ' . htmlspecialchars($authCode);
	}
	catch(SoapFault $e)
	{
		// It is possible that an error occurs when connecting to the TransIP Soap API,
		// those errors will be thrown as a SoapFault exception.
		$whois = 'An error occurred: ' . htmlspecialchars($e->getMessage());
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
	<h2>TransIP API GetAuthCode Example</h2>
	Fill in the domain you want to get the authcode for and click on Get AuthCode.
	<form name="domainChecker">
		<input type="text" name="domain" value="<?=htmlspecialchars($domain)?>">
		<input type="submit" value="Get AuthCode"/><br/>
		<b><?=$result?></b>
	</form>
	
</body>

</html>