<?php

namespace RetwisReplica\App;

class Config
{
    private static $routes;

    public static function getRoutes() {
        if (!self::$routes) {
            self::$routes = yaml_parse_file(CONFIG_PATH . '/routes.yaml');
        }
        return self::$routes;
    }

    public static function getRoute($routeName)
    {
        $routes = self::getRoutes();
        return $routes[$routeName] ?? null;
    }
}