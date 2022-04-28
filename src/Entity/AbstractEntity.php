<?php

namespace Transip\Api\Library\Entity;

class AbstractEntity implements \JsonSerializable
{
    /**
     * @param mixed[] $valueArray
     */
    public function __construct(array $valueArray = [])
    {
        foreach ($valueArray as $field => $value) {
            if (property_exists($this, $field)) {
                $this->$field = $value;
            }
        }
    }

    /**
     * This method returns data that can be serialized by json_encode()
     * natively.
     *
     * @return mixed
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
