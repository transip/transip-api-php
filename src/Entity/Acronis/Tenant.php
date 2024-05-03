<?php

namespace Transip\Api\Library\Entity\Acronis;

use Transip\Api\Library\Entity\AbstractEntity;

class Tenant extends AbstractEntity
{
    /**
     * @var string $uuid
     */
    protected $uuid;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * Get $uuid
     *
     * @return  string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get $name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get $description
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription(string $description): Tenant
    {
        $this->description = $description;
        return $this;
    }
}
