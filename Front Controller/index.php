<?php
declare(strict_types=1);
require_once vendor/autoload.php;

use harlequiin\Patterns\FrontController\FrontController;

$container = null; // any kind of PSR-11 compatible dependency injection container
$view = null; // any kind of view class
$router = null; // any kind of PSR-15 router middleware
$authentication = null; // any kind of PSR-15 authentication middleware
$fallbackHandler = null; // any kind of PSR-15 request handler for failed requests

$frontController = new FrontController($container, [$authentication, $router], $fallbackHandler);
$frontController->run();
