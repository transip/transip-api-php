<?php
namespace Transip\Api\Library\Entity\Kubernetes\LoadBalancer;

use Transip\Api\Library\Entity\AbstractEntity;

class Port extends AbstractEntity
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var string
     */
    protected $mode;

    public function getName(): string
    {
        return $this->name;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getMode(): string
    {
        return $this->mode;
    }
}
