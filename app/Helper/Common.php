<?php

declare(strict_types=1);

namespace App\Helper;

use App\Constants\ApiCode;
use Hyperf\Snowflake\IdGeneratorInterface;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Context;
use Psr\Http\Message\ServerRequestInterface;

class Common
{
    public function json(int $code = 200, $data = [], string $message = ''): array
    {
        return [
            'code' => $code,
            'data' => $data,
            'message' => $message ?: ApiCode::getMessage($code),
        ];
    }

    public function getIpAddress()
    {
        $request = Context::get(ServerRequestInterface::class);
        $ip = $request->getHeader('x-forwarded-for')[0] ?? 'unknown';
        return $ip;
    }

    public function getIdGenerator()
    {
        $container = ApplicationContext::getContainer();
        $generator = $container->get(IdGeneratorInterface::class);
        return $generator->generate();
    }

    public function uuid()
    {
        return md5(config('app_key') . time() . uniqid());
    }
}
