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
     * Login name
     *
     * @var string
     */
    protected $username;

    /**
     * Description
     *
     * @var string
     */
    protected $description;

    /**
     * Email address
     *
     * @var string
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
