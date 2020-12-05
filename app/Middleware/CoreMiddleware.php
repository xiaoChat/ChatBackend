<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Constants\ErrorCode;
use App\Exception\ApiException;
use Hyperf\HttpServer\CoreMiddleware as HfCoreMiddleware;
use Psr\Http\Message\ServerRequestInterface;

class CoreMiddleware extends HfCoreMiddleware
{
    protected function handleMethodNotAllowed(array $methods, ServerRequestInterface $request)
    {
        // 重写 HTTP 方法不允许的处理逻辑
        throw new ApiException(ErrorCode::NOT_ALLOW);
    }

    protected function handleNotFound(ServerRequestInterface $request)
    {
        throw new ApiException(ErrorCode::NOT_FOUND);
    }
}
