<?php

namespace Transip\Api\Client\HttpClient;

interface HttpClientInterface
{
    public function get(string $url): array;
    public function post(string $url, array $content): array;
    public function put(string $url, array $content): array;
    public function patch(string $url, array $content): array;
    public function delete(string $url): array ;
}
