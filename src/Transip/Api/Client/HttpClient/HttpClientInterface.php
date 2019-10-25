<?php

namespace Transip\Api\Client\HttpClient;

interface HttpClientInterface
{
    public function get(string $url): array;

    public function post(string $url, array $content): void;

    public function put(string $url, array $content): void;

    public function patch(string $url, array $content): void;

    public function delete(string $url, array $content): void;
}
