<?php

namespace Transip\Api\Library\Repository\Vps;

use Transip\Api\Library\Entity\Vps\Contact;
use Transip\Api\Library\Repository\ApiRepository;

class MonitoringContactRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'monitoring-contacts';

    /**
     * @return Contact[]
     */
    public function getAll(): array
    {
        $response      = $this->httpClient->get($this->getResourceUrl());
        $contactsArray = $this->getParameterFromResponse($response, 'contacts');

        $contacts = [];
        foreach ($contactsArray as $contact) {
            $contacts[] = new Contact($contact);
        }

        return $contacts;
    }

    public function create(string $name, string $telephone, string $email): void
    {
        $params = [
            'name'      => $name,
            'telephone' => $telephone,
            'email'     => $email,
        ];

        $this->httpClient->post($this->getResourceUrl(), $params);
    }

    public function update(Contact $contact): void
    {
        $this->httpClient->put($this->getResourceUrl($contact->getId()), ['contact' => $contact]);
    }

    public function delete(int $contactId): void
    {
        $this->httpClient->delete($this->getResourceUrl($contactId), []);
    }
}
