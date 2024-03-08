<?php

namespace Transip\Api\Library\Repository;

use Exception;
use RuntimeException;

class AuthRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'auth';

    /**
     * @var string
     */
    protected $labelPrefix = 'api.lib-';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    public function createToken(
        string $customerLoginName,
        string $privateKey,
        bool $generateWhitelistOnlyTokens = false,
        bool $readOnly = false,
        string $label = '',
        string $expirationTime = '1 day'
    ): string {
        if ($label === '') {
            $label = $this->getLabelPrefix() . time();
        }

        $requestBody = [
            'login'           => $customerLoginName,
            'nonce'           => bin2hex(random_bytes(16)),
            'read_only'       => $readOnly,
            'expiration_time' => $expirationTime,
            'label'           => $label,
            'global_key'      => !$generateWhitelistOnlyTokens,
        ];

        $signature = $this->createSignature($privateKey, $requestBody);
        $response  = $this->httpClient->postAuthentication($this->getResourceUrl(), $signature, $requestBody);
        return (string) $this->getParameterFromResponse($response, 'token');
    }

    public function tokenHasExpired(string $token): bool
    {
        if ($token === '') {
            return true;
        }

        $expirationTime = $this->getExpirationTimeFromToken($token);
        $currentTime = time();

        $diff = $expirationTime - $currentTime;

        // if the token expires in 60 seconds, don't use it.
        // if $diff has a negative value then token has expired
        return ($diff < 60);
    }

    public function getExpirationTimeFromToken(string $token): int
    {
        if ($token === '') {
            return 0;
        }

        try {
            $data           = explode('.', $token);
            $payloadRaw     = $this->urlsafeB64Decode($data[1]);
            $body           = json_decode($payloadRaw, true, 512, JSON_THROW_ON_ERROR);
            $expirationTime = $body['exp'] ?? 0;
        } catch (Exception $exception) {
            $expirationTime = 0;
        }

        return intval($expirationTime);
    }

    private function urlsafeB64Decode(string $input): string
    {
        return \base64_decode(self::convertBase64UrlToBase64($input));
    }

    private function convertBase64UrlToBase64(string $input): string
    {
        $remainder = \strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= \str_repeat('=', $padlen);
        }
        return \strtr($input, '-_', '+/');
    }

    /**
     * @param string $privateKey
     * @param mixed[] $parameters
     * @return string
     */
    private function createSignature(string $privateKey, array $parameters): string
    {
        // Fixup our private key, copy-pasting the key might lead to whitespace faults
        if (!preg_match(
            '/-----BEGIN (RSA )?PRIVATE KEY-----(.*)-----END (RSA )?PRIVATE KEY-----/si',
            $privateKey,
            $matches
        )) {
            throw new RuntimeException('Could not find a valid private key');
        }

        $key = $matches[2];
        $key = preg_replace('/\s*/s', '', $key);
        if ($key === null) {
            throw new RuntimeException(
                'The provided private key is invalid'
            );
        }
        $key = chunk_split($key, 64, "\n");

        $key = "-----BEGIN PRIVATE KEY-----\n" . $key . "-----END PRIVATE KEY-----";

        if (!@openssl_sign((string)json_encode($parameters), $signature, $key, OPENSSL_ALGO_SHA512)) {
            throw new RuntimeException(
                'The provided private key is invalid'
            );
        }

        return base64_encode($signature);
    }

    public function getLabelPrefix(): string
    {
        return $this->labelPrefix;
    }

    public function setLabelPrefix(string $labelPrefix): void
    {
        $this->labelPrefix = $labelPrefix;
    }
}
