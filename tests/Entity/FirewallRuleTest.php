<?php

declare(strict_types=1);

namespace Transip\Api\Library\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Transip\Api\Library\Entity\Vps\FirewallRule;

class FirewallRuleTest extends TestCase
{
    public function testTwoRulesAreEqualWhenAllFieldsAreEqual(): void
    {
        $ruleX = $this->getDefaultFirewallRule();
        $ruleY = $this->getDefaultFirewallRule();

        $this->assertTrue($ruleX->equalsRule($ruleY));
    }

    public function testTwoRulesAreEqualWhenWhitelistItemsAreInDifferentOrder(): void
    {
        $ruleX = $this->getDefaultFirewallRule();
        $ruleX->setWhitelist(["80.69.69.80/32", "80.69.69.100/32", "2a01:7c8:3:1337::1/128"]);

        $ruleY = $this->getDefaultFirewallRule();
        $ruleY->setWhitelist(["2a01:7c8:3:1337::1/128", "80.69.69.100/32", "80.69.69.80/32"]);

        $this->assertTrue($ruleX->equalsRule($ruleY));
    }

    public function testTwoRulesAreDifferentWhenDescriptionsAreDifferent(): void
    {
        $ruleX = $this->getDefaultFirewallRule();
        $ruleX->setDescription("foo");

        $ruleY = $this->getDefaultFirewallRule();
        $ruleY->setDescription("bar");

        $this->assertFalse($ruleX->equalsRule($ruleY));
    }

    public function testTwoRulesAreDifferentWhenProtocolsAreDifferent(): void
    {
        $ruleX = $this->getDefaultFirewallRule();
        $ruleX->setProtocol("foo");

        $ruleY = $this->getDefaultFirewallRule();
        $ruleY->setProtocol("bar");

        $this->assertFalse($ruleX->equalsRule($ruleY));
    }

    public function testTwoRulesAreDifferentWhenStartPortsAreDifferent(): void
    {
        $ruleX = $this->getDefaultFirewallRule();
        $ruleX->setStartPort(80);

        $ruleY = $this->getDefaultFirewallRule();
        $ruleY->setStartPort(591);

        $this->assertFalse($ruleX->equalsRule($ruleY));
    }

    public function testTwoRulesAreDifferentWhenEndPortsAreDifferent(): void
    {
        $ruleX = $this->getDefaultFirewallRule();
        $ruleX->setEndPort(80);

        $ruleY = $this->getDefaultFirewallRule();
        $ruleY->setEndPort(591);

        $this->assertFalse($ruleX->equalsRule($ruleY));
    }

    public function testTwoRulesAreDifferentWhenWhitelistsAreDifferent(): void
    {
        $ruleX = $this->getDefaultFirewallRule();
        $ruleX->setWhitelist(["80.69.69.80/32", "80.69.69.100/32"]);

        $ruleY = $this->getDefaultFirewallRule();
        $ruleY->setWhitelist(["80.69.69.100/32", "2a01:7c8:3:1337::1/128"]);

        $this->assertFalse($ruleX->equalsRule($ruleY));
    }

    private function getDefaultFirewallRule(): FirewallRule
    {
        $firewallRule = new FirewallRule();
        $firewallRule->setDescription("HTTP");
        $firewallRule->setProtocol("tcp");
        $firewallRule->setStartPort(80);
        $firewallRule->setEndPort(80);
        $firewallRule->setWhitelist(["80.69.69.80/32", "80.69.69.100/32", "2a01:7c8:3:1337::1/128"]);

        return $firewallRule;
    }
}
