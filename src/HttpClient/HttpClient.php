<?php

namespace Transip\Api\Library\HttpClient;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Transip\Api\Library\Repository\AuthRepository;
use Transip\Api\Library\TransipAPI;

abstract class HttpClient
{
    public const TOKEN_CACHE_KEY = 'token';
    public const KEY_FINGERPRINT_CACHE_KEY = 'key-fingerprint';
    public const USER_AGENT = 'TransIP ApiClient';

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

    /**
     * @var bool
     */
    protected $readOnlyMode = false;

    /**
     * @var bool
     */
    protected $testMode = false;

    public function __construct(HttpClientInterface $httpClient, string $endpoint)
    {
        $endpoint             = rtrim($endpoint, '/');
        $this->endpoint       = $endpoint;
        $this->authRepository = new AuthRepository($httpClient);
    }

    public function setCache(AdapterInterface $cache): void
    {
        $this->cache = $cache;
    }

    public function checkAndRenewToken(): void
    {
        $expirationTime = $this->authRepository->getExpirationTimeFromToken($this->token);
        if ($expirationTime <= (time() - 2)) {
            $token = $this->authRepository->createToken(
                $this->login,
                $this->privateKey,
                $this->generateWhitelistOnlyTokens,
                $this->readOnlyMode
            );
            $this->setToken($token);

            // Save new token to cache
            $cacheItem = $this->cache->getItem(self::TOKEN_CACHE_KEY);
            $cacheItem->set($token);
            $cacheItem->expiresAfter($this->authRepository->getExpiryTime());
            $this->cache->save($cacheItem);
            // Save private key fingerprint to cache
            $cacheItem = $this->cache->getItem(self::KEY_FINGERPRINT_CACHE_KEY);
            $cacheItem->set($this->getFingerPrintFromKey($this->privateKey));
            $cacheItem->expiresAfter($this->authRepository->getExpiryTime());
            $this->cache->save($cacheItem);
        }
    }

    public function getTokenFromCache(): void
    {
        $cachedToken = $this->cache->getItem(self::TOKEN_CACHE_KEY);
        $cachedKeyFP = $this->cache->getItem(self::KEY_FINGERPRINT_CACHE_KEY);

        if ($cachedToken->isHit() && $cachedKeyFP->isHit()) {
            $storedKeyFP = $cachedKeyFP->get();
            $storedToken = $cachedToken->get();

            // check if the used private key is still the same, else invalidate the cache
            if ($this->getFingerPrintFromKey($this->privateKey) === $storedKeyFP) {
                $this->setToken($storedToken);
            } else {
                $this->clearCache();
            }
        }
    }

    private function getFingerPrintFromKey(string $privateKey): string
    {
        return hash('SHA512', $privateKey);
    }

    public function clearCache(): void
    {
        $this->cache->deleteItem(self::TOKEN_CACHE_KEY);
        $this->cache->deleteItem(self::KEY_FINGERPRINT_CACHE_KEY);
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function setPrivateKey(string $privateKey): void
    {
        $this->privateKey = $privateKey;
    }

    public function getGenerateWhitelistOnlyTokens(): bool
    {
        return $this->generateWhitelistOnlyTokens;
    }

    public function setGenerateWhitelistOnlyTokens(bool $generateWhitelistOnlyTokens): void
    {
        $this->generateWhitelistOnlyTokens = $generateWhitelistOnlyTokens;
    }

    public function getUserAgent(): string
    {
        return self::USER_AGENT . " v" . TransipAPI::TRANSIP_API_LIBRARY_VERSION;
    }

    public function setReadOnlyMode(bool $mode): void
    {
        $this->readOnlyMode = $mode;
    }

    public function getReadOnlyMode(): bool
    {
        return $this->readOnlyMode;
    }

    /**
     * Set the prefix for the label that is used to create the token, this will show up in the Transip ControlPanel
     * by default this is 'api.lib-'
     *
     * @param string $labelPrefix
     */
    public function setTokenLabelPrefix(string $labelPrefix): void
    {
        $this->authRepository->setLabelPrefix($labelPrefix);
    }

    public function getTestMode(): bool
    {
        return $this->testMode;
    }

    public function setTestMode(bool $testMode): void
    {
        $this->testMode = $testMode;
    }
}
