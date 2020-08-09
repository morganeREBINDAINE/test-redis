<?php

namespace RetwisReplica\App;

use \Exception;

class Router
{
    public static function start()
    {
        $dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/home', "\RetwisReplica\Controller\HomeController::home");
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                echo 'not found';
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                $handler = explode('::', $handler);

                $controller = $handler[0];
                if (!isset($handler[1])) {
                    throw new Exception('il manque la méthode');
                }

                $method = $handler[1];

                if (false === is_callable([$controller, $method])) {
                    throw new Exception('method is not callable');
                }

                call_user_func_array([new $controller(), $method], $vars);
                break;
        }
    }
}