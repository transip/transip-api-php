<?php

namespace Transip\Api\Library\Repository\Action;

use Psr\Http\Message\ResponseInterface;
use Transip\Api\Library\Entity\Action;
use Transip\Api\Library\Repository\ApiRepository;

class ActionRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'actions';
    public const RESOURCE_PARAMETER_SINGULAR = 'action';
    public const RESOURCE_PARAMETER_PLURAL = 'actions';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    public function parseActionFromResponse(ResponseInterface $response): ?Action
    {
        $actionUsage = 0;
        if ($response->getHeader('Content-Location')) {
            $actionUuid = str_replace("/v6/actions/", "", $response->getHeaderLine('Content-Location'), $actionUsage);
            if ($actionUsage > 0) {
                return $this->getByUuid($actionUuid);
            }
        }
        return null;
    }

    /**
     * @return Action
     */
    public function getByUuid(string $actionUuid): Action
    {
        $response = $this->httpClient->get($this->getResourceUrl($actionUuid));
        $action   = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR);

        return new Action($action);
    }

    /**
     * @return Action[]
     */
    public function getAll(): array
    {
        $actions      = [];
        $response      = $this->httpClient->get($this->getResourceUrl());
        $actions = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($actions as $action) {
            $actions[] = new Action($action);
        }

        return $actions;
    }

    /**
     * @return Action[]
     */
    public function getByResourceIdentifier(string $resourceIdentifier, string $resourceType): array
    {
        $actions       = [];

        $query         = ['resourceIdentifier' => $resourceIdentifier, 'resourceType' => $resourceType];
        $response      = $this->httpClient->get($this->getResourceUrl(), $query);
        $result        = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($result as $action) {
            $actions[] = new Action($action);
        }

        return $actions;
    }
}
