<?php

namespace RetwisReplica\App;

use Predis\{Client};

class App {
    public $redis;

    public function __construct()
    {
        $this->redis = $this->getRedis();
    }

    public function getRedis() {
        require_once ('../Predis/Autoloader.php');
        Predis\Autoloader::register();

        return new Client();
    }
}