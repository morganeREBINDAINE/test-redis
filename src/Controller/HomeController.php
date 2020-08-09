<?php

namespace RetwisReplica\Controller;

use RetwisReplica\Services\Authenticator;

class HomeController extends Controller
{
    public function home() {
        return $this->render('home/home');
    }

    public function login()
    {
        $authenticator = new Authenticator();
        $message = null;

        if ($this->isPost() && false !== $authenticator->logUser()) {
            $message = 'you are logged in!!';
        }

        return $this->render('home/login', [
            'message' => $message
        ]);
    }

    public function register() {
        return $this->render('home/register');
    }
}