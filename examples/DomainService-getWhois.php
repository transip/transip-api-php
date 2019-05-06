<?php

/**
 * This example gets and shows the WHOIS information for a domain.
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
		// Request the WHOIS information of a domain by using the Transip_DomainService API.
		$whois = Transip_DomainService::getWhois($domain);
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
	$whois = '';
}

?>
<html>
<head>
</head>

<body>
	<h2>TransIP API Whois Example</h2>
	Fill in the domain you want to get the whois for and click on Get Whois.
	<form name="domainChecker">
		<input type="text" name="domain" value="<?=htmlspecialchars($domain)?>">
		<input type="submit" value="Get Whois"/><br/>
		<pre><?=$whois?></pre>
	</form>
	
</body>

</html>