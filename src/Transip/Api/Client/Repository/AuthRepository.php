<?php

namespace Transip\Api\Client\Repository;

use Exception;

class AuthRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'auth';

    /**
     * @var string expiryTime
     */
    protected $expiryTime;

    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    /**
     * @param string $customerLoginName           Account name used to login into TransIP CP
     * @param string $privateKey                  The generated private key from the control panel
     * @param bool   $generateWhitelistOnlyTokens Whether whitelisted IP address is needed to use the token generated in this function
     * @param string $label                       Label shown in the control panel, has to be unique
     * @param string $expirationTime              The maximum expiration time is one month
     * @param bool   $readOnly                    Whether the key can be used to change anything
     * @return string accessToken
     * @throws Exception
     */
    public function createToken(
        string $customerLoginName,
        string $privateKey,
        bool $generateWhitelistOnlyTokens = false,
        bool $readOnly = false,
        string $label = '',
        string $expirationTime = '1 day'
    ): ?string {

        $this->expiryTime = $expirationTime;
        if ($label == '') {
            $label = 'api.client-' . time();
        }

        $requestBody = [
            'login'           => $customerLoginName,
            'nonce'           => uniqid(),
            'read_only'       => $readOnly,
            'expiration_time' => $expirationTime,
            'label'           => $label,
            'global_key'      => !$generateWhitelistOnlyTokens,
        ];

        $signature = $this->createSignature($privateKey, $requestBody);
        $response  = $this->httpClient->postAuthentication($this->getResourceUrl(), $signature, $requestBody);
        $token     = $this->getParameterFromResponse($response, 'token');

        return $token;
    }

    public function getExpiryTime()
    {
        return strtotime($this->expiryTime, 0) - 2;
    }

    public function getExpirationTimeFromToken(string $token): int
    {
        if ($token == '') {
            return 0;
        }

        try {
            $data           = $data = explode('.', $token);
            $body           = json_decode(base64_decode($data[1]), true);
            $expirationTime = $body['exp'] ?? 0;
        } catch (Exception $exception) {
            $expirationTime = 0;
        }

        return intval($expirationTime);
    }

    private function createSignature(string $privateKey, array $parameters): string
    {
        // Fixup our private key, copy-pasting the key might lead to whitespace faults
        if (!preg_match(
            '/-----BEGIN (RSA )?PRIVATE KEY-----(.*)-----END (RSA )?PRIVATE KEY-----/si',
            $privateKey,
            $matches
        )
        ) {
            throw new Exception('Could not find a valid private key');
        }

        $key = $matches[2];
        $key = preg_replace('/\s*/s', '', $key);
        $key = chunk_split($key, 64, "\n");

        $key = "-----BEGIN PRIVATE KEY-----\n" . $key . "-----END PRIVATE KEY-----";

        if (!@openssl_sign(json_encode($parameters), $signature, $key,OPENSSL_ALGO_SHA512)) {
            throw new Exception(
                'Could not sign your request, please set a valid private key in the PRIVATE_KEY constant.'
            );
        }

        return base64_encode($signature);
    }
}
