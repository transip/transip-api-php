<?php

namespace Transip\Api\Client\HttpClient;

use Transip\Api\Client\FilesystemAdapter;
use Transip\Api\Client\Repository\AuthRepository;
use Transip\Api\Client\TransipAPI;

abstract class HttpClient
{
    /**
     * @var AuthRepository $authRepository
     */
    protected $authRepository;

    /**
     * @var string $endpoint
     */
    protected $endpoint;

    /**
     * @var string $token
     */
    protected $token = '';

    /**
     * @var string $login
     */
    protected $login = '';

    /**
     * @var string $privateKey
     */
    protected $privateKey = '';

    /**
     * @var bool $generateWhitelistOnlyTokens
     */
    protected $generateWhitelistOnlyTokens = false;

    public function __construct(HttpClientInterface $httpClient, string $endpoint)
    {
        $endpoint             = rtrim($endpoint, '/');
        $this->endpoint       = $endpoint;
        $this->authRepository = new AuthRepository($httpClient);
    }

    public function checkAndRenewToken(): void
    {
        $expirationTime = $this->authRepository->getExpirationTimeFromToken($this->token);
        if ($expirationTime <= (time() - 2)) {
            $token = $this->authRepository->createToken($this->login, $this->privateKey, $this->generateWhitelistOnlyTokens);
            $this->setToken($token);

            // Save new token to a temporary file
            $filesystem = new FilesystemAdapter();
            $filesystem->saveTempFile(TransipApi::TEMP_TOKEN_FILE_NAME, $token);
        }
    }

    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function setPrivateKey(string $privateKey): void
    {
        $this->privateKey = $privateKey;
    }

    public function setGenerateWhitelistOnlyTokens(bool $generateWhitelistOnlyTokens): void
    {
        $this->generateWhitelistOnlyTokens = $generateWhitelistOnlyTokens;
    }
}
