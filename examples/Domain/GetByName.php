<?php

/**
 * Using this API call, you are able to get all information about a domain in your account.
 */

require_once(__DIR__ . '/../Authenticate.php');

# Specify the domain name
$domainName = 'example.com';

# Specify what additional information to include in the respone, currently supports either 'nameservers' or 'contacts' or both
$includes = ['nameservers', 'contacts'];

# Positive response will be a single Transip\Api\Library\Entity\Domain object
$domain = $api->domains()->getByName($domainName, $includes);

print_r($domain);
