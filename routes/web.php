<?php

/** @var $router Router */

use Laravel\Lumen\Routing\Router;

$router->get('/', 'IndexController@status');

$router->post('login', 'AuthController@login');
$router->post('register', 'AuthController@register');
