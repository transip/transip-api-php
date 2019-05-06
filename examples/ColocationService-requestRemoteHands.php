<?php

/**
 * This example requests remotehands
 *
 * @copyright Copyright 2011 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */


require_once('Transip/ColocationService.php');

if(isset($_POST['request']) && count($_POST['request']) > 0)
{
	extract($_POST['request']);
	try
	{
		$dataCenterHandsRequest = Transip_ColocationService::requestRemoteHands(
				$coloName, $contactName, $phoneNumber, $expectedDuration, $instructions);
		$result = 'The request has been sent.';
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
	<title>TransIP API Datacenter Remote Hands Request</title>
</head>

<body>
	<h2>TransIP API Datacenter Remote Hands Request</h2>
	<?=(isset($result)?'<p><pre>'.$result.'</pre></p>':'')?>
	Fill out the form to create a remote hands request
	<form name="accessRequest" method="post">
		<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top">
					Colocation name
				</td>
				<td>
					<input type="text" name="request[coloName]"
						value="<?=isset($coloName)?$coloName:''?>" />
				</td>
			</tr>
			<tr>
				<td valign="top">
					Contact name
				</td>
				<td>
					<input type="text" name="request[contactName]"
						value="<?=isset($contactName)?$contactName:''?>" />
				</td>
			</tr>

			<tr>
				<td valign="top">
					Contact phone number
				</td>
				<td>
					<input type="text" name="request[phoneNumber]"
						value="<?=isset($phoneNumber)?$phoneNumber:''?>" />
				</td>
			</tr>
			<tr>
				<td valign="top">
					Expected duration of the task (in minutes)
				</td>
				<td>
					<input type="text" name="request[expectedDuration]"
						value="<?=isset($expectedDuration)?$expectedDuration:30?>" />
				</td>
			</tr>
			<tr>
				<td valign="top" colspan="2">
					Instructions for the task<br />
					<textarea name="request[instructions]" cols="30"><?=isset($instructions)?$instructions:''?></textarea>
				</td>
			</tr>
			<tr>
				<td>&#160;</td>
				<td>
					<input type="submit" value="Request hands" />
				</td>
			</tr>
		</table>
	</form>
	
</body>

</html>
