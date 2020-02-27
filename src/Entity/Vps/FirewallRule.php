<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class FirewallRule extends AbstractEntity
{
    public const PROTOCOL_TCP = 'tcp';
    public const PROTOCOL_UDP = 'udp';
    public const PROTOCOL_TCP_UDP = 'tcp_udp';

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var int $startPort
     */
    protected $startPort;

    /**
     * @var int $endPort
     */
    protected $endPort;

    /**
     * @var string $protocol
     */
    protected $protocol;

    /**
     * @var array $whitelist
     */
    protected $whitelist;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): FirewallRule
    {
        $this->description = $description;
        return $this;
    }

    public function getStartPort(): int
    {
        return $this->startPort;
    }

    public function setStartPort(int $startPort): FirewallRule
    {
        $this->startPort = $startPort;
        return $this;
    }

    public function getEndPort(): int
    {
        return $this->endPort;
    }

    public function setEndPort(int $endPort): FirewallRule
    {
        $this->endPort = $endPort;
        return $this;
    }

    public function getProtocol(): string
    {
        return $this->protocol;
    }

    public function setProtocol(string $protocol): FirewallRule
    {
        $this->protocol = $protocol;
        return $this;
    }

    public function getWhitelist(): array
    {
        return $this->whitelist;
    }

    public function setWhitelist(array $whitelist): FirewallRule
    {
        $this->whitelist = $whitelist;
        return $this;
    }

    public function addRangeToWhitelist(string $ipRange): FirewallRule
    {
        $this->whitelist[] = $ipRange;
        return $this;
    }

    public function removeRangeToWhitelist(string $ipRange): FirewallRule
    {
        $whitelist = [];
        foreach ($whitelist as $whitelistEntry) {
            if ($whitelistEntry !== $ipRange) {
                $whitelist[] = $whitelistEntry;
            }
        }
        $this->setWhitelist($whitelist);
        return $this;
    }

    public function equalsRule(FirewallRule $rule): bool
    {
        return $rule->protocol == $this->protocol &&
            $rule->startPort == $this->startPort &&
            $rule->endPort == $this->endPort;
    }
}
