<?php

use Database\MySQLi;

class model_account
{
    private $mysqli;

    /**
     * model_account constructor.
     */
    public function __construct()
    {
        $this->mysqli = new MySQLi();
    }

    public function registerUser($request)
    {
        $this->mysqli->registerUser($request['login'], $request['password']);
    }

    public function authByToken()
    {
        return $this->mysqli->authByToken($_COOKIE['id'], $_COOKIE['token']);
    }

    public function checkUserExists($login)
    {
        return $this->mysqli->checkUserExists($login);
    }

    public function authentication($login, $password)
    {
        return $this->mysqli->authentication($login, $password);
    }

    public function authorization($login)
    {
        $userId = $this->mysqli->getUserId($login);

        setcookie('id', $userId, time() + 86400, '/');
        setcookie('login', $login, time() + 86400, '/');
        setcookie('token', $this->mysqli->authorization($userId), time() + 86400, '/');
    }

    public function getUserInfo()
    {
        return $this->mysqli->getUserInfo($_COOKIE['id']);
    }

    public function logout()
    {
        $this->mysqli->invalidateToken($_COOKIE['id'], $_COOKIE['token']);
        unset($_COOKIE['id']);
        unset($_COOKIE['login']);
        unset($_COOKIE['token']);
        setcookie('id', null, -1, '/');
        setcookie('login', null, -1, '/');
        setcookie('token', null, -1, '/');
    }
}