<?php

namespace RetwisReplica\Controller;

use Exception;
use RetwisReplica\App\{App, Twig};

abstract class Controller
{
    public $twig;

    public function __construct()
    {
        $this->twig = (new Twig())->getTwig();
    }

    protected function render(string $template, array $vars = []) {
        try {
            echo $this->twig->render("$template.html.twig", $vars);
        } catch (Exception $exception) {
            App::throwError(400);
            // @todo display error page with generic message, log stack trace
            $this->render('errors/400', [
                'errorMessage' => $exception->getMessage() . '<br>' . $exception->getTraceAsString()
            ]);
        }
    }

    protected function isPost() {
        return 'POST' === $_SERVER['REQUEST_METHOD'];
    }
}