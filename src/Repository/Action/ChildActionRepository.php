<?php

namespace Transip\Api\Library\Repository\Action;

use Transip\Api\Library\Entity\Action;
use Transip\Api\Library\Repository\ApiRepository;

class ChildActionRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'children';
    public const RESOURCE_PARAMETER_PLURAL = 'actions';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    /**
     * @return Action[]
     */
    public function getByParentUuid(string $parentActionUuid): array
    {
        $actions      = [];
        $response     = $this->httpClient->get($this->getResourceUrl($parentActionUuid));
        $actions = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($actions as $action) {
            $actions[] = new Action($action);
        }

        return $actions;
    }
}
