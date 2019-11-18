<?php

namespace Transip\Api\Client\Entity\Domain;

use Transip\Api\Client\Entity\AbstractEntity;

class DnsEntry extends AbstractEntity
{
    const TYPE_A        = 'A';
    const TYPE_AAAA     = 'AAAA';
    const TYPE_CNAME    = 'CNAME';
    const TYPE_MX       = 'MX';
    const TYPE_NS       = 'NS';
    const TYPE_TXT      = 'TXT';
    const TYPE_SRV      = 'SRV';
    const TYPE_SSHFP    = 'SSHFP';
    const TYPE_TLSA     = 'TLSA';
    const TYPE_CAA      = 'CAA';

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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return DnsEntry
     */
    public function setName(string $name): DnsEntry
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpire(): int
    {
        return $this->expire;
    }

    /**
     * @param int $expire
     * @return DnsEntry
     */
    public function setExpire(int $expire): DnsEntry
    {
        $this->expire = $expire;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return DnsEntry
     */
    public function setType(string $type): DnsEntry
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return DnsEntry
     */
    public function setContent(string $content): DnsEntry
    {
        $this->content = $content;
        return $this;
    }
}
