<?php

namespace Transip\Api\Client\Entity\Haip;

use Transip\Api\Client\Entity\AbstractEntity;

class PortConfiguration extends AbstractEntity
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $sourcePort;

    /**
     * @var int
     */
    public $targetPort;

    /**
     * @var string
     */
    public $mode;

    /**
     * @var string
     */
    public $endpointSslMode;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getSourcePort(): int
    {
        return $this->sourcePort;
    }

    /**
     * @return int
     */
    public function getTargetPort(): int
    {
        return $this->targetPort;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @return bool
     */
    public function isEndpointSslMode(): bool
    {
        return $this->endpointSslMode;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $sourcePort
     */
    public function setSourcePort(int $sourcePort): void
    {
        $this->sourcePort = $sourcePort;
    }

    /**
     * @param int $targetPort
     */
    public function setTargetPort(int $targetPort): void
    {
        $this->targetPort = $targetPort;
    }

    /**
     * @param string $mode
     */
    public function setMode(string $mode): void
    {
        $this->mode = $mode;
    }

    /**
     * @param bool $endpointSslMode
     */
    public function setEndpointSslMode(string $endpointSslMode): void
    {
        $this->endpointSslMode = $endpointSslMode;
    }

    /**
     * @return string
     */
    public function getEndpointSslMode(): string
    {
        return $this->endpointSslMode;
    }
}