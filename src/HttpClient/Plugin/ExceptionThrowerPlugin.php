<?php

declare(strict_types=1);

namespace Transip\Api\Library\HttpClient\Plugin;

use Exception;
use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Transip\Api\Library\Exception\HttpBadResponseException;
use Transip\Api\Library\HttpClient\Message\ResponseMediator;

/**
 * Throws Exception when an error occurs
 */
final class ExceptionThrowerPlugin implements Plugin
{
    use Plugin\VersionBridgePlugin;

    /**
     * @return callable
     */
    public function doHandleRequest(RequestInterface $request, callable $next, callable $first)
    {
        return $next($request)->then(function (ResponseInterface $response) {
            if ($response->getStatusCode() < 400 || $response->getStatusCode() > 600) {
                return $response;
            }

            /**
             * Currently this should mimic behaviour of Guzzle, this throws an badResponseException when an HTTP
             * error occurs (4xx or 5xx). As this does not happen in the PSR client libraries, we can just create an
             * internal Exception at this place. The Exception factory can later be moved here.
             */
            throw HttpBadResponseException::badResponseException(
                // Add a stub exception here, this is not used and can be removed in a new major release
                new RuntimeException('An error response was returned'),
                $response
            );
        });
    }
}
