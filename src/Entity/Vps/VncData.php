<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class VncData extends AbstractEntity
{
    /**
     * @var string $host
     */
    protected $host;

    /**
     * @var string $path
     */
    protected $path;

    /**
     * @var string $url
     */
    protected $url;

    /**
     * @var string $token
     */
    protected $token;

    /**
     * @var string $password
     */
    protected $password;

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
