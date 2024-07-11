<?php

declare(strict_types=1);

namespace Transip\Api\Library\Entity\Email;

use Transip\Api\Library\Entity\AbstractEntity;

class MailAddon extends AbstractEntity
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var int $diskSpace
     */
    public $diskSpace;

    /**
     * @var int $mailboxes
     */
    public $mailboxes;

    /**
     * @var string $linkedMailBox
     */
    public $linkedMailBox;

    /**
     * @var bool $canBeLinked
     */
    public $canBeLinked;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDiskSpace(): int
    {
        return $this->diskSpace;
    }

    public function setDiskSpace(int $diskSpace): void
    {
        $this->diskSpace = $diskSpace;
    }

    public function getMailboxes(): int
    {
        return $this->mailboxes;
    }

    public function setMailboxes(int $mailboxes): void
    {
        $this->mailboxes = $mailboxes;
    }

    public function getLinkedMailBox(): string
    {
        return $this->linkedMailBox;
    }

    public function setLinkedMailBox(string $linkedMailBox): void
    {
        $this->linkedMailBox = $linkedMailBox;
    }

    public function isCanBeLinked(): bool
    {
        return $this->canBeLinked;
    }

    public function setCanBeLinked(bool $canBeLinked): void
    {
        $this->canBeLinked = $canBeLinked;
    }
}
