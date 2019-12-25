<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ChainOfResponsibility;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Concrete Middleware.
 */
class CacheMiddleware extends AbstractMiddleware
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->isCached($request)) {
            $this->cache($request);
        }
        return $handler->handle($request);
    }

    private function isCached(ServerRequestInterface $request)
    {
        // determine if in cache
    }

    private function cache(ServerRequestInterface $request)
    {
        // cache the request object info
    }
}
