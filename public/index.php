<?php

require_once ('../vendor/autoload.php');

use \RetwisReplica\App\Router;

define('ROOT_PATH', dirname(__DIR__));
define('CONFIG_PATH', ROOT_PATH . '/config');

(new Router())->start();

