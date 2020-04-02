<?php

use Dailymotion\Infrastructure\Controller\PlaylistController;
use Dailymotion\Infrastructure\Controller\VideoController;
use Dailymotion\Infrastructure\Dic\Container;
use Dailymotion\Infrastructure\Routing\Router;

require __DIR__.'/../vendor/autoload.php';

$container = Container::createContainer();

$request = Dailymotion\Infrastructure\Http\Request::createRequest();

$router = new Router(
    $container[VideoController::class],
    $container[PlaylistController::class],
);

$response = $router->handle($request);

header(sprintf('HTTP/1.1 %s %s', $response->getStatusCode(), $response->getStatusText()));
header('Content-Type: application/json');
echo $response->getResponseBody();
