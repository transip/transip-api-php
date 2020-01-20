<?php

use Transip\Api\Library\Entity\Vps\FirewallRule;

require(__DIR__ . '/../../Authenticate.php');

// Create a Firewall rules object
$firewallRule = new FirewallRule();
$firewallRule->setDescription('HTTP');
$firewallRule->setStartPort(80);
$firewallRule->setEndPort(80);
$firewallRule->setProtocol('tcp');
$firewallRule->setWhitelist([]);

// Get current rules list
$firewall = $api->vpsFirewall()->getByVpsName($vpsName);

// Add rules to current list
$firewall->addRule($firewallRule);

// Apply the changes
$api->vpsFirewall()->update($vpsName, $firewall);
