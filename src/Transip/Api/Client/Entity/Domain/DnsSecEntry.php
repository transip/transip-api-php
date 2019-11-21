<?php

namespace Transip\Api\Client\Entity\Domain;

use Transip\Api\Client\Entity\AbstractEntity;

class DnsSecEntry extends AbstractEntity
{
    /**
     * @var int $keyTag
     */
    public $keyTag;

    /**
     * @var int $flags
     */
    public $flags;

    /**
     * @var int $algorithm
     */
    public $algorithm;

    /**
     * @var string $publicKey
     */
    public $publicKey;

    public function getKeyTag(): int
    {
        return $this->keyTag;
    }

    public function setKeyTag(int $keyTag): DnsSecEntry
    {
        $this->keyTag = $keyTag;
        return $this;
    }

    public function getFlags(): int
    {
        return $this->flags;
    }

    public function setFlags(int $flags): DnsSecEntry
    {
        $this->flags = $flags;
        return $this;
    }

    public function getAlgorithm(): int
    {
        return $this->algorithm;
    }

    public function setAlgorithm(int $algorithm): DnsSecEntry
    {
        $this->algorithm = $algorithm;
        return $this;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function setPublicKey(string $publicKey): DnsSecEntry
    {
        $this->publicKey = $publicKey;
        return $this;
    }
}
