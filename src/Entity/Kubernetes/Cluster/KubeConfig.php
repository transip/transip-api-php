<?php

namespace Transip\Api\Library\Entity\Kubernetes\Cluster;

use Transip\Api\Library\Entity\AbstractEntity;

class KubeConfig extends AbstractEntity
{
    /**
     * base64 encoded yaml representation of the KubeConfig
     *
     * @var string
     */
    protected $encodedYaml;

    public function getEncodedYaml(): string
    {
        return $this->encodedYaml;
    }

    public function getYaml(): string
    {
        return base64_decode($this->getEncodedYaml());
    }
}
