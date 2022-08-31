<?php

namespace Transip\Api\Library\Repository\Domain;

use Transip\Api\Library\Entity\Domain\AdditionalContactFieldData;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\DomainRepository;

class AdditionalContactFieldDataRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'additionalContactFieldData';

    protected function getRepositoryResourceNames(): array
    {
        return [DomainRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function getByDomainName(string $domainName): array
    {
        $response = $this->httpClient->get($this->getResourceUrl($domainName));
        $fields   = $this->getParameterFromResponse($response, 'additionalContactFieldData');

        return array_map(static function ($field) {
            return new AdditionalContactFieldData($field['name'] ?? '', $field['value'] ?? '');
        }, $fields);
    }
}
