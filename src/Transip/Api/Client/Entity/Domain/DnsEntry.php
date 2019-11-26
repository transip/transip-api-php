<?php

namespace Transip\Api\Client\Entity\Domain;

use Transip\Api\Client\Entity\AbstractEntity;

class DnsEntry extends AbstractEntity
{
    public const TYPE_A        = 'A';
    public const TYPE_AAAA     = 'AAAA';
    public const TYPE_CNAME    = 'CNAME';
    public const TYPE_MX       = 'MX';
    public const TYPE_NS       = 'NS';
    public const TYPE_TXT      = 'TXT';
    public const TYPE_SRV      = 'SRV';
    public const TYPE_SSHFP    = 'SSHFP';
    public const TYPE_TLSA     = 'TLSA';
    public const TYPE_CAA      = 'CAA';

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var int $expire
     */
    public $expire;

    /**
     * @var string $type
     */
    public $type;

    /**
     * @var string $content
     */
    public $content;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): DnsEntry
    {
        $this->name = $name;
        return $this;
    }

    public function getExpire(): int
    {
        return $this->expire;
    }

    public function setExpire(int $expire): DnsEntry
    {
        $this->expire = $expire;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): DnsEntry
    {
        $this->type = $type;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): DnsEntry
    {
        $this->content = $content;
        return $this;
    }
}
