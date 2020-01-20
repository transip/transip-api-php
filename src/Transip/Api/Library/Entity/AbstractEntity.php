<?php

namespace Transip\Api\Library\Entity;

class AbstractEntity
{
    public function __construct(array $valueArray = [])
    {
        foreach ($valueArray as $field => $value) {
            if (property_exists($this, $field)) {
                $this->$field = $value;
            }
        }
    }
}
