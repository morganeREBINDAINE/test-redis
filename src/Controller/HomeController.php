<?php

namespace RetwisReplica\Controller;

class HomeController extends Controller
{
    public function home() {
        return $this->render('home/home');
    }

    public function login()
    {
        if ($this->authenticator->isLoggedIn()) {
            return $this->redirect('home');
        }

        $message = null;

        if ($this->isPost()) {
            if ($id = $this->authenticator->checkCredentials()) {
                $this->authenticator->startSession($id);
                return $this->redirect('profile');
            }
            $message = 'Invalid credentials';
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