<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ChainOfResponsibility;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

/**
 * Concrete Middleware.
 */
class AuthorizationMiddleware extends AbstractMiddleware
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        if (!$this->isAuthorized($request)) {
            return $this->responseFactory->createResponse(403);
        }
        return $handler->handle($request);
    }

    private function isAuthorized(ServerRequestInterface $request)
    {
        // process if can be authorized
    }
}
