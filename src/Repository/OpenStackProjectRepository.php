<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\OpenStackProject;

class OpenStackProjectRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'openstack-projects';

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
        $projectsArray = $this->getParameterFromResponse($response, 'projects');

        foreach ($projectsArray as $projectArray) {
            $projects[] = new OpenStackProject($projectArray);
        }

        return $projects;
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return OpenStackProject[]
     */
    public function getSelection(int $page, int $itemsPerPage): array
    {
        $projects      = [];
        $query         = ['pageSize' => $itemsPerPage, 'page' => $page];
        $response      = $this->httpClient->get($this->getResourceUrl(), $query);
        $projectsArray = $this->getParameterFromResponse($response, 'projects');

        foreach ($projectsArray as $projectArray) {
            $projects[] = new OpenStackProject($projectArray);
        }

        return $projects;
    }

    public function getByProjectId(string $projectId): OpenStackProject
    {
        $response  = $this->httpClient->get($this->getResourceUrl($projectId));
        $userArray = $this->getParameterFromResponse($response, 'project');

        return new OpenStackProject($userArray);
    }

    public function updateProject(string $projectID, OpenStackProject $project): void
    {
        $parameters = [
            'project' => $project,
        ];

        $this->httpClient->patch(
            $this->getResourceUrl($projectID),
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
