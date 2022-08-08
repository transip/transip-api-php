<?php

namespace Transip\Api\Library\Entity\Email;

use Transip\Api\Library\Entity\AbstractEntity;

class Mailbox extends AbstractEntity
{
    /**
     * @var string $identifier
     */
    public $identifier;

    /**
     * @var string $localPart
     */
    public $localPart;

    /**
     * @var string $domain
     */
    public $domain;

    /**
     * @var string $forwardTo
     */
    public $forwardTo;

    /**
     * @var int $availableDiskSpace
     */
    public $availableDiskSpace;

    /**
     * @var float $usedDiskSpace
     */
    public $usedDiskSpace;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var bool $isLocked
     */
    public $isLocked;

    /**
     * @var string $imapServer
     */
    public $imapServer;

    /**
     * @var int $imapPort
     */
    public $imapPort;

    /**
     * @var string $smtpServer
     */
    public $smtpServer;

    /**
     * @var int $smtpPort
     */
    public $smtpPort;

    /**
     * @var string $pop3Server
     */
    public $pop3Server;

    /**
     * @var int $pop3Port
     */
    public $pop3Port;

    /**
     * @var string $webmailUrl
     */
    public $webmailUrl;

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getLocalPart(): string
    {
        return $this->localPart;
    }

    /**
     * @param string $localPart
     */
    public function setLocalPart(string $localPart): void
    {
        $this->localPart = $localPart;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getForwardTo(): string
    {
        return $this->forwardTo;
    }

    /**
     * @param string $forwardTo
     */
    public function setForwardTo(string $forwardTo): void
    {
        $this->forwardTo = $forwardTo;
    }

    /**
     * @return int
     */
    public function getAvailableDiskSpace(): int
    {
        return $this->availableDiskSpace;
    }

    /**
     * @param int $availableDiskSpace
     */
    public function setAvailableDiskSpace(int $availableDiskSpace): void
    {
        $this->availableDiskSpace = $availableDiskSpace;
    }

    /**
     * @return float
     */
    public function getUsedDiskSpace(): float
    {
        return $this->usedDiskSpace;
    }

    /**
     * @param float $usedDiskSpace
     */
    public function setUsedDiskSpace(float $usedDiskSpace): void
    {
        $this->usedDiskSpace = $usedDiskSpace;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->isLocked;
    }

    /**
     * @param bool $isLocked
     */
    public function setIsLocked(bool $isLocked): void
    {
        $this->isLocked = $isLocked;
    }

    /**
     * @return string
     */
    public function getImapServer(): string
    {
        return $this->imapServer;
    }

    /**
     * @param string $imapServer
     */
    public function setImapServer(string $imapServer): void
    {
        $this->imapServer = $imapServer;
    }

    /**
     * @return int
     */
    public function getImapPort(): int
    {
        return $this->imapPort;
    }

    /**
     * @param int $imapPort
     */
    public function setImapPort(int $imapPort): void
    {
        $this->imapPort = $imapPort;
    }

    /**
     * @return string
     */
    public function getSmtpServer(): string
    {
        return $this->smtpServer;
    }

    /**
     * @param string $smtpServer
     */
    public function setSmtpServer(string $smtpServer): void
    {
        $this->smtpServer = $smtpServer;
    }

    /**
     * @return int
     */
    public function getSmtpPort(): int
    {
        return $this->smtpPort;
    }

    /**
     * @param int $smtpPort
     */
    public function setSmtpPort(int $smtpPort): void
    {
        $this->smtpPort = $smtpPort;
    }

    /**
     * @return string
     */
    public function getPop3Server(): string
    {
        return $this->pop3Server;
    }

    /**
     * @param string $pop3Server
     */
    public function setPop3Server(string $pop3Server): void
    {
        $this->pop3Server = $pop3Server;
    }

    /**
     * @return int
     */
    public function getPop3Port(): int
    {
        return $this->pop3Port;
    }

    /**
     * @param int $pop3Port
     */
    public function setPop3Port(int $pop3Port): void
    {
        $this->pop3Port = $pop3Port;
    }

    /**
     * @return string
     */
    public function getWebmailUrl(): string
    {
        return $this->webmailUrl;
    }

    /**
     * @param string $webmailUrl
     */
    public function setWebmailUrl(string $webmailUrl): void
    {
        $this->webmailUrl = $webmailUrl;
    }
}
