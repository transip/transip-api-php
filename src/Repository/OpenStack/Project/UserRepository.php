<?php

namespace Transip\Api\Library\Repository\OpenStack\Project;

use Transip\Api\Library\Entity\OpenStackUser;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\OpenStack\ProjectRepository;

class UserRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'users';

    public const RESOURCE_PARAMETER_PLURAL   = 'users';

    protected function getRepositoryResourceNames(): array
    {
        return [ProjectRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $projectId
     * @return OpenStackUser[]
     */
    public function getByProjectId(string $projectId): array
    {
        $users      = [];
        $response   = $this->httpClient->get($this->getResourceUrl($projectId));
        $usersArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($usersArray as $userArray) {
            $users[] = new OpenStackUser($userArray);
        }

        return $users;
    }

    public function grantUserAccessToProject(string $projectId, string $userId): void
    {
        $url        = $this->getResourceUrl($projectId);
        $parameters = ['userId' => $userId];

        $this->httpClient->post($url, $parameters);
    }

    public function revokeUserAccessFromProject(string $projectId, string $userId): void
    {
        $this->httpClient->delete(
            $this->getResourceUrl($projectId, $userId)
        );
    }
}
