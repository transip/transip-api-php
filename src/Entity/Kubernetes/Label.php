<?php

namespace Transip\Api\Library\Entity\Kubernetes;

use Transip\Api\Library\Entity\AbstractEntity;

class Label extends AbstractEntity
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var bool
     */
    protected $modifiable;

    /**
     * @return  string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return  string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return  bool
     */
    public function getModifiable()
    {
        return $this->modifiable;
    }
}
