<?php

/**
 * This example gets information about a list of domain names.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

require_once('../Transip/DomainService.php');

if(isset($_GET['domains']) && strlen($_GET['domains']) > 0)
{
	/** @var string[] $domainNames A list of domain names. */
	$domainNames = explode("\n", $_GET['domains']);
	$domainNames = array_filter($domainNames, 'trim');

	try
	{
		// Request information about a domain in your account by using the TransIP
		// DomainService API; A domain Object will be returned holding all 
		// information available about the domain.
		$domains = Transip_DomainService::batchGetInfo($domainNames);

		// INFO: A domain object holds all data directly available for a domain: 
		//		 + it has a list of nameservers,
		//		 + a list of whois-contacts
		//		 + a list of dns-entries if the domain is using TransIP nameservers
		//		 + and, optionally, a Transip_DomainBranding object that holds
		//			information about branding (see reseller info for more)
		//
		// The domain object does not include registrar-lock and auth/epp-code 
		// information, since this information will always be fetched real-time
		// from the registry. To get this information, you can use the 
		// getIsLocked() and getAuthCode API calls.


		$result = "We got the following information about these domains:\n" .
				htmlspecialchars(implode(",\n", $domainNames)) . "\n\n";
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
	$domainNames = array();
	$domains = array();
	$result = '';
}

?>
<html>
<head>
</head>

<body>
<h2>TransIP API GetInfo Example</h2>
Fill in each domain on a seperate line. The maximum of domains is 20.
<form name="domainChecker">
	<textarea name="domains"><?=htmlspecialchars(implode("\n", $domainNames))?></textarea>
	<input type="submit" value="Get Info"/><br/>
	<b><?=$result?></b>
</form>

<!-- if we have domain information, we output it -->
<? if(!empty($domains)) {?>

	<? foreach($domains as $domain) { ?>

	<h2><?=$domain->name?></h2>
	<h3>Nameservers</h3>
	<ul>
		<?
		// iterate over each nameserver and output the hostname and optionally the glues
		foreach($domain->nameservers as $ns)
		{
			echo "<li>"  . htmlspecialchars($ns->hostname);

			if($ns->ipv4 != '' || $ns->ipv6 != '')
				echo " (" . htmlspecialchars($ns->ipv4) . ", "
						. htmlspecialchars($ns->ipv6) . ")";

			echo "</li>";
		}
		?>
	</ul>

	<h3>WhoisContacts</h3>
		<?
		// iterate over each whoisContact and output the values
		foreach($domain->contacts as $contact)
		{
			echo "<h4>" . htmlspecialchars($contact->type) . "</h4>";
			echo "<table border='1'>";
			foreach($contact as $key => $value)
			{
				echo "<tr>";
				echo "<td>" . htmlspecialchars($key) . "</td>";
				echo "<td>" . htmlspecialchars($value) . "</td>";

				echo "</tr>";
			}

			echo "</table>";
		}
		?>
	<h3>DNS</h3>
	<table border="1">
		<tr>
			<th>name</th>
			<th>expire</th>
			<th>type</th>
			<th>content</th>
		</tr>
		<?
		// iterate over each dnsEntries and output it nicely
		foreach($domain->dnsEntries as $dnsEntry)
		{
			echo "<tr>";
			echo "<td>" . htmlspecialchars($dnsEntry->name) . "</td>";
			echo "<td>" . htmlspecialchars($dnsEntry->expire) . "</td>";
			echo "<td>" . htmlspecialchars($dnsEntry->type) . "</td>";
			echo "<td>" . htmlspecialchars($dnsEntry->content) . "</td>";

			echo "</tr>";
		}
		?>
	</table>

		<? } ?>

	<? } ?>
</body>
</html>