<?php

namespace Transip\Api\Library\Entity\Domain;

use Transip\Api\Library\Entity\AbstractEntity;

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
    public const TYPE_NAPTR    = 'NAPTR';
    public const TYPE_ALIAS    = 'ALIAS';

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var int $expire
     */
    protected $expire;

    /**
     * @var string $type
     */
    protected $type;

    /**
     * @var string $content
     */
    protected $content;

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

    public function getRdata(): string
    {
        if (in_array($this->getType(), [self::TYPE_CAA,self::TYPE_TXT])) {
            return json_encode($this->content);
        } else {
            return $this->content;
        }
    }

    public function setContent(string $content): DnsEntry
    {
        $this->content = $content;
        return $this;
    }
}
