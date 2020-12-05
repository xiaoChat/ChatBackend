<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Exception\Handler;

use App\Constants\ErrorCode;
use App\Exception\ApiException;
use App\Helper\Common;
use Hyperf\Di\Annotation\Inject;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ApiExceptionHandler extends ExceptionHandler
{
    /**
     * @Inject
     * @var Common
     */
    protected $common;

    public function handle(Throwable $throwable, ResponseInterface $response)
    {

        // 拦截所有api异常，
        $data = json_encode($this->common->json($throwable->getCode(), null, $throwable->getMessage()));

        $this->stopPropagation();

        return $response->withStatus(200)->withAddedHeader('Content-Type', 'application/json; charset=utf-8')->withBody(new SwooleStream($data));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ApiException;
    }
}
