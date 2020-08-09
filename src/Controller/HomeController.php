<?php

namespace RetwisReplica\Controller;

class HomeController extends Controller
{
    public function home() {
        return $this->render('home');
    }
}