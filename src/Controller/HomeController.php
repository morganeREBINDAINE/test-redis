<?php

namespace RetwisReplica\Controller;

class HomeController extends Controller
{
    public function home() {
        return $this->render('home/home');
    }

    public function login()
    {
        $message = null;

        if ($this->isPost() && false !== $this->authenticator->logUser()) {
            return $this->redirect('profile');
        }

        return $this->render('home/login', [
            'message' => $message
        ]);
    }

    public function register() {
        if ($this->authenticator->isLoggedIn()) {
            return $this->redirect('home');
        }
        return $this->render('home/register');
    }

    public function profile() {
        if (false === $this->authenticator->isLoggedIn()) {
            $this->forbid();
        }
        return $this->render('home/profile');
    }
}