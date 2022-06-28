<?php

declare(strict_types=1);

namespace Transip\Api\Library\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;

use function sprintf;

final class TokenAuthenticationPlugin implements Plugin
{
    use Plugin\VersionBridgePlugin;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $userAgent;

    public function __construct(
        string $token,
        string $userAgent = 'transip-api'
    ) {
        $this->token = $token;
        $this->userAgent = $userAgent;
    }

    /**
     * @return callable
     */
    public function doHandleRequest(RequestInterface $request, callable $next, callable $first)
    {
        $request = $request->withHeader('Authorization', sprintf('Bearer %s', $this->token))
            ->withHeader('User-Agent', $this->userAgent);

        return $next($request);
    }
}
