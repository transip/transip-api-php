<?php

namespace Transip\Api\Client\HttpClient;

use Symfony\Component\Cache\Adapter\AdapterInterface;
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

    /**
     * @var AdapterInterface
     */
    protected $cache;

    public function __construct(HttpClientInterface $httpClient, string $endpoint)
    {
        $endpoint             = rtrim($endpoint, '/');
        $this->endpoint       = $endpoint;
        $this->authRepository = new AuthRepository($httpClient);
    }

    public function setCache(AdapterInterface $cache)
    {
        $this->cache = $cache;
    }

    public function checkAndRenewToken(): void
    {
        $expirationTime = $this->authRepository->getExpirationTimeFromToken($this->token);
        if ($expirationTime <= (time() - 2)) {
            $token = $this->authRepository->createToken($this->login, $this->privateKey, $this->generateWhitelistOnlyTokens);
            $this->setToken($token);

            // Save new token to a temporary file
            $cacheItem = $this->cache->getItem(TransipAPI::TEMP_TOKEN_FILE_NAME);
            $cacheItem->set($token);
            $cacheItem->expiresAfter($this->authRepository->getExpiryTime());

            $this->cache->save($cacheItem);
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
