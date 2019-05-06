<?php

/**
 * This example sets or unsets the lock status of a domain.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

require_once('Transip/DomainService.php');

if(isset($_REQUEST['domain']) && strlen($_REQUEST['domain']) > 0)
{
	$domain = $_REQUEST['domain'];

	try
	{
		// Check to see if we an action was requested and if so, do it
		if(isset($_POST['lock']))
		{
			// Lock the  domain by using the Transip_DomainService API;
			$isLocked = Transip_DomainService::setLock($domain);
		}
		
		if(isset($_POST['unlock']))
		{
			// Unlock the domain by using the Transip_DomainService API;
			$isLocked = Transip_DomainService::unsetLock($domain);
		}

		// Request the locked status of a domain by using the Transip_DomainService API;
		$isLocked = Transip_DomainService::getIsLocked($domain);
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
	$isLocked = false;
}

?>
<html>
<head>
</head>

<body>
	<h2>TransIP API Locking Example</h2>
	Fill in the domain you want to get the authcode for and click on Get LockStatus.
	<form name="domainChecker">
		<input type="text" name="domain" value="<?=htmlspecialchars($domain)?>">
		<input type="submit" value="Get LockStatus"/><br/><br/>
	</form>

	<!-- locking/unlocking is a modifying action, so we need to
						use POST instead of GET by the HTTP specs -->
	<form name="domainLocker" method="post">
	<input type="hidden" name="domain" value="<?=htmlspecialchars($domain)?>"/>
	<? 
	if(isset($error))
	{
		echo "<b>$error</b>";
	}
	else if($domain != '')
	{
		if($isLocked)
		{
			?>The domain <?=htmlspecialchars($domain)?> is <b>LOCKED</b>
					<br/><input type="submit"  name="unlock" value="Unlock it"/><?
		}
		else
		{
			?>The domain <?=htmlspecialchars($domain)?> is <b>UNLOCKED</b>
					<br/><input type="submit" name="lock"  value="Lock it"/><?
		}
	}
	?>
	</form>
</body>
</html>