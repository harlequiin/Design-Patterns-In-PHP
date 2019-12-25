<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ChainOfResponsibility;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

/**
 * Handler.
 *
 * Defines default behavior for middlewares which is to delegate
 * the request handling to RequestHandler and return a Response from it.
 */
class NotFoundHandler extends RequestHandlerInterface
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->responseFactory->createResponse(404);
    }
}
