<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ChainOfResponsibility;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Concrete Middleware.
 */
class RouterMiddleware extends AbstractMiddleware
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->routeExists($request)) {
            return $this->dispatch($request);
        }
        return $handler->handle($request);
    }

    private function routeExists(ServerRequestInterface $request): bool
    {
        // check if route is set
    }

    private function dispatch(ServerRequestInterface $request): ResponseInterface 
    {
        // call the proper handler (controller) and return a response
    }
}
