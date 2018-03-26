<?php

$config = [
    'homepage_route' => 'home',
    'db' => [
        'name' => 'testhe',
        'user' => 'root',
        'password' => '',
        'host' => '127.0.0.1',
        'port' => null,
    ],
    'routes' => [
        'home' => 'Main:home',
        'login' => 'Main:login',
        'createAccount' => 'Main:createAccount',
    ],
];
