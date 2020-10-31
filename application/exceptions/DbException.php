<?php

namespace Exception;

class DbException extends \RuntimeException
{
    protected $code = 500;
}