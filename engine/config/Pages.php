<?php

use Database\MySQLi;

$pages = [
    '' => [
        'title' => 'GoT',
        'content' => 'index.html',
        'active' => 0,
        'scripts' => ['']
    ],
    'sign_up' => [
        'title' => 'Регистрация',
        'content' => 'sign_up.html',
        'active' => 5,
        'onselect' => function () {
            if (authByToken(new MySQLi())) {
                header('Location: /account');
                exit();
            }
        }
    ],
    'sign_in' => [
        'title' => 'Авторизация',
        'content' => 'sign_in.html',
        'active' => 5,
        'onselect' => function () {
            if (authByToken(new MySQLi())) {
                header('Location: /account');
                exit();
            }
        }
    ],
    'account' => [
        'title' => 'Личный кабинет | GLADDOS.STUDIO',
        'content' => 'account.html',
        'onselect' => function () {
            if (!authByToken(new MySQLi())) {
                header('Location: /sign_in');
                exit();
            }
        },
        'scripts' => ['account_loader']
    ],
    'catalog' => [
        'title' => 'Каталог | GLADDOS.STUDIO',
        'content' => 'catalog.html',
        'scripts' => ['catalog_loader']
    ],
    'admin' => [
        'title' => 'Панель администратора | GLADDOS.STUDIO',
        'content' => 'admin.html',
        'onselect' => function () {
            $mysqli = new MySQLi();
            if (!authByToken($mysqli)) {
                header('Location: /sign_in');
                exit();
            }
            if (!checkPermissions($mysqli)) {
                header('Location: /403');
                exit();
            }
        },
        'scripts' => ['admin_loader']
    ],
    '404' => [
        'title' => 'Не найдено | GLADDOS.STUDIO',
        'content' => '404.html'
    ],
    '403' => [
        'title' => 'Доступ запрещён | GLADDOS.STUDIO',
        'content' => '403.html'
    ],
    'install' => [
        'title' => 'Установщик',
        'content' => 'install.html'
    ]
];