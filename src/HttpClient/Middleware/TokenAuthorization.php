<?php
declare(strict_types=1);

namespace Transip\Api\Library\HttpClient\Middleware;

use Closure;
use Psr\Http\Message\RequestInterface;

class TokenAuthorization
{
    public const HANDLER_NAME = 'transip_token_authentication';

    private $token;
    private $userAgent;

    public function __construct(
        string $token,
        string $userAgent
    ) {
        $this->token = $token;
        $this->userAgent = $userAgent;
    }

    public function __invoke(callable $handler): Closure
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            return $handler(
                $request->withAddedHeader('Authorization', sprintf('Bearer %s', $this->token))
                    ->withAddedHeader('User-Agent', $this->userAgent),
                $options
            );
        };
    }
}
