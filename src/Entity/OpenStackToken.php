<?php

namespace Transip\Api\Library\Entity;

class OpenStackToken extends AbstractEntity
{
    /**
     * @description Identifier
     * @example 6322872d9c7e445dbbb49c1f9ca28adc
     * @readonly
     * @type string
     * @var string
     */
    protected $tokenId;

    /**
     * User id
     *
     * @var string
     */
    protected $userId;

    /**
     * Project id
     *
     * @var string
     */
    protected $projectId;

    /**
     * Access key
     *
     * @var string
     */
    protected $accessKey;

    /**
     * Secret key
     *
     * @var string
     */
    protected $secretKey;

    /**
     * Management url
     *
     * @var string
     */
    protected $managementUrl;

    /**
     * @return mixed
     */
    public function getTokenId()
    {
        return $this->tokenId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getProjectId(): string
    {
        return $this->projectId;
    }

    /**
     * @return string
     */
    public function getAccessKey(): string
    {
        return $this->accessKey;
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * @return string
     */
    public function getManagementUrl(): string
    {
        return $this->managementUrl;
    }
}
