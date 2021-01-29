<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class Licenses extends AbstractEntity
{
    /** @var License[] */
    protected $active = [];

    /** @var License[] */
    protected $cancellable = [];

    /** @var LicenseProduct[] */
    protected $available = [];

    /**
     * @return License[]
     */
    public function getActive(): array
    {
        return $this->active;
    }

    /**
     * @return License[]
     */
    public function getCancellable(): array
    {
        return $this->cancellable;
    }

    /**
     * @return LicenseProduct[]
     */
    public function getAvailable(): array
    {
        return $this->available;
    }
}
