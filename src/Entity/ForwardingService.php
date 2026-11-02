<?php

namespace Transip\Api\Library\Entity;

class ForwardingService extends AbstractEntity
{
    public const FORWARD_METHOD_IFRAME            = 'iframe';
    public const FORWARD_METHOD_LOCATION          = 'location';
    public const FORWARD_METHOD_MOVED_PERMANENTLY = 'movedPermanently';

    public const SSL_STATUS_PENDING  = 'pending';
    public const SSL_STATUS_ACTIVE   = 'active';
    public const SSL_STATUS_DISABLED = 'disabled';

    /**
     * @var string
     */
    protected $hostname;

    /**
     * @var bool
     */
    protected $isBlocked;

    /**
     * @var bool
     */
    protected $isLocked;

    /**
     * @var string
     */
    protected $forwardTo;

    /**
     * @var string
     */
    protected $forwardMethod;

    /**
     * @var string|null
     */
    protected $frameTitle;

    /**
     * @var string|null
     */
    protected $frameIcon;

    /**
     * @var bool
     */
    protected $forwardEverything;

    /**
     * @var bool
     */
    protected $forwardSubdomains;

    /**
     * @var string|null
     */
    protected $sslStatus;

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->isBlocked;
    }

    /**
     * @return bool true when another action is already running for this forwarding service
     */
    public function isLocked(): bool
    {
        return $this->isLocked;
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
     * @return string
     */
    public function getForwardMethod(): string
    {
        return $this->forwardMethod;
    }

    /**
     * @param string $forwardMethod one of the FORWARD_METHOD_* constants
     */
    public function setForwardMethod(string $forwardMethod): void
    {
        $this->forwardMethod = $forwardMethod;
    }

    /**
     * @return string|null
     */
    public function getFrameTitle(): ?string
    {
        return $this->frameTitle;
    }

    /**
     * @param string|null $frameTitle only used when the forward method is iframe
     */
    public function setFrameTitle(?string $frameTitle): void
    {
        $this->frameTitle = $frameTitle;
    }

    /**
     * @return string|null
     */
    public function getFrameIcon(): ?string
    {
        return $this->frameIcon;
    }

    /**
     * @param string|null $frameIcon only used when the forward method is iframe
     */
    public function setFrameIcon(?string $frameIcon): void
    {
        $this->frameIcon = $frameIcon;
    }

    /**
     * @return bool
     */
    public function isForwardEverything(): bool
    {
        return $this->forwardEverything;
    }

    /**
     * @param bool $forwardEverything
     */
    public function setForwardEverything(bool $forwardEverything): void
    {
        $this->forwardEverything = $forwardEverything;
    }

    /**
     * @return bool
     */
    public function isForwardSubdomains(): bool
    {
        return $this->forwardSubdomains;
    }

    /**
     * @param bool $forwardSubdomains
     */
    public function setForwardSubdomains(bool $forwardSubdomains): void
    {
        $this->forwardSubdomains = $forwardSubdomains;
    }

    /**
     * @return string|null one of the SSL_STATUS_* constants
     */
    public function getSslStatus(): ?string
    {
        return $this->sslStatus;
    }
}
