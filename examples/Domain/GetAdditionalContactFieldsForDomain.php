<?php

/**
 * Get additional contact data that has been filled in for a domain.
 */

require_once(__DIR__.'/../Authenticate.php');

$domainName = 'example.nu';

$result = ($api->additionalContactFields()->getByDomainName($domainName));

var_dump($result);


