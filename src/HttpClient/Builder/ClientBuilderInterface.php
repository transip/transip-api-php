<?php

declare(strict_types=1);

namespace Transip\Api\Library\HttpClient\Builder;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;

/**
 * @internal
 */
interface ClientBuilderInterface
{
    public function getHttpClient(): HttpMethodsClient;

    /**
     * Add a new plugin to the end of the plugin chain.
     */
    public function addPlugin(Plugin $plugin): void;

    /**
     * Remove a plugin by its fully qualified class name (FQCN).
     */
    public function removePlugin(string $fqcn): void;

    /**
     * Clears used headers.
     */
    public function clearHeaders(): void;

    /**
     * @param array<string, string> $headers
     */
    public function addHeaders(array $headers): void;

    public function addHeaderValue(string $header, string $headerValue): void;
}
