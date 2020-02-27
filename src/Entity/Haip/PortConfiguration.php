<?php

namespace Transip\Api\Library\Entity\Haip;

use Transip\Api\Library\Entity\AbstractEntity;

class PortConfiguration extends AbstractEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $sourcePort;

    /**
     * @var int
     */
    protected $targetPort;

    /**
     * @var string
     */
    protected $mode;

    /**
     * @var string
     */
    protected $endpointSslMode;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSourcePort(): int
    {
        return $this->sourcePort;
    }

    public function getTargetPort(): int
    {
        return $this->targetPort;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function getEndpointSslMode(): string
    {
        return $this->endpointSslMode;
    }

    public function setName(string $name): PortConfiguration
    {
        $this->name = $name;
        return $this;
    }

    public function setSourcePort(int $sourcePort): PortConfiguration
    {
        $this->sourcePort = $sourcePort;
        return $this;
    }

    public function setTargetPort(int $targetPort): PortConfiguration
    {
        $this->targetPort = $targetPort;
        return $this;
    }

    public function setMode(string $mode): PortConfiguration
    {
        $this->mode = $mode;
        return $this;
    }

    public function setEndpointSslMode(string $endpointSslMode): PortConfiguration
    {
        $this->endpointSslMode = $endpointSslMode;
        return $this;
    }
}
