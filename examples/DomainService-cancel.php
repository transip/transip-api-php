<?php

/**
 * This example cancels a domain that is currently active in the users account.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

require_once('Transip/DomainService.php');

if(isset($_POST['domain']) && strlen($_POST['domain']) > 0)
{
	$domain = $_POST['domain'];
	$when = isset($_POST['when']) && !empty($_POST['when']) ? $_POST['when'] : 'end';
	try
	{
		// Request cancellation of a domain by using the Transip_DomainService API;
		Transip_DomainService::cancel($domain, $when);
	}
	catch(SoapFault $e)
	{
		// It is possible that an error occurs when connecting to the TransIP Soap API,
		// those errors will be thrown as a SoapFault exception.
		$result = 'An error occurred: ' . htmlspecialchars($e->getMessage());
	}
}

?>
<html>
<head>
</head>

<body>
	<h2>TransIP API cancel Example</h2>
	Fill in the domain you want to cancel.
    <!-- cancelling is a modifying action, so we need to
                        use POST instead of GET by the HTTP specs -->
	<form name="domainChecker" method="post">
		<input type="text" name="domain" value="<?=isset($domain)?htmlspecialchars($domain):''?>">
		<br />
		Cancel when?
		<br />
		<select name="when">
			<option></option>
			<option value="end">At the end of the contract</option>
			<option value="immediately">Right now</option>
		</select>
		<br />
		<input type="submit" value="Cancel domain"/>
		<br/>
		<b><?=isset($result)?$result:""?></b>
	</form>
	
</body>

</html>