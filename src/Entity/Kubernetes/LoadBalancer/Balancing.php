<?php
namespace Transip\Api\Library\Entity\Kubernetes\LoadBalancer;

use Transip\Api\Library\Entity\AbstractEntity;

class Balancing extends AbstractEntity
{
    /**
     * @var string
     */
    protected $mode;

    /**
     * @var string
     */
    protected $cookieName;

    public function getMode(): string
    {
        return $this->mode;
    }

    public function getCookieName(): string
    {
        return $this->cookieName;
    }
}
