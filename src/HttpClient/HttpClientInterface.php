<?php

namespace Transip\Api\Library\HttpClient;

interface HttpClientInterface
{
    public function setToken(string $token): void;

    /**
     * @param string $url
     * @param mixed[]  $query
     * @return mixed[]
     */
    public function get(string $url, array $query = []): array;

    /**
     * @param string $url
     * @param mixed[] $body
     * @return void
     */
    public function post(string $url, array $body = []): void;

    /**
     * @param string $url
     * @param mixed[] $body
     * @return mixed[]
     */
    public function postWithResponse(string $url, array $body = []): array;

    /**
     * @param string $url
     * @param string $signature
     * @param mixed[] $body
     * @return mixed[]
     */
    public function postAuthentication(string $url, string $signature, array $body): array;

    /**
     * @param string $url
     * @param mixed[] $body
     * @return void
     */
    public function put(string $url, array $body): void;

    /**
     * @param string $url
     * @param mixed[] $body
     * @return void
     */
    public function patch(string $url, array $body): void;

    /**
     * @param string $url
     * @param mixed[] $body
     * @return void
     */
    public function delete(string $url, array $body = []): void;

    public function clearCache(): void;

    public function getEndpoint(): string;

    public function setEndpoint(string $endpoint): void;

    public function getLogin(): string;

    public function setLogin(string $login): void;

    public function setPrivateKey(string $privateKey): void;

    public function getGenerateWhitelistOnlyTokens(): bool;

    public function setGenerateWhitelistOnlyTokens(bool $generateWhitelistOnlyTokens): void;

    public function getUserAgent(): string;

    public function setReadOnlyMode(bool $mode): void;

    public function getReadOnlyMode(): bool;

    public function setTokenLabelPrefix(string $labelPrefix): void;

    public function getTestMode(): bool;

    public function setTestMode(bool $testMode): void;

    public function getRateLimitLimit(): int;

    public function getRateLimitRemaining(): int;

    public function getRateLimitReset(): int;

    public function getChosenTokenExpiry(): string;

    public function setChosenTokenExpiry(string $chosenTokenExpiry): void;
}
