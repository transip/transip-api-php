<?php

namespace Transip\Api\Library\Entity;

class OpenStackTotp extends AbstractEntity
{
    /**
     * Secret key
     *
     * @var string
     */
    protected $secretKey;

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

}
