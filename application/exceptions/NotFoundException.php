<?php

namespace Exception;

class NotFoundException extends \RuntimeException
{
    protected $code = 404;
}