<?php

use Exception\IllegalArgumentException;
use Database\MySQLi;

$request = json_decode(file_get_contents("php://input"), true);

if (!isset($request['thread_number']))
    throw new IllegalArgumentException("Field 'page' must be set");

$mysqli = new MySQLi();

$threads = $mysqli->getThread($request["thread_number"]);

$authors = [];
foreach ($mysqli->getAuthorsOfThread($threads['id']) as $key) {
    array_push($authors, $key["login"]);
}

if (sizeof($threads) == 0) {
    http_response_code(204);
    exit();
}

print json_encode([
    'thread' => $threads,
    'authors' => $authors
]);