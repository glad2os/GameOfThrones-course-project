<?php

use Database\MySQLi;
use Exception\ForbiddenException;
use Exception\IllegalArgumentException;

$mysqli = new MySQLi();
if (!checkPermissions($mysqli)) throw new ForbiddenException('Access Denied');

$request = json_decode(file_get_contents("php://input"), true);

if (!isset($request['login']) || !$mysqli->checkUserExists($request['login']) || !preg_match('/[-_#!0-9a-zA-Z]{3,}/', $request['login']))
    throw new IllegalArgumentException('Bad request');

$mysqli->setUserPermissions($mysqli->getUserId($request['login']), 1);

http_response_code(204);
