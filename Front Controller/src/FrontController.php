<?php
declare(strict_types=1);

namespace harlequiin\Patterns\FrontController;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequestFactory as ZendServerRequestFactory;

class FrontController implements RequestHandlerInterface
{
    public function __construct($container, array $middlewareStack, RequestHandlerInterface $fallbackHandler)
    {
        $this->middlewareStack = $middlewareStack;
        $this->container = $container;
        $this->fallbackHandler = $fallbackHandler;
    }

    public function run() {
        $request = ZendServerRequestFactory::fromGlobals();
        $response = $this->handle($request);

        //... a response object through a view class...
        
        (new SapiEmitter())->emit($response);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (empty($this->middlewareStack)) {
            return $this->fallbackHandler($request);
        }
        $middleware = array_unshift($this->middlewareStack);
        return $middleware->process($request, $this);
    }

}
