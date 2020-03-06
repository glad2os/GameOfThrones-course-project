<?php
use Config\Books;
use Exception\IllegalArgumentException;
use Database\MySQLi;

$request = json_decode(file_get_contents("php://input"), true);

//if (!isset($request['page']))
//    throw new IllegalArgumentException("Field 'page' must be set");

$mysqli = new MySQLi();

$books = $mysqli->getAllThreads();

foreach ($books as $key => $book) {
    $books[$key]['authors'] = $mysqli->getAuthorsOfThread($book['id']);
}
print json_encode($books);

if (sizeof($books) == 0) {
    http_response_code(204);
    exit();
}
print json_encode([
    'page' => $request['page'],
    'pageCount' => ceil($mysqli->countOfBooks() / Books\BOOKS_ON_PAGE),
    'books' => $books
]);