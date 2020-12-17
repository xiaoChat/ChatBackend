<?php

declare(strict_types=1);

namespace App\Controller\Chat;

use App\Controller\BaseController;
use App\Model\Logic\UserLogic;
use Hyperf\Di\Annotation\Inject;
use Hyperf\WebSocketServer\Sender;
use Psr\Http\Message\ResponseInterface;

class MessageController extends BaseController
{
    /**
     * @Inject
     * @var UserLogic
     */
    protected $UserLogic;

    /**
     * @Inject
     * @var Sender
     */
    protected $sender;

    /**
     * 获取用户信息.
     */
    public function sendMessage(int $id): ResponseInterface
    {
        $this->sender->push($id, 'Hello World.');
        return $this->success();
    }

    /**
     * 设置用户信息.
     */
    public function setUserProfile(): ResponseInterface
    {
        return $this->success();
    }
}
