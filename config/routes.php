<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use App\Middleware\ApiMiddleware;
use App\Middleware\CorsMiddleware;
use Hyperf\HttpServer\Router\Router;

// debug
$debug = env('APP_ENV', 'dev');

Router::addGroup(
    '',
    function () {
        Router::addRoute(['GET', 'POST'], '/', 'App\Controller\IndexController@index');
    },
    ['middleware' => [CorsMiddleware::class]]
);

// 用户模块

// 登录注册
Router::addGroup(
    '/user/',
    function () {
        Router::addRoute('POST', 'login', 'App\Controller\User\UserController@login');
        Router::addRoute('POST', 'register', 'App\Controller\User\UserController@register');
        Router::addRoute('POST', 'changePassword', 'App\Controller\User\UserController@changePassword');
        Router::addRoute('GET', 'info', 'App\Controller\User\UserController@info');
        Router::addRoute('POST', 'info', 'App\Controller\User\UserController@changeInfo');
    },
    ['middleware' => [CorsMiddleware::class]]
);

// 用户资料
Router::addGroup(
    '/user/profile',
    function () {
        Router::addRoute('GET', '', 'App\Controller\User\ProfileController@getUserProfile');
        Router::addRoute('POST', '', 'App\Controller\User\ProfileController@setUserProfile');
    },
    ['middleware' => [CorsMiddleware::class, ApiMiddleware::class]]
);

// Websocket
Router::addServer('ws', function () {
    Router::get('/', 'App\Controller\Chat\WebSocketController');
    Router::get('/chat', 'App\Controller\Chat\ChatController');
});
