<?php

namespace Transip\Api\Library\Entity\Domain;

use Transip\Api\Library\Entity\AbstractEntity;

class Action extends AbstractEntity
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $message
     */
    protected $message;

    /**
     * @var bool $hasFailed
     */
    protected $hasFailed;

    public function getName(): string
    {
        return $this->name;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getHasFailed(): bool
    {
        return $this->hasFailed;
    }
}
