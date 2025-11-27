<?php

declare(strict_types=1);

namespace Transip\Api\Library\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Transip\Api\Library\Entity\Vps\Firewall;
use Transip\Api\Library\Entity\Vps\FirewallRule;

class FirewallTest extends TestCase
{
    public function testAddRuleAddsNewRuleToAnEmptyRuleSet(): void
    {
        $firewall = new Firewall();
        $firewall->addRule($this->getDefaultFirewallRule());

        $this->assertCount(1, $firewall->getRuleSet());
        $this->assertEquals("HTTP", $firewall->getRuleSet()[0]->getDescription());
    }

    public function testAddRuleAddsNewRuleToARuleSet(): void
    {
        $firewall = new Firewall();
        $firewall->addRule($this->getDefaultFirewallRule());

        $newRule = $this->getDefaultFirewallRule();
        $newRule->setDescription("this is a new rule");

        $firewall->addRule($newRule);

        $this->assertCount(2, $firewall->getRuleSet());
        $this->assertEquals("HTTP", $firewall->getRuleSet()[0]->getDescription());
        $this->assertEquals("this is a new rule", $firewall->getRuleSet()[1]->getDescription());
    }

    public function testAddRuleDoesntAddTheSameRuleTwice(): void
    {
        $firewall = new Firewall();
        $firewall->addRule($this->getDefaultFirewallRule());
        $firewall->addRule($this->getDefaultFirewallRule());

        $this->assertCount(1, $firewall->getRuleSet());
    }

    public function testRemoveRuleActuallyRemovesRule(): void
    {
        $firewall = new Firewall();

        $rule = $this->getDefaultFirewallRule();
        $firewall->addRule($rule);

        $anotherRule = $this->getDefaultFirewallRule();
        $anotherRule->setDescription("this is another rule");
        $firewall->addRule($anotherRule);

        $this->assertCount(2, $firewall->getRuleSet());

        $firewall->removeRule($rule);

        $this->assertCount(1, $firewall->getRuleSet());
        $this->assertEquals("this is another rule", $firewall->getRuleSet()[0]->getDescription());
    }

    public function testRemoveRuleUsingANonExistingRuleDoesntRemoveIt(): void
    {
        $firewall = new Firewall();
        $firewall->addRule($this->getDefaultFirewallRule());

        $ruleToBeRemoved = $this->getDefaultFirewallRule();
        $ruleToBeRemoved->setDescription("this rule is not in the firewall rule set");

        $firewall->removeRule($ruleToBeRemoved);

        $this->assertCount(1, $firewall->getRuleSet());
        $this->assertEquals("HTTP", $firewall->getRuleSet()[0]->getDescription());
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
