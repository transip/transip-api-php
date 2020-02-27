<?php

namespace Transip\Api\Library\Entity;

use JsonSerializable;

class AbstractEntity implements JsonSerializable
{
    public function __construct(array $valueArray = [])
    {
        foreach ($valueArray as $field => $value) {
            if (property_exists($this, $field)) {
                $this->$field = $value;
            }
        }
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
