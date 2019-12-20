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
     * @param string $customerLoginName
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
        string $label = '',
        string $expirationTime = '1 day',
        bool $readOnly = false
    ): ?string {

        $this->expiryTime = $expirationTime;
        if ($label == '') {
            $label = "api.client-" . time();
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
        $token     = $response['token'] ?? null;

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

    /**
     * Method for creating a signature based on
     * Same sign method as used in SOAP API.
     *
     * @param string $privateKey
     * @param array  $parameters
     * @return string
     * @throws Exception
     */
    private function createSignature(string $privateKey, array $parameters): string
    {
        // Fixup our private key, copy-pasting the key might lead to whitespace faults
        if (!preg_match(
            '/-----BEGIN (RSA )?PRIVATE KEY-----(.*)-----END (RSA )?PRIVATE KEY-----/si',
            $privateKey,
            $matches
        )
        ) {
            throw new Exception($privateKey);
            throw new Exception('Could not find a valid private key');
        }

        $key = $matches[2];
        $key = preg_replace('/\s*/s', '', $key);
        $key = chunk_split($key, 64, "\n");

        $key = "-----BEGIN PRIVATE KEY-----\n" . $key . "-----END PRIVATE KEY-----";

        $digest = $this->sha512Asn1(json_encode($parameters));
        if (!@openssl_private_encrypt($digest, $signature, $key)) {
            throw new Exception(
                'Could not sign your request, please set a valid private key in the PRIVATE_KEY constant.'
            );
        }

        return base64_encode($signature);
    }

    /**
     * Creates a SHA512 ASN.1 header.
     *
     * @param $data
     * @return string
     */
    private function sha512Asn1($data)
    {
        $digest = hash('sha512', $data, true);

        // this ASN1 header is sha512 specific
        $asn1 = chr(0x30) . chr(0x51);
        $asn1 .= chr(0x30) . chr(0x0d);
        $asn1 .= chr(0x06) . chr(0x09);
        $asn1 .= chr(0x60) . chr(0x86) . chr(0x48) . chr(0x01) . chr(0x65);
        $asn1 .= chr(0x03) . chr(0x04);
        $asn1 .= chr(0x02) . chr(0x03);
        $asn1 .= chr(0x05) . chr(0x00);
        $asn1 .= chr(0x04) . chr(0x40);
        $asn1 .= $digest;

        return $asn1;
    }
}
