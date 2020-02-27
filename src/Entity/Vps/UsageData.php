<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

abstract class UsageData extends AbstractEntity
{
    /**
     * @var int $date
     */
    protected $date;

    public function getDate(): int
    {
        return $this->date;
    }
}
