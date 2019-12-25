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
 * Defines default behavior for middlewares which is to delegate
 * the request handling to RequestHandler and return a Response from it.
 */
abstract class AbstractMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request);
    }
}
