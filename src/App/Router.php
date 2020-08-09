<?php

namespace RetwisReplica\App;

use \Exception;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router
{
    public function start()
    {
        $dispatcher = $this->getDispatcher();
        $routeInfo = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                echo 'not found';
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                break;
            case \FastRoute\Dispatcher::FOUND:
                try {
                    $this->handleRoute($routeInfo);
                } catch (Exception $e) {
                    echo 'there is an error :' . $e->getMessage();
                }
                break;
        }
    }

    public function getRoutes()
    {
        return yaml_parse_file(CONFIG_PATH . '/routes.yaml');
    }

    public function getDispatcher()
    {
        $routes = $this->getRoutes();

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
            throw new Exception('il manque la méthode');
        }

        $method = $handler[1];

        if (false === is_callable([$controller, $method])) {
            throw new Exception('method is not callable');
        }

        call_user_func_array([new $controller(), $method], $vars);
    }
}