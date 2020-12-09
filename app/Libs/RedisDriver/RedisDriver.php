<?php

declare(strict_types=1);

namespace App\Libs\RedisDriver;

use Hyperf\Redis\RedisFactory;
use Hyperf\Utils\ApplicationContext;

class RedisDriver
{
    public static function __callStatic($name, $arguments)
    {
        return self::getInstance()->{$name}(...$arguments);
    }

    public function __call($name, $arguments)
    {
        return self::getInstance()->{$name}(...$arguments);
    }

    // 连接池名称
    public static function getInstance(string $name = 'default')
    {
        return ApplicationContext::getContainer()->get(RedisFactory::class)->get($name);
    }
}
