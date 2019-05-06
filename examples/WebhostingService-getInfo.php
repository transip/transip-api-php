<?php

/**
 * This example gets information about a webhosting package.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

require_once('Transip/WebhostingService.php');

if(isset($_GET['domain']) && strlen($_GET['domain']) > 0)
{
	$domainName = $_GET['domain'];

	try
	{
		// Request information about a domain in your account by using the TransIP 
		// WebhostingService API; A WebHost Object will be returned holding all 
		// information available about the domain.
		$domain = Transip_WebhostingService::getInfo($domainName);
		
		// INFO: A WebHost object holds all data directly available for a domain: 
		//		 + it has a list of MailBoxes,
		//		 + a list of Cronjobs
		//		 + a list of Dbs
		//		 + a list of MailForwards
		//		 + a list of subDomains
		//

		$result = 'We got the following information about the domain ' . 
						htmlspecialchars($domainName) . ':';
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
	$domainName = '';
	$domain = null;
	$result = '';
}

?>
<html>
<head>
</head>

<body>
	<h2>TransIP API GetInfo Example</h2>
	Fill in the domain you want to get information about and click on Get Info.
	<form name="domainChecker">
		<input type="text" name="domain" value="<?=htmlspecialchars($domainName)?>">
		<input type="submit" value="Get Info"/><br/>
		<b><?=$result?></b>
	</form>

	<!-- if we have domain information, we output it -->
	<? if(isset($domain)) {?>
	
	<h3>MailBoxes</h3>
	<table border="1">
	<tr>
		<th>mailbox</th>
		<th>spamCheckerStrength</th>
		<th>maxDiskUsage</th>
		<th>VacationReply</th>
	</tr>
	<?
		// iterate over each mailbox and output the info
		foreach($domain->mailBoxes as $mailBox)
		{
			echo "<tr>";
			echo "<td>" . htmlspecialchars($mailBox->address) . "</td>";
			echo "<td>" . $mailBox->spamCheckerStrength . "</td>";
			echo "<td align='right'>" . $mailBox->maxDiskUsage . " MB</td>";
			echo "<td>";
			if($mailBox->hasVacationReply)
			{
				echo "Subject: " . htmlspecialchars($mailBox->vacationReplySubject) . "<br>";
				echo "Message: " . htmlspecialchars($mailBox->vacationReplyMessage) . "<br>";
			}
			else
			{
				echo "&nbsp;";
			}
			echo "</td>";
			echo "</tr>";
		}
	?>
	</table>

	<h3>MailForwards</h3>
	<table border="1">
	<tr>
		<th>mailForward</th>
		<th>targetAddress</th>
	</tr>
	<?
		// iterate over each mailbox and output the info
		foreach($domain->mailForwards as $mailForward)
		{
			echo "<tr>";
			echo "<td>" . htmlspecialchars($mailForward->name) . "</td>";
			echo "<td>" . htmlspecialchars($mailForward->targetAddress) . "</td>";
			echo "</tr>";
		}
	?>
	</table>

	<h3>Databases</h3>
	<table border="1">
	<tr>
		<th>Database</th>
	</tr>
	<?
		// iterate over each mailbox and output the info
		foreach($domain->dbs as $database)
		{
			echo "<tr>";
			echo "<td>" . htmlspecialchars($database->name) . "</td>";
			echo "</tr>";
		}
	?>
	</table>

	<h3>Cronjobs</h3>
	<table border="1">
	<tr>
		<th>name</th>
		<th>url</th>
		<th>email</th>
		<th>TimeSpecification</th>
	</tr>
	<?
		// iterate over each mailbox and output the info
		foreach($domain->cronjobs as $cronjob)
		{
			echo "<tr>";
			echo "<td>" . htmlspecialchars($cronjob->name) . "</td>";
			echo "<td>" . htmlspecialchars($cronjob->url) . "</td>";
			echo "<td>" . htmlspecialchars($cronjob->email) . "</td>";
			echo "<td>";
			echo "minute: {$cronjob->minuteTrigger}<br>";
			echo "hour: {$cronjob->hourTrigger}<br>";
			echo "day: {$cronjob->dayTrigger}<br>";
			echo "month: {$cronjob->monthTrigger}<br>";
			echo "weekday: {$cronjob->weekdayTrigger}<br>";
			echo "</td>";
			echo "</tr>";
		}
	?>
	</table>

	<h3>Subdomains</h3>
	<table border="1">
	<tr>
		<th>subdomain</th>
	</tr>
	<?
		// iterate over each mailbox and output the info
		foreach($domain->subDomains as $subDomain)
		{
			echo "<tr>";
			echo "<td>" . htmlspecialchars($subDomain->name) . "</td>";
			echo "</tr>";
		}
	?>
	</table>


	<?}?>
</body>
</html>
