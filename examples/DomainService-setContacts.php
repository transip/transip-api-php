<?php

/**
 * This example changes the contacts of a domain.
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

require_once('Transip/DomainService.php');

// Maintain a list of all possible contact types
$contactTypes = array(
	Transip_WhoisContact::TYPE_REGISTRANT, 
	Transip_WhoisContact::TYPE_ADMINISTRATIVE, 
	Transip_WhoisContact::TYPE_TECHNICAL);
$contacts = null;

if(isset($_REQUEST['domain']) && strlen($_REQUEST['domain']) > 0)
{
    $domain = $_REQUEST['domain'];
	
    try
    {
        // Check to see if we an action was requested and if so, do it
        if(isset($_POST['setContacts']))
        {
        	// Construct an array to hold Transip_WhoisContact objects for all contact types
        	$newContacts = array();
        	foreach($contactTypes as $type)
        	{
        		// Construct a new Transip_WhoisContact object
        		$newContact = new Transip_WhoisContact();
				$newContact->type = $type;
				$newContact->firstName = $_POST[$type]['firstName'];
				$newContact->middleName = $_POST[$type]['middleName'];
				$newContact->lastName = $_POST[$type]['lastName'];
				$newContact->companyName = $_POST[$type]['companyName'];
				$newContact->companyKvk = $_POST[$type]['companyKvk'];
				$newContact->companyType = $_POST[$type]['companyType'];
				$newContact->street = $_POST[$type]['street'];
				$newContact->number = $_POST[$type]['number'];
				$newContact->postalCode = $_POST[$type]['postalCode'];
				$newContact->city = $_POST[$type]['city'];
				$newContact->country = $_POST[$type]['country'];
				$newContact->phoneNumber = $_POST[$type]['phoneNumber'];
				$newContact->faxNumber = $_POST[$type]['faxNumber'];
				$newContact->email = $_POST[$type]['email'];
				
				// Add new contact to the list
				$newContacts[] = $newContact;
        	}
        
			// Set contacts for the domain by using the Transip_DomainService API;
            Transip_DomainService::setContacts($domain, $newContacts);
        }

        // Request the locked status of a domain by using the Transip_DomainService API;
        $info = Transip_DomainService::getInfo($domain);
		
		// The Transip_Domain object contains an array of Transip_WhoisContact objects
        // Each Transip_WhoisContact object has one of three types
		// Iterate through contacts and save in array
		foreach($info->contacts as $contact)
		{
			$contacts[$contact->type] = $contact;
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
    <h2>TransIP API Set Contacts Example</h2>
    Fill in the domain you want to set the owner for and click on Get Owner.
    <form name="domainChecker">
        <input type="text" name="domain" value="<?=htmlspecialchars($domain)?>"/>
        <input type="submit" value="Get Contacts"/><br/><br/>
    </form>

    <!-- setting contacts is a modifying action, so we need to
                        use POST instead of GET by the HTTP specs -->
    <form name="domainContacts" method="post" onsubmit="return enableFieldsForPost(this);">
    <input type="hidden" name="domain" value="<?=htmlspecialchars($domain)?>"/>
    <? 
    if(isset($error))
    {
        echo "<b>$error</b>";
    }
    else if($domain != '')
    {
    	// Display a table with contact data for every contact type
    	foreach($contactTypes as $type)
    	{
    		// Get the contact for the current type
    		$contact = $contacts[$type];
    		
	    	// Use util to construct list of company type options
		    // Only these values are allowed as company types in a Transip_WhoisContact object
			$companyTypeOptions = '';
			foreach(Transip_WhoisContact::$possibleCompanyTypes as $code => $desc)
			{
				$companyTypeOptions .= '<option ';
				if ($code == $contact->companyType)
					$companyTypeOptions .= 'selected="selected" ';
				$companyTypeOptions .= 'value="' . htmlspecialchars($code) . '">';
				$companyTypeOptions .= htmlspecialchars($desc) . '</option>';
			}
	
			// Use util to construct list of country code options
		    // Only these values are allowed as country codes in a Transip_WhoisContact object
			$countryCodeOptions = '';
			foreach(Transip_WhoisContact::$possibleCountryCodes as $code => $name)
			{
				$countryCodeOptions .= '<option ';
				if ($code == $contact->country)
					$countryCodeOptions .= 'selected="selected" ';
				$countryCodeOptions .= 'value="' . htmlspecialchars($code) . '">';
				$countryCodeOptions .= htmlspecialchars($name) . '</option>';
			}
	
			// A contact change will ignore some fields for the registrant contact
			// These can only be updated with an owner change
			$disabledForRegistrant = 
				$type == Transip_WhoisContact::TYPE_REGISTRANT 
					? 'disabled="disabled"' 
					: '';
	
			?>
			<h2><?=$type ?></h2>
			<table>
			<tr>
				<td><label for="<?=$type?>[firstName]">First name: </label></td>
				<td><input type="text" name="<?=$type?>[firstName]" 
					value="<?=htmlspecialchars($contact->firstName)?>" 
					<?=$disabledForRegistrant?>/></td>
			</tr>
	        <tr>
	        	<td><label for="<?=$type?>[middleName]">Middle name: </label></td>
	        	<td><input type="text" name="<?=$type?>[middleName]" 
	        		value="<?=htmlspecialchars($contact->middleName)?>" 
	        		<?=$disabledForRegistrant?>/></td>
	        </tr>
	        <tr>
	        	<td><label for="<?=$type?>[lastName]">Last name: </label></td>
	        	<td><input type="text" name="<?=$type?>[lastName]" 
	        		value="<?=htmlspecialchars($contact->lastName)?>" 
	        		<?=$disabledForRegistrant?>/></td>
	        </tr>
			<tr>
				<td><label for="<?=$type?>[companyName]">Company name: </label></td>
				<td><input type="text" name="<?=$type?>[companyName]" 
					value="<?=htmlspecialchars($contact->companyName)?>" 
					<?=$disabledForRegistrant?>/></td>
			</tr>
	        <tr>
	        	<td><label for="<?=$type?>[companyKvk]">Company KVK: </label></td>
	        	<td><input type="text" name="<?=$type?>[companyKvk]" 
	        		value="<?=htmlspecialchars($contact->companyKvk)?>" 
	        		<?=$disabledForRegistrant?>/></td>
	       	</tr>
	        <tr>
	        	<td><label for="<?=$type?>[companyType]">Company Type: </label></td>
	        	<td><select name="<?=$type?>[companyType]" 
	        		<?=$disabledForRegistrant?>><?=$companyTypeOptions;?></select></td>
	        </tr>
	        <tr>
	        	<td><label for="<?=$type?>[street]">Street: </label></td>
	        	<td><input type="text" name="<?=$type?>[street]" 
	        		value="<?=htmlspecialchars($contact->street)?>"/></td>
	        </tr>
	        <tr>
	        	<td><label for="<?=$type?>[number]">Number: </label></td>
	        	<td><input type="text" name="<?=$type?>[number]" 
	        		value="<?=htmlspecialchars($contact->number)?>"/></td>
	        </tr>
			<tr>
				<td><label for="<?=$type?>[postalCode]">Postal Code: </label></td>
				<td><input type="text" name="<?=$type?>[postalCode]" 
					value="<?=htmlspecialchars($contact->postalCode)?>"/></td>
			</tr>
			<tr>
				<td><label for="<?=$type?>[city]">City: </label></td>
				<td><input type="text" name="<?=$type?>[city]" 
					value="<?=htmlspecialchars($contact->city)?>"/></td>
			</tr>
	        <tr>
	        	<td><label for="<?=$type?>[country]">Country: </label></td>
	        	<td><select name="<?=$type?>[country]"><?=$countryCodeOptions;?>
	        		</select></td>
	        </tr>
	        <tr>
	        	<td><label for="<?=$type?>[phoneNumber]">Phone Number: </label></td>
	        	<td><input type="text" name="<?=$type?>[phoneNumber]" 
	        		value="<?=htmlspecialchars($contact->phoneNumber)?>"/></td>
	        </tr>
	        <tr>
	        	<td><label for="<?=$type?>[faxNumber]">Fax Number: </label></td>
	        	<td><input type="text" name="<?=$type?>[faxNumber]" 
	        		value="<?=htmlspecialchars($contact->faxNumber)?>"/></td>
	        </tr>
	        <tr>
	        	<td><label for="<?=$type?>[email]">Email: </label></td>
	        	<td><input type="text" name="<?=$type?>[email]" 
	        		value="<?=htmlspecialchars($contact->email)?>" 
	        		<?=$disabledForRegistrant?>/></td>
	        </tr>
			</table>
	
			<?
    	}
		?> <br/><input type="submit" name="setContacts" value="Set Contacts"/> <?php
    }
    ?>
    </form>

	<script type="text/javascript">
		/**
		 *  enable all form fields, so they will be submitted
		 *
		 *  @param	 object		formelement
		 *  @return	 bool
		 */
		function enableFieldsForPost(form) {
			// build the form elements groups
			groups = [ 
				form.getElementsByTagName("input"),
				form.getElementsByTagName("select"),
				form.getElementsByTagName("textarea"),
				form.getElementsByTagName("button")
			];
			// for each group, and for each element in that group, remove the disabled attribute
			for(var i = 0; i < groups.length; ++i)
				for(var t = 0; t < groups[ i ].length ; ++t)
					groups[i][t].removeAttribute('disabled');
			// success!
			return true;
		}
	</script>
</body>
</html>