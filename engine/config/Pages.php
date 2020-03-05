<?php

use Database\MySQLi;

$pages = [
    '' => [
        'title' => 'Game of Thrones',
        'content' => 'index.html',
        'activeNavBtn' => "Home",
        'scripts' => ['api', 'cookies', 'nav-del'],
    ],
    'lore' => [
        'title' => 'Сюжет',
        'content' => 'lore.html',
        'activeNavBtn' => "Histories & Lore",
        'scripts' => ['api', 'cookies', 'nav-del'],
    ],
    'great_houses' => [
        'title' => 'Великие дома',
        'content' => 'great_houses.html',
        'activeNavBtn' => "Great houses",
        'scripts' => ['api', 'cookies', 'nav-del'],
    ],
    'stark' => [
        'title' => 'Старки',
        'content' => 'stark.html',
        'activeNavBtn' => "Сharacters",
        'scripts' => ['api', 'cookies', 'nav-del'],
    ],
    'lannister' => [
        'title' => 'Ланнистеры',
        'content' => 'lannister.html',
        'activeNavBtn' => "Сharacters",
        'scripts' => ['api', 'cookies', 'nav-del'],
    ],
    'targaryen' => [
        'title' => 'Таргариены',
        'content' => 'targaryen.html',
        'activeNavBtn' => "Сharacters",
        'scripts' => ['api', 'cookies', 'nav-del'],
    ],
    'other' => [
        'title' => 'Другие',
        'content' => 'other.html',
        'activeNavBtn' => "Сharacters",
        'scripts' => ['api', 'cookies', 'nav-del'],
    ],
    'about_us' => [
        'title' => 'О нас',
        'content' => 'about_us.html',
        'activeNavBtn' => "About Us",
        'scripts' => ['api', 'cookies', 'nav-del'],
    ],
    'sign_up' => [
        'title' => 'Регистрация',
        'content' => 'sign_up.html',
        'activeNavBtn' => "Account",
        'scripts' => ['api', 'cookies', 'nav-del'],
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
        'activeNavBtn' => "Account",
        'scripts' => ['api', 'cookies', 'nav-del'],
        'onselect' => function () {
            if (authByToken(new MySQLi())) {
                header('Location: /account');
                exit();
            }
        }
    ],
    'account' => [
        'title' => 'Личный кабинет',
        'content' => 'account.html',
        'activeNavBtn' => "Account",
        'onselect' => function () {
            if (!authByToken(new MySQLi())) {
                header('Location: /sign_in');
                exit();
            }
        },
        'scripts' => ['api', 'account_loader', 'cookies', 'nav-del']
    ],
    'post' => [
        'title' => 'Добавить новостной пост',
        'content' => 'post.html',
        'scripts' => ['api', 'cookies', 'nav-del'],
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
        'scripts' => ['api']
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
