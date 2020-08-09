<?php

namespace RetwisReplica\App;

use Predis\{Client, Autoloader};

class App {
    public $redis;

    public function init() {
        $this->defineConstants();
    }

    public function getRedis() {
        if (!$this->redis) {
            Autoloader::register();
            $this->redis = new Client();
        }

        return $this->redis;
    }

    public static function throwError($code) {
        http_response_code($code);
    }

    public function defineConstants() {
        define('ROOT_PATH', dirname(dirname(__DIR__)));
        define('CONFIG_PATH', ROOT_PATH . '/config');
    }
}