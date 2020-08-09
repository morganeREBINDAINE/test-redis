<?php

namespace RetwisReplica\Services;

use RetwisReplica\App\App;

class Authenticator
{
    private $redis;

    public function __construct()
    {
        $this->redis = (new App())->getRedis();
    }

    public function checkCredentials()
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        if (!$username || !$password) {
            return false;
        }

        if (!$id = $this->redis->hget('users', (string)$username)) {
            return false;
        }

        $userPassword = $this->redis->hget("user:$id", 'password');

        if ($password !== $userPassword) {
            return false;
        }

        return $id;
    }

    public function startSession($userId) {
        $sessionId = mt_rand();

        $this->redis->hdel("user:$userId", ['auth']);
        $this->redis->hset("user:$userId", 'auth', $sessionId);
        $this->redis->hdel("auth", [$sessionId]);
        $this->redis->hset("auth", $sessionId, $userId);

        setcookie('sessid', $sessionId);
    }

    public function isLoggedIn()
    {
        $sessid = $_COOKIE['sessid'] ?? null;

        if ($sessid) {
            $userId = $this->redis->hget('auth', $sessid);
            $userSession = $this->redis->hget("user:$userId", 'auth');
            if ($userSession === $sessid) {
                return true;
            }
            setcookie('sessid', null, -1);
        }

        return false;
    }
}