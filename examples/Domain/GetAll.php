<?php

/**
 * Using this API call, you are able to get all information about the domains in your account.
 */

require_once(__DIR__ . '/../Authenticate.php');


# Specify what additional information to include in the respone, currently supports either 'nameservers' or 'contacts' or both
$includes = ['nameservers', 'contacts'];


# Positive response will be an array of Transip\Api\Library\Entity\Domain objects
$domains = $api->domains()->getAll($includes);

print_r($domains);
