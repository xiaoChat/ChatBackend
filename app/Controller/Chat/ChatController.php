<?php

declare(strict_types=1);

namespace App\Controller\Chat;

use App\Libs\Redis;
use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Swoole\Http\Request;
use Swoole\Websocket\Frame;

class ChatController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{
    public function onMessage($server, Frame $frame): void
    {
        $curChat = json_decode(Redis::hget('chat:session', 'chat:session:' . $frame->fd), true);
        $hash = Redis::hgetall('chat:session');
        foreach ($hash as $k => $v) {
            $fd = intval(ltrim($k, 'chat:session:'));
            if ($server->isEstablished($fd)) {
                $server->push($fd, '[' . $curChat['name'] . ']' . $frame->data);
            }
        }
    }

    public function onClose($server, int $fd, int $reactorId): void
    {
        $curChat = json_decode(Redis::hget('chat:session', 'chat:session:' . $fd), true);
        Redis::hdel('chat:session', 'chat:session:'. $fd);
        $hash = Redis::hgetall('chat:session');
        foreach ($hash as $k => $v) {
            $fd = intval(ltrim($k, 'chat:session:'));
            $server->push($fd, '[' . $curChat['name'] . ']' . 'logout!');
        }
        var_dump('closed');
    }

    public function onOpen($server, Request $request): void
    {
        Redis::hset('chat:session', 'chat:session:' . $request->fd, json_encode(['name' => $request->fd.'yexk' . rand(10000, 200000), 'date' => rand(10000, 200000)]));
        $server->push($request->fd, $request->fd . 'Opened');
    }
}
