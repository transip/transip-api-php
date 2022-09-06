<?php

/**
 * Get additional contact data that has been filled in for a domain.
 */

require_once(__DIR__.'/../../Authenticate.php');

$result = ($api->additionalContactFields()->getForTld('.nu'));

var_dump($result);
