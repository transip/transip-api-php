<?php

// Include domainservice
require_once('Transip/DomainService.php');

try
{
    // Register a domain with your default settings
    // It's also possible to register with custom settings,
    // for this the call should be like:
    // $domain = new Transip_Domain('transip.nl', <array of nameservers>, <array of contacts>,
    //                   <array of dns entries>);
    $domain = new Transip_Domain('example.com');

    // Add extra contact fields to register request
    // Some domains require extra contact fields to be able to register the domain
    // To know if your domain needs extra contact fields see examples/DomainService-getExtraContactFields.php
    // The format for the extra contact fields should be like:
    // $extraContactFields = ['extraContactField' => 'value', ...];

    $extraContactFieldName = 'EXAMPLE_NAME';
    $extraContactFieldValue = 'example_value';
    $extraContactField = new Transip_ExtraContactField($extraContactFieldName, $extraContactFieldValue);
    $extraContactFields = [$extraContactField];

    $propositionNumber = Transip_DomainService::registerWithExtraContactFields($domain, $extraContactFields);
    echo 'The domain ' . $domain->name . ' has been requested with proposition number ' . $propositionNumber;
}
catch(SoapFault $e)
{
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occured: '. $e->getMessage(), PHP_EOL;
}

?>
