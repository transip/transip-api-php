<?php

namespace Transip\Api\Library\Entity\Acronis;

use Transip\Api\Library\Entity\AbstractEntity;

class Usage extends AbstractEntity
{
    /**
     * @var string $currentUsage
     */
    protected $currentUsage;

    /**
     * @var string $limit
     */
    protected $limit;

    /**
     * Get $uuid
     *
     * @return  string
     */
    public function getCurrentUsage()
    {
        return $this->currentUsage;
    }

    /**
     * Get $limit
     *
     * @return  string
     */
    public function getLimit()
    {
        return $this->limit;
    }
}
