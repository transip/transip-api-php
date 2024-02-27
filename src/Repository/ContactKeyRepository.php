<?php

namespace Transip\Api\Library\Repository;

class ContactKeyRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'contact-key';

    public function get(): ?string
    {
        $response = $this->httpClient->get($this->getResourceUrl());
        $contactKey = $response['key'] ?? null;

        return $contactKey;
    }
}
