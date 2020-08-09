<?php

namespace RetwisReplica\App;

use Twig\Environment;
use Twig\Error\RuntimeError;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class Twig
{
    public function getTwig()
    {
        $loader = new FilesystemLoader(ROOT_PATH . '/templates');
        $twig = new Environment($loader);
        $twig->addFunction(new TwigFunction('path', [$this, 'getPath']));
        return $twig;
    }

    public function getPath(string $routeName)
    {
        $route = Config::getRoute($routeName);

        if (!$route) {
            throw new RuntimeError('La route existe pas');
        }

        return $route['path'];
    }
}