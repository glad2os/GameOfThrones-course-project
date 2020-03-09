<?php

use Exception\NotFoundException;
use Exception\NotImplmentedException;

class Route
{
    static function start()
    {
        $controller_name = 'Main';
        $action_name = 'index';

        $routes = preg_split('/[\/?]/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        }

        if (!empty($routes[2])) {
            $action_name = $routes[2];
        }

        $model_name = 'model_' . $controller_name;
        $controller_name = 'controller_' . $controller_name;
        $action_name = 'action_' . $action_name;

        $model_file = strtolower($model_name) . '.php';
        $model_path = __DIR__ . "/../models/" . $model_file;
        if (file_exists($model_path)) {
            include __DIR__ . "/../models/" . $model_file;
        }

        $controller_file = strtolower($controller_name) . '.php';
        $controller_path = __DIR__ . "/../controllers/" . $controller_file;

        if (file_exists($controller_path)) {
            include __DIR__ . "/../controllers/" . $controller_file;
        } else {
            Route::error(new NotFoundException());
        }

        // создаем контроллер
        $controller = new $controller_name;
        $action = $action_name;

        if (method_exists($controller, $action)) {
            // вызываем действие контроллера
            $controller->$action();
        } else {
            // здесь также разумнее было бы кинуть исключение
            Route::error(new NotImplmentedException());
        }
    }

    static private function error($exception)
    {
        include __DIR__ . "/../controllers/controller_error.php";
        (new controller_error)->action_exception($exception);
        exit(0);
    }
}