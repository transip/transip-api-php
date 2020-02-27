<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class Firewall extends AbstractEntity
{
    /**
     * @var bool $isEnabled
     */
    protected $isEnabled;

    /**
     * @var FirewallRule[] $ruleSet
     */
    protected $ruleSet;

    public function __construct(array $valueArray = [])
    {
        parent::__construct($valueArray);

        $ruleSet      = [];
        $ruleSetArray = $valueArray['ruleSet'] ?? [];
        foreach ($ruleSetArray as $ruleArray) {
            $ruleSet[] = new FirewallRule($ruleArray);
        }

        $this->ruleSet = $ruleSet;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): Firewall
    {
        $this->isEnabled = $isEnabled;
        return $this;
    }

    /**
     * @return FirewallRule[]
     */
    public function getRuleSet(): array
    {
        return $this->ruleSet;
    }

    /**
     * @param FirewallRule[] $ruleSet
     * @return Firewall
     */
    public function setRuleSet(array $ruleSet): Firewall
    {
        $this->ruleSet = $ruleSet;
        return $this;
    }

    public function addRule(FirewallRule $firewallRule): Firewall
    {
        $ruleSet = [];
        foreach ($this->getRuleSet() as $rule) {
            if ($rule->equalsRule($firewallRule)) {
                $ruleSet[] = $firewallRule;
            } else {
                $ruleSet[] = $rule;
            }
        }
        $this->ruleSet[] = $firewallRule;
        return $this;
    }

    public function removeRule(FirewallRule $firewallRule): Firewall
    {
        $newRuleSet = [];
        foreach ($this->getRuleSet() as $rule) {
            if (!$rule->equalsRule($firewallRule)) {
                $newRuleSet[] = $rule;
            }
        }
        $this->setRuleSet($newRuleSet);
        return $this;
    }
}
