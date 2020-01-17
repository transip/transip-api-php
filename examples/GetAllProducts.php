<?php

require('Authenticate.php');

// List all available products
$products = $api->products()->getAll();

print_r($products);
