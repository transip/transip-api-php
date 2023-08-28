<?php

namespace Transip\Api\Library\Entity\Kubernetes\Cluster;

class Release extends \Transip\Api\Library\Entity\Kubernetes\Release
{
    /**
     * @var bool
     */
    protected $isCompatibleUpgrade;

    public function isCompatibleUpgrade(): bool
    {
        return $this->isCompatibleUpgrade;
    }
}
