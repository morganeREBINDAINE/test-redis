<?php

namespace RetwisReplica\Controller;

use Exception;
use RetwisReplica\App\{App, Config, Twig};
use RetwisReplica\Services\Authenticator;

abstract class Controller
{
    public $twig;
    public $authenticator;

    public function __construct()
    {
        $this->twig = (new Twig())->getTwig();
        $this->authenticator = new Authenticator();
    }

    protected function render(string $template, array $vars = []) {
        try {
            echo $this->twig->render("$template.html.twig", $vars);
            return true;
        } catch (Exception $exception) {
            App::throwError(400);
            // @todo display error page with generic message, log stack trace
            $this->render('errors/400', [
                'errorMessage' => $exception->getMessage() . '<br>' . $exception->getTraceAsString()
            ]);
        }
    }

    protected function forbid() {
        App::throwError(400);
        $this->render('errors/400', [
            'errorMessage' => 'Vous ne pouvez accéder a cette page',
        ]);
        exit;
    }

    protected function redirect($routeName)
    {
        $route = Config::getRoute($routeName);

        if (!$route) {
            throw new Exception();
        }

        header("Location: ${route['path']}");
        die;
    }

    protected function isPost() {
        return 'POST' === $_SERVER['REQUEST_METHOD'];
    }
}