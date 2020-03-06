<?php

use Database\MySQLi;

$request = json_decode(file_get_contents("php://input"), true);

$mysqli = new MySQLi();

$threads = $mysqli->getAllThreads();

foreach ($threads as $key => $thread) {
    $threads[$key]['authors'] = $mysqli->getAuthorsOfThread($thread['id']);
}

if (sizeof($threads) == 0) {
    http_response_code(204);
    exit();
}

print json_encode($threads);