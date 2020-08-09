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
        echo $this->twig->render("$template.html.twig", $vars);
    }
}