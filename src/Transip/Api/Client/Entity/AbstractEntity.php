<?php

namespace Transip\Api\Client\Entity;

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
