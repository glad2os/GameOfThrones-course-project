<?php

use Exception\ForbiddenException;
use Exception\IllegalArgumentException;
use Database\MySQLi;

$mysqli = new MySQLi();
if (!authByToken($mysqli) || !checkPermissions($mysqli)) throw new ForbiddenException();

$request = json_decode(file_get_contents("php://input"), true);

if ((!isset($request['title'])) ||
    (!isset($request['text'])) ||
    (!isset($request['author']))
) throw new IllegalArgumentException("Fields title, text, author must be exists");

$threadId = $mysqli->addThread($request['title'], $request['text'], $request['img']);
$mysqli->linkThread($request['author'], $threadId);

http_response_code(204);

