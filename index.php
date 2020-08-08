<?php

require_once ('Predis/Autoloader.php');
\Predis\Autoloader::register();

require_once ('constants.php');

//$username = $_GET['username'];
//$pass = 'pass';

//$redis = new \Predis\Client();
//$userid = $redis->incr('userid');
//$user = $redis->hset('users', $username, $userid);
//$userPass = $redis->hset("user:$userid", 'password', $pass);
//$userSession = $redis->hset("user:$userid", 'session', mt_rand());
//
//if ($user) {
//    echo ('le user a été créé');
//} else {
//    echo ('non désolé pas créé : surement deja pris');
//}

$route = str_replace('/retwis-replica', '', $_SERVER['REQUEST_URI']);
switch ($route) {
    case ROUTE_HOME:
        return require ('templates/home.html');
    default:
        echo 'nop';
}