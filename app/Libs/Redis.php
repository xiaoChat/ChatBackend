<?php

declare(strict_types=1);

namespace App\Libs;

use App\Libs\RedisDriver\RedisDriver;

class Redis extends RedisDriver
{
    const TTL = 86400;

    const TOKEN_KEY = 'user:token:';

    const CHAT_SESSION_KEY = 'chat:session';

}
