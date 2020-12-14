<?php

declare(strict_types=1);

namespace App\Helper;

use App\Constants\ApiCode;
use Hyperf\Snowflake\IdGeneratorInterface;
use Hyperf\Utils\ApplicationContext;

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
        if ($_SERVER['HTTP_CLIENT_IP'] && strcasecmp($_SERVER['HTTP_CLIENT_IP'], 'unknown')) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if ($_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], 'unknown')) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                if ($_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
                    $ip = $_SERVER['REMOTE_ADDR'];
                } else {
                    if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp(
                        $_SERVER['REMOTE_ADDR'],
                        'unknown'
                    )
                    ) {
                        $ip = $_SERVER['REMOTE_ADDR'];
                    } else {
                        $ip = 'unknown';
                    }
                }
            }
        }
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
        return md5(config('app_key').time().uniqid());
    }
}
