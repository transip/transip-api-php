<?php

namespace Transip\Api\Library\Repository\Email;

use Transip\Api\Library\Entity\Email\MailPackage;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\EmailRepository;

class MailPackageRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return [EmailRepository::RESOURCE_NAME];
    }

    /**
     * @return MailPackage[]
     */
    public function get(): array
    {
        $response = $this->httpClient->get($this->getResourceUrl());
        $packagesArray = $this->getParameterFromResponse($response, 'packages');

        return \array_map(static function (array $packageArray) {
            return new MailPackage($packageArray);
        }, $packagesArray);
    }
}
