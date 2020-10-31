<?php

use Database\MySQLi;

class model_threads
{
    private $mysqli;

    /**
     * model_account constructor.
     */
    public function __construct()
    {
        $this->mysqli = new MySQLi();
    }

    public function getThread($id)
    {
        return $this->mysqli->getThread($id);
    }

    public function getAllThreads()
    {
        return $this->mysqli->getAllThreads();
    }

    public function addThread($title, $text, $img)
    {
        return $this->mysqli->addThread($title, $text, $img);
    }

    public function getAuthor($thread_id)
    {
        return $this->mysqli->getAuthorsOfThread($thread_id);
    }

}