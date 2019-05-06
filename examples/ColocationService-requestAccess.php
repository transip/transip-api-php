<?php

/**
 * This example requests access to the datacenter
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
		// filter out empty input fields
		$visitor = array_filter($visitor, 'strlen');

		$dataCenterVisitors = Transip_ColocationService::requestAccess(
				$when, $duration, $visitor, $phoneNumber);

		$result = '';
		foreach($dataCenterVisitors as $dataCenterVisitor)
		{
			if($dataCenterVisitor->hasBeenRegisteredBefore)
			{
				$result .= "{$dataCenterVisitor->name} (no code needed)\n";
			}
			else
			{
				$result .= "{$dataCenterVisitor->name}";
				$result .= " (reservation number: {$dataCenterVisitor->reservationNumber};";
				$result .= " access code: {$dataCenterVisitor->accessCode})\n";
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

?>
<html>
<head>
</head>

<body>
	<h2>TransIP API Datacenter Access Request</h2>
	<?=(isset($result)?"<p><pre>".$result."</pre></p>":"")?>
	Fill out the form to create an access request
    <!-- access request is a modifying action, so we need to
                        use POST instead of GET by the HTTP specs -->
	<form name="accessRequest" method="post">
		<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top">
					Access date/time (YYYY-MM-DD hh:mm:ss)
				</td>
				<td>
					<input type="text" name="request[when]"
						value="<?=isset($when)?$when:date('Y-m-d H:i:s')?>" />
				</td>
			</tr>
			<tr>
				<td valign="top">
					Visit duration (minutes)
				</td>
				<td>
					<input type="text" name="request[duration]"
						value="<?=isset($duration)?$duration:30?>" />
				</td>
			</tr>
			<?php
for($i = 0; $i < 3; $i++)
{
			?>
			<tr>
				<td valign="top">
					Visitor <?=$i+1?>
				</td>
				<td>
					<input type="text" name="request[visitor][<?=$i?>]"
						value="<?=isset($visitor[$i])?$visitor[$i]:''?>" />
				</td>
			</tr>
			<?php
}
			?>
			<tr>
				<td valign="top">
					Mobile phone number
				</td>
				<td>
					<input type="text" name="request[phoneNumber]"
						value="<?=isset($phonenumber)?$phonenumber:""?>" />
				</td>
			</tr>
			<tr>
				<td>&#160;</td>
				<td>
					<input type="submit" value="Request access" />
				</td>
			</tr>
		</table>
	</form>
	
</body>

</html>