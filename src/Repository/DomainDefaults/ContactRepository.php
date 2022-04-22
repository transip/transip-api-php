<?php

namespace Transip\Api\Library\Repository\DomainDefaults;

use Transip\Api\Library\Entity\Domain\WhoisContact;
use Transip\Api\Library\Repository\ApiRepository;

class ContactRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'domain-defaults/contacts';

    /**
     * @return WhoisContact[]
     */
    public function getAll(): array
    {
        $contacts      = [];
        $response      = $this->httpClient->get($this->getResourceUrl());
        $contactsArray = $this->getParameterFromResponse($response, 'contacts');

        foreach ($contactsArray as $contactArray) {
            $contacts[] = new WhoisContact($contactArray);
        }

        return $contacts;
    }

    /**
     * @param WhoisContact[] $contacts
     */
    public function update(array $contacts): void
    {
        $this->httpClient->put($this->getResourceUrl(), ['contacts' => $contacts]);
    }
}
