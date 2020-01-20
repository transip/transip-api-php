<?php

namespace Transip\Api\Library\HttpClient;

interface HttpClientInterface
{
    public function setToken(string $token): void;

    public function get(string $url, array $query = []): array;

    public function post(string $url, array $body = []): void;

    public function postAuthentication(string $url, string $signature, array $body): array;

    public function put(string $url, array $body): void;

    public function patch(string $url, array $body): void;

    public function delete(string $url, array $body = []): void;
}
