<?php

use Transip\Api\Library\TransipAPI;

define('BASE_PATH', dirname(__DIR__));

chdir(BASE_PATH);
exec('composer dump-autoload');

require_once(BASE_PATH . '/vendor/autoload.php');

if (!isset($argv[1])) {
    throw new RuntimeException("An argument must be provided, usage example: php {$argv[0]} 6.1.3");
}

if (TransipAPI::TRANSIP_API_LIBRARY_VERSION !== $argv[1]) {
    throw new RuntimeException("Version in TransipAPI class must be {$argv[1]}");
}
