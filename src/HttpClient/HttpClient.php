<?php

namespace Transip\Api\Library\HttpClient;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Transip\Api\Library\Repository\AuthRepository;
use Transip\Api\Library\TransipAPI;

abstract class HttpClient implements HttpClientInterface
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

    /**
     * @var int
     */
    private $rateLimitLimit = -1;

    /**
     * @var int
     */
    private $rateLimitRemaining = -1;

    /**
     * @var int
     */
    private $rateLimitReset = -1;

    /**
     * @var string
     */
    private $chosenTokenExpiry = '1 day';

    public function __construct(string $endpoint)
    {
        $endpoint             = rtrim($endpoint, '/');
        $this->endpoint       = $endpoint;
        $this->authRepository = new AuthRepository($this);
    }

    public function setCache(AdapterInterface $cache): void
    {
        $this->cache = $cache;
    }

    public function checkAndRenewToken(): void
    {
        if ($this->authRepository->tokenHasExpired($this->token)) {
            // Create a new token
            $token = $this->authRepository->createToken(
                $this->login,
                $this->privateKey,
                $this->generateWhitelistOnlyTokens,
                $this->readOnlyMode,
                '',
                $this->getChosenTokenExpiry()
            );
            $this->setToken($token);

            $tokenExpiryTime = $this->authRepository->getExpirationTimeFromToken($this->token);
            $cacheExpiryTime = new \DateTime("@{$tokenExpiryTime}");

            // Save new token to cache
            $cacheItem = $this->cache->getItem(self::TOKEN_CACHE_KEY);
            $cacheItem->set($token);
            $cacheItem->expiresAt($cacheExpiryTime);
            $this->cache->save($cacheItem);

            // Save private key fingerprint to cache
            $cacheItem = $this->cache->getItem(self::KEY_FINGERPRINT_CACHE_KEY);
            $cacheItem->set($this->getFingerPrintFromKey($this->privateKey));
            $cacheItem->expiresAt($cacheExpiryTime);
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

    protected function parseResponseHeaders(ResponseInterface $response): void
    {
        $this->rateLimitLimit     = $response->getHeader("X-Rate-Limit-Limit")[0] ?? -1;
        $this->rateLimitRemaining = $response->getHeader("X-Rate-Limit-Remaining")[0] ?? -1;
        $this->rateLimitReset     = $response->getHeader("X-Rate-Limit-Reset")[0] ?? -1;
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

    public function getRateLimitLimit(): int
    {
        return $this->rateLimitLimit;
    }

    public function getRateLimitRemaining(): int
    {
        return $this->rateLimitRemaining;
    }

    public function getRateLimitReset(): int
    {
        return $this->rateLimitReset;
    }

    public function getChosenTokenExpiry(): string
    {
        return $this->chosenTokenExpiry;
    }

    public function setChosenTokenExpiry(string $chosenTokenExpiry): void
    {
        $this->chosenTokenExpiry = $chosenTokenExpiry;
    }

    abstract public function setToken(string $token): void;
    abstract public function get(string $url, array $query = []): array;
    abstract public function post(string $url, array $body = []): void;
    abstract public function postAuthentication(string $url, string $signature, array $body): array;
    abstract public function put(string $url, array $body): void;
    abstract public function patch(string $url, array $body): void;
    abstract public function delete(string $url, array $body = []): void;
}
