<?php

/**
 * This example sets the owner/registrant of a domain.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

require_once('Transip/DomainService.php');

$owner = null;
if(isset($_REQUEST['domain']) && strlen($_REQUEST['domain']) > 0)
{
    $domain = $_REQUEST['domain'];
	
    try
    {
        // Check to see if we an action was requested and if so, do it
        if(isset($_POST['setOwner']))
        {
        	// Construct a new WhoisContact object
			$newOwner = new Transip_WhoisContact();
			$newOwner->type = Transip_WhoisContact::TYPE_REGISTRANT;
			$newOwner->firstName = $_POST['firstName'];
			$newOwner->middleName = $_POST['middleName'];
			$newOwner->lastName = $_POST['lastName'];
			$newOwner->companyName = $_POST['companyName'];
			$newOwner->companyKvk = $_POST['companyKvk'];
			$newOwner->companyType = $_POST['companyType'];
			$newOwner->street = $_POST['street'];
			$newOwner->number = $_POST['number'];
			$newOwner->postalCode = $_POST['postalCode'];
			$newOwner->city = $_POST['city'];
			$newOwner->country = $_POST['country'];
			$newOwner->phoneNumber = $_POST['phoneNumber'];
			$newOwner->faxNumber = $_POST['faxNumber'];
			$newOwner->email = $_POST['email'];

			// Set owner for the domain by using the Transip_DomainService API;
            Transip_DomainService::setOwner($domain, $newOwner);
        }

        // Request the locked status of a domain by using the Transip_DomainService API;
        $info = Transip_DomainService::getInfo($domain);
		
        // The Domain object contains an array of WhoisContact objects
        // Each WhoisContact object has one of three types
		// Iterate through contacts to find registrant (owner)
		foreach($info->contacts as $contact)
		{
			if ($contact->type == Transip_WhoisContact::TYPE_REGISTRANT )
			{
				$owner = $contact;
				break;
			}
		}
    }
    catch(SoapFault $e)
    {
        // It is possible that an error occurs when connecting to the TransIP Soap API,
        // those errors will be thrown as a SoapFault exception.
        $error = 'An error occurred: ' . htmlspecialchars($e->getMessage());
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
    <h2>TransIP API Set Owner Example</h2>
    Fill in the domain you want to set the owner for and click on Get Owner.
    <form name="domainChecker">
        <input type="text" name="domain" value="<?=htmlspecialchars($domain)?>"/>
        <input type="submit" value="Get Owner"/><br/><br/>
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
    	// Use util to construct list of company type options
	    // Only these values are allowed as company types in a WhoisContact object
		$companyTypeOptions = '';
		foreach(Transip_WhoisContact::$possibleCompanyTypes as $code => $desc)
		{
			$companyTypeOptions .= '<option ';
			if ($code == $owner->companyType)
				$companyTypeOptions .= 'selected="selected" ';
			$companyTypeOptions .= 'value="' . htmlspecialchars($code) . '">';
			$companyTypeOptions .= htmlspecialchars($desc) . '</option>';
		}

		// Use util to construct list of country code options
	    // Only these values are allowed as country codes in a WhoisContact object
		$countryCodeOptions = '';
		foreach(Transip_WhoisContact::$possibleCountryCodes as $code => $name)
		{
			$countryCodeOptions .= '<option ';
			if ($code == $owner->country)
				$countryCodeOptions .= 'selected="selected" ';
			$countryCodeOptions .= 'value="' . htmlspecialchars($code) . '">';
			$countryCodeOptions .= htmlspecialchars($name) . '</option>';
		}

		?>
		<table>
		<tr>
			<td><label for="firstName">First name: </label></td>
			<td><input type="text" name="firstName" 
				value="<?=htmlspecialchars($owner->firstName)?>"/></td>
		</tr>
        <tr>
        	<td><label for="middleName">Middle name: </label></td>
        	<td><input type="text" name="middleName" 
        		value="<?=htmlspecialchars($owner->middleName)?>"/></td></tr>
        <tr>
        	<td><label for="lastName">Last name: </label></td>
        	<td><input type="text" name="lastName" 
        		value="<?=htmlspecialchars($owner->lastName)?>"/></td></tr>
		<tr>
			<td><label for="companyName">Company name: </label></td>
			<td><input type="text" name="companyName" 
				value="<?=htmlspecialchars($owner->companyName)?>"/></td></tr>
        <tr>
        	<td><label for="companyKvk">Company KVK: </label></td>
        	<td><input type="text" name="companyKvk" 
        		value="<?=htmlspecialchars($owner->companyKvk)?>"/></td></tr>
        <tr>
        	<td><label for="companyType">Company Type: </label></td>
        	<td><select name="companyType"><?=$companyTypeOptions;?></select></td></tr>
        <tr>
        	<td><label for="street">Street: </label></td>
        	<td><input type="text" name="street" 
        		value="<?=htmlspecialchars($owner->street)?>"/></td></tr>
        <tr>
        	<td><label for="number">Number: </label></td>
        	<td><input type="text" name="number" 
        		value="<?=htmlspecialchars($owner->number)?>"/></td></tr>
		<tr>
			<td><label for="postalCode">Postal Code: </label></td>
			<td><input type="text" name="postalCode" 
				value="<?=htmlspecialchars($owner->postalCode)?>"/></td></tr>
		<tr>
			<td><label for="city">City: </label></td>
			<td><input type="text" name="city" 
				value="<?=htmlspecialchars($owner->city)?>"/></td></tr>
        <tr>
        	<td><label for="country">Country: </label></td>
        	<td><select name="country"><?=$countryCodeOptions;?></select></td></tr>
        <tr>
        	<td><label for="phoneNumber">Phone Number: </label></td>
        	<td><input type="text" name="phoneNumber" 
        		value="<?=htmlspecialchars($owner->phoneNumber)?>"/></td></tr>
        <tr>
        	<td><label for="faxNumber">Fax Number: </label></td>
        	<td><input type="text" name="faxNumber" 
        		value="<?=htmlspecialchars($owner->faxNumber)?>"/></td></tr>
        <tr>
        	<td><label for="email">Email: </label></td>
        	<td><input type="text" name="email" 
        		value="<?=htmlspecialchars($owner->email)?>"/></td></tr>
		</table>

        <br/><input type="submit" name="setOwner" value="Set Owner"/>
		<?
    }
    ?>
    </form>
</body>
</html>