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

// Websocket
Router::addServer('ws', function () {
    Router::get('/', 'App\Controller\Chat\WebSocketController');
});
