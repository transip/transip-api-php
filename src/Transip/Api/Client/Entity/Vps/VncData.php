<?php

namespace Transip\Api\Client\Entity\Vps;

use Transip\Api\Client\Entity\AbstractEntity;

class VncData extends AbstractEntity
{
    /**
     * @var string $host
     */
    public $host;

    /**
     * @var string $path
     */
    public $path;

    /**
     * @var string $url
     */
    public $url;

    /**
     * @var string $token
     */
    public $token;

    /**
     * @var string $password
     */
    public $password;

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
