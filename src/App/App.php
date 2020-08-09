<?php

namespace RetwisReplica\App;

use Predis\{Client, Autoloader};

class App {
    public $redis;

    public function __construct()
    {
        $this->redis = $this->getRedis();
    }

    public function getRedis() {
        Autoloader::register();

        return new Client();
    }

    public static function throwError($code) {
        http_response_code($code);
    }
}