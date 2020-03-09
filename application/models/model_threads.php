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
}