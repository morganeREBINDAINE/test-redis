<?php

require_once ('../vendor/autoload.php');

use RetwisReplica\App\{App, Router};

(new App())->init();
(new Router())->start();

