<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\OpenStackUser;

class OpenStackUserRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'openstack-users';

    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    /**
     * @return OpenStackUser[]
     */
    public function getAll(): array
    {
        $projects      = [];
        $response      = $this->httpClient->get($this->getResourceUrl());
        $projectsArray = $this->getParameterFromResponse($response, 'users');

        foreach ($projectsArray as $projectArray) {
            $projects[] = new OpenStackUser($projectArray);
        }

        return $projects;
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return OpenStackUser[]
     */
    public function getSelection(int $page, int $itemsPerPage): array
    {
        $users      = [];
        $query      = ['pageSize' => $itemsPerPage, 'page' => $page];
        $response   = $this->httpClient->get($this->getResourceUrl(), $query);
        $usersArray = $this->getParameterFromResponse($response, 'users');

        foreach ($usersArray as $userArray) {
            $users[] = new OpenStackUser($userArray);
        }

        return $users;
    }

    public function getByUserId(string $userId): OpenStackUser
    {
        $response  = $this->httpClient->get($this->getResourceUrl($userId));
        $userArray = $this->getParameterFromResponse($response, 'user');

        return new OpenStackUser($userArray);
    }
}
