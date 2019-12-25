<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ChainOfResponsibility;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;

/**
 * Handler.
 *
 * Typically, CoR pattern defines a single interface (Handler) for objects
 * that make up the chain, in PSR-15 standard, however, we distinguish
 * RequestHandler and Middleware - they both consume Requests and can 
 * return Response, but Middleware is a way to move common request and response 
 * processing away from the application layer and can be reused and dynamically
 * reconfigured in different order or added/removed.
 */
class RequestHandler implements RequestHandlerInterface
{
    /**
     * @var MiddlewareInterface[]
     */
    private $middlewareStack;

    /**
     * @var RequestHandlerInterface fallback handler if/when middlewareStack gets
     * exhausted
     */
    private $fallbackHandler;

    public function __construct(array $middlewareStack = [], RequestHandlerInterface $fallbackHandler)
    {
        $this->middlewareStack = $middlewareStack;
        $this->fallbackHandler = $fallbackHandler;    
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (empty($this->middlewareStack)) {
            return $this->fallbackHandler->handle($request);
        } 

        $middleware = array_unshift($this->middlewareStack);
        return $middleware->process($request, $this);
    }
}
