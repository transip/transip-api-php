<?php

namespace Transip\Api\Library\Repository\OpenStack;

use Transip\Api\Library\Entity\OpenStackUser;
use Transip\Api\Library\Repository\ApiRepository;

class UserRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'openstack/users';

    public const RESOURCE_PARAMETER_SINGUlAR = 'user';
    public const RESOURCE_PARAMETER_PLURAL   = 'users';

    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    /**
     * @return OpenStackUser[]
     */
    public function getAll(): array
    {
        $users      = [];
        $response   = $this->httpClient->get($this->getResourceUrl());
        $usersArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($usersArray as $userArray) {
            $users[] = new OpenStackUser($userArray);
        }

        return $users;
    }

    public function getByUserId(string $userId): OpenStackUser
    {
        $response  = $this->httpClient->get($this->getResourceUrl($userId));
        $userArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGUlAR);

        return new OpenStackUser($userArray);
    }

    public function create(
        string $username,
        string $description,
        string $email,
        string $password,
        string $projectId
    ): void {
        $parameters = [
            'username'    => $username,
            'description' => $description,
            'email'       => $email,
            'password'    => $password,
            'projectId'   => $projectId,
        ];

        $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    public function delete(string $userId): void
    {
        $this->httpClient->delete(
            $this->getResourceUrl($userId)
        );
    }

    public function updatePassword(string $userId, string $password): void
    {
        $parameters = [
            'newPassword' => $password
        ];

        $this->httpClient->patch(
            $this->getResourceUrl($userId),
            $parameters
        );
    }

    public function updateUser(OpenStackUser $openStackUser): void
    {
        $parameters = [
            'user' => $openStackUser
        ];

        $this->httpClient->put(
            $this->getResourceUrl($openStackUser->getId()),
            $parameters
        );
    }
}
