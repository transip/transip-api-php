<?php

// Include PropositionService
require_once('Transip/PropositionService.php');

try
{
	// Check the status of a proposition ordered through the API.
	$propositionNumber = '';
	$propositionStatus = Transip_PropositionService::getPropositionStatus($propositionNumber);

    echo 'The status of proposition ' . $propositionNumber . ' is ' . $propositionStatus;
}
catch(SoapFault $e)
{
	// It is possible that an error occurs when connecting to the TransIP Soap API,
	// those errors will be thrown as a SoapFault exception.
	echo 'An error occured: '. $e->getMessage(), PHP_EOL;
}

?>