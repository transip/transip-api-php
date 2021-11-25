<?php

namespace Transip\Api\Library\Repository\OpenStack;

use Transip\Api\Library\Entity\OpenStackProject;
use Transip\Api\Library\Repository\ApiRepository;

class ProjectRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'openstack/projects';

    public const RESOURCE_PARAMETER_SINGUlAR = 'project';
    public const RESOURCE_PARAMETER_PLURAL   = 'projects';

    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    /**
     * @return OpenStackProject[]
     */
    public function getAll(): array
    {
        $projects      = [];
        $response      = $this->httpClient->get($this->getResourceUrl());
        $projectsArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($projectsArray as $projectArray) {
            $projects[] = new OpenStackProject($projectArray);
        }

        return $projects;
    }

    public function create(string $name, string $description): void
    {
        $parameters = [
            'name'        => $name,
            'description' => $description,
        ];

        $this->httpClient->post(
            $this->getResourceUrl(),
            $parameters
        );
    }

    public function getByProjectId(string $projectId): OpenStackProject
    {
        $response  = $this->httpClient->get($this->getResourceUrl($projectId));
        $projectArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGUlAR);

        return new OpenStackProject($projectArray);
    }

    public function updateProject(OpenStackProject $project): void
    {
        $parameters = [
            'project' => $project,
        ];

        $this->httpClient->put(
            $this->getResourceUrl($project->getId()),
            $parameters
        );
    }

    public function handover(string $projectID, string $targetCustomerName): void
    {
        $parameters = [
            'action'             => 'handover',
            'targetCustomerName' => $targetCustomerName,
        ];

        $this->httpClient->patch(
            $this->getResourceUrl($projectID),
            $parameters
        );
    }

    public function cancel(string $projectID): void
    {
        $this->httpClient->delete(
            $this->getResourceUrl($projectID)
        );
    }
}
