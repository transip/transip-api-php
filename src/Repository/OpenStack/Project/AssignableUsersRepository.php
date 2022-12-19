<?php

namespace Transip\Api\Library\Repository\OpenStack\Project;

use Transip\Api\Library\Entity\OpenStackUser;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\OpenStack\ProjectRepository;

class AssignableUsersRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'assignable-users';

    public const RESOURCE_PARAMETER_PLURAL   = 'assignableUsers';

    /**
     * @return string[]
     */
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
}
