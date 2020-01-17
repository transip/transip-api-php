<?php

/**
 * This is an example on how to retrieve all available products. When introducing a new product, TransIP will add its
 * properties to this output, allowing you to keep up with new changes.
 */

require_once('Authenticate.php');

// List all available products
$products = $api->products()->getAll();

print_r($products);
