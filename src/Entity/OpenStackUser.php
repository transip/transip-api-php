<?php

namespace Transip\Api\Library\Entity;

class OpenStackUser extends AbstractEntity
{
    /**
     * @description Identifier
     * @example 6322872d9c7e445dbbb49c1f9ca28adc
     * @readonly
     * @type string
     * @var string
     */
    protected $id;

    /**
     * @description Login name
     * @example `hosting101-support`
     * @readonly
     * @type string
     */
    protected $username;

    /**
     * @description Description
     * @example `Supporter account`
     * @type string
     */
    protected $description;

    /**
     * @description Email address
     * @example `support@example.com`
     * @type string
     */
    protected $email;

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
