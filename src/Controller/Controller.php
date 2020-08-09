<?php

namespace RetwisReplica\Controller;

abstract class Controller
{
    public $twig;

    public function __construct()
    {
        $this->twig = $this->initTwig();
    }

    private function initTwig()
    {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/templates');
        $twig = new \Twig\Environment($loader);

        return $twig;
    }

    protected function render(string $template, array $vars = []) {
        try {
            echo $this->twig->render("$template.html.twig", $vars);
        } catch (\Exception $exception) {
            $this->throwError(400);
            $this->render('errors/400', [
                'errorMessage' => 'Erreur: le template existe pas.'
            ]);
        }
    }

    protected function throwError($code) {
        http_response_code($code);
    }
}