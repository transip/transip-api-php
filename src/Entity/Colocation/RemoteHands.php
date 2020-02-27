<?php

namespace Transip\Api\Library\Entity\Colocation;

use Transip\Api\Library\Entity\AbstractEntity;

class RemoteHands extends AbstractEntity
{
    /**
     * @var string $coloName
     */
    protected $coloName;

    /**
     * @var string $contactName
     */
    protected $contactName;

    /**
     * @var string $phoneNumber
     */
    protected $phoneNumber;

    /**
     * @var int $expectedDuration
     */
    protected $expectedDuration;

    /**
     * @var string $instructions
     */
    protected $instructions;

    public function getColoName(): string
    {
        return $this->coloName;
    }

    public function setColoName(string $coloName): RemoteHands
    {
        $this->coloName = $coloName;
        return $this;
    }

    public function getContactName(): string
    {
        return $this->contactName;
    }

    public function setContactName(string $contactName): RemoteHands
    {
        $this->contactName = $contactName;
        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): RemoteHands
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getExpectedDuration(): int
    {
        return $this->expectedDuration;
    }

    public function setExpectedDuration(int $expectedDuration): RemoteHands
    {
        $this->expectedDuration = $expectedDuration;
        return $this;
    }

    public function getInstructions(): string
    {
        return $this->instructions;
    }

    public function setInstructions(string $instructions): RemoteHands
    {
        $this->instructions = $instructions;
        return $this;
    }
}
