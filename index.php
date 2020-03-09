<?php
ini_set('display_errors', 1);
include_once __DIR__ . '/application/core/model.php';
include_once __DIR__ . '/application/core/view.php';
include_once __DIR__ . '/application/core/controller.php';
include_once __DIR__ . '/application/core/route.php';
include_once __DIR__ . '/application/config/dbconf.php';
include_once __DIR__ . '/application/core/MySQLi.php';
include_once __DIR__ . '/application/exceptions/DbConnectionException.php';
include_once __DIR__ . '/application/exceptions/DbException.php';
include_once __DIR__ . '/application/exceptions/ForbiddenException.php';
include_once __DIR__ . '/application/exceptions/IllegalArgumentException.php';
include_once __DIR__ . '/application/exceptions/InvalidCredentialsException.php';
include_once __DIR__ . '/application/exceptions/NotFoundException.php';
include_once __DIR__ . '/application/exceptions/NotImplmentedException.php';

Route::start();