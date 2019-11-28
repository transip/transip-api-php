<?php

namespace Transip\Api\Client\Entity\Vps;

use Transip\Api\Client\Entity\AbstractEntity;

abstract class UsageData extends AbstractEntity
{
    /**
     * @var int $date
     */
    public $date;

    public function getDate(): int
    {
        return $this->date;
    }
}
