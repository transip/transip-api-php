<?php

namespace Transip\Api\Library\Repository\OpenStack;

use Transip\Api\Library\Entity\OpenStackProject;
use Transip\Api\Library\Entity\OpenStackToken;
use Transip\Api\Library\Entity\OpenStackUser;
use Transip\Api\Library\Repository\ApiRepository;

class TokenRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'tokens';

    public const RESOURCE_PARAMETER_SINGULAR = 'token';
    public const RESOURCE_PARAMETER_PLURAL   = 'tokens';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [UserRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $userId
     * @return OpenStackToken[]
     */
    public function getAllByUserId(string $userId): array
    {
        $tokens      = [];
        $response   = $this->httpClient->get($this->getResourceUrl($userId));
        $tokenArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($tokenArray as $token) {
            $tokens[] = new OpenStackToken($token);
        }

        return $tokens;
    }

    /**
     * @param string $userId
     * @param string $projectId
     * @return OpenStackToken[]
     */
    public function getAllByUserIdAndProjectId(string $userId, string $projectId): array
    {
        $tokens      = [];
        $response   = $this->httpClient->get(sprintf('%s?projectId=%s', $this->getResourceUrl($userId), $projectId));
        $tokenArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($tokenArray as $token) {
            $tokens[] = new OpenStackToken($token);
        }

        return $tokens;
    }

    public function getByTokenId(string $userId, string $tokenId): OpenStackToken
    {
        $response  = $this->httpClient->get($this->getResourceUrl($userId, $tokenId));
        $token = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR);

        return new OpenStackToken($token);
    }

    public function create(string $userId, string $projectId): void
    {
        $parameters = [
            "projectId" => $projectId
        ];

        $this->httpClient->post(
            $this->getResourceUrl($userId),
            $parameters
        );
    }

    public function delete(string $userId, string $tokenId): void
    {
        $this->httpClient->delete(
            $this->getResourceUrl($userId, $tokenId)
        );
    }
}
