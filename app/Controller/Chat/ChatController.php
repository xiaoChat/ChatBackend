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
    // 数据
    private $pushData;

    // 房间ID
    private $roomId;

    public function onMessage($server, Frame $frame): void
    {
        $this->pushAll($server, $frame->fd, $frame->data);
    }

    public function onClose($server, int $fd, int $reactorId): void
    {
        $curChat = json_decode(Redis::hget(Redis::CHAT_SESSION_KEY, Redis::CHAT_SESSION_KEY . ':' . $this->roomId . ':' . $fd), true);
        Redis::hdel(Redis::CHAT_SESSION_KEY, Redis::CHAT_SESSION_KEY . ':' . $this->roomId . ':' . $fd);
        $hash = Redis::hgetall(Redis::CHAT_SESSION_KEY);
        foreach ($hash as $k => $v) {
            $fd = intval(ltrim($k, Redis::CHAT_SESSION_KEY . ':' . $this->roomId . ':'));
            $server->push($fd, '[' . $curChat['name'] . ']' . 'logout!');
        }
    }

    public function onOpen($server, Request $request): void
    {
        // 获取roomid
        $_t = explode('/', $request->server['path_info']);
        if (count($_t) < 3) {
            $server->close($request->fd);
        }
        $this->roomId = $_t[2];
        // TODO 查询是否存在该房间，后续查询数据库
        $arr = ['lspchat', 'lspchat2'];
        if (! empty($this->roomId) && ! in_array($this->roomId, $arr)) {
            $server->close($request->fd);
        }
        $username = 'lsp' . substr(md5(time() . $request->fd), 0, 6);
        Redis::hset(Redis::CHAT_SESSION_KEY, Redis::CHAT_SESSION_KEY . ':' . $this->roomId . ':' . $request->fd, json_encode(['name' => $username, 'date' => date('Y-m-d')]));
        $this->pushAll($server, $request->fd, 'welcome to lsp!', [], 0);
    }

    public function pushAll($server, $fd, $msg = '', $data = [], $type = 1)
    {
        $curChat = json_decode(Redis::hget(Redis::CHAT_SESSION_KEY, Redis::CHAT_SESSION_KEY . ':' . $this->roomId . ':' . $fd), true);
        $hash = Redis::hgetall(Redis::CHAT_SESSION_KEY);
        foreach ($hash as $k => $v) {
            $fd = intval(ltrim($k, Redis::CHAT_SESSION_KEY . ':' . $this->roomId . ':'));
            var_dump($k);
            if ($server->isEstablished($fd)) {
                $server->push($fd, $this->msg($curChat['name'], $msg, $data, $type));
            }
        }
    }

    /**
     * 组装push信息.
     * @param mixed $username
     * @param mixed $msg
     * @param mixed $data
     * @param mixed $type
     */
    private function msg($username, $msg, $data = [], $type = 1): string
    {
        $this->pushData['type'] = $type;
        $this->pushData['username'] = $username;
        $this->pushData['message'] = $msg;
        $this->pushData['data'] = $data;
        $this->pushData['date'] = date('Y-m-d H:i:s');
        return json_encode($this->pushData);
    }
}
