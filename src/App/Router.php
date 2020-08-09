<?php

namespace RetwisReplica\App;

use \Exception;
use FastRoute\{Dispatcher, RouteCollector};
use function FastRoute\simpleDispatcher;

class Router
{
    public function start()
    {
        $dispatcher = $this->getDispatcher();
        $routeInfo = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                App::throwError(404);
                echo 'not found';
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                App::throwError(403);
                $allowedMethods = $routeInfo[1];
                echo 'not allowed : ' . print_r($allowedMethods);
                break;
            case Dispatcher::FOUND:
                try {
                    $this->handleRoute($routeInfo);
                } catch (Exception $e) {
                    echo 'there is an error :' . $e->getMessage();
                }
                break;
        }
    }

    public function getDispatcher()
    {
        $routes = Config::getRoutes();

        $dispatcher = simpleDispatcher(function(RouteCollector $r) use ($routes) {
            foreach ($routes as $route) {
                $r->addRoute(
                    $route['method'],
                    $route['path'],
                    "\RetwisReplica\Controller\\${route['handler']}"
                );
            }
        });

        return $dispatcher;
    }

    public function handleRoute(array $routeInfo) {
        list(,$handler, $vars) = $routeInfo;

        $handler = explode('::', $handler);

        $controller = $handler[0];
        if (!isset($handler[1])) {
            throw new \RuntimeException('il manque la méthode');
        }

        $method = $handler[1];

        if (false === is_callable([$controller, $method])) {
            throw new \RuntimeException('method is not callable');
        }

        call_user_func_array([new $controller(), $method], $vars);
    }
}