<?php

namespace Transip\Api\Library\Entity\Kubernetes;

use Transip\Api\Library\Entity\AbstractEntity;

class Release extends AbstractEntity
{
    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $releaseDate;

    /**
     * @var string
     */
    protected $maintenanceModeDate;

    /**
     * @var string
     */
    protected $endOfLifeDate;

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    public function getMaintenanceModeDate(): string
    {
        return $this->maintenanceModeDate;
    }

    public function getEndOfLifeDate(): string
    {
        return $this->endOfLifeDate;
    }
}
