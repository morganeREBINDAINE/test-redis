<?php

namespace RetwisReplica\Controller;

class HomeController extends Controller
{
    public function home() {
        return $this->render('home/home');
    }

    public function login() {
        return $this->render('home/login');
    }

    public function register() {
        return $this->render('home/register');
    }
}