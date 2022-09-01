<?php

/**
 * Get additional contact data that has been filled in for a domain.
 */

require_once('../Authenticate.php');

$domainName = 'example.com';

$filledInAdditionalContactFieldData = $api->additionalContactFieldData()->getByDomainName($domainName);
var_dump($filledInAdditionalContactFieldData);
