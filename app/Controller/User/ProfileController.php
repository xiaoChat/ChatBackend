<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Model\Logic\UserLogic;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;

class ProfileController extends BaseController
{
    /**
     * @Inject
     * @var UserLogic
     */
    protected $UserLogic;

    /**
     * 获取用户信息.
     */
    public function getUserProfile(): ResponseInterface
    {
        $user_id = $this->request->getAttribute('user_id');
        $data = $this->UserLogic->getUserDetailById($user_id);
        return $this->success($data);
    }

    /**
     * 设置用户信息.
     */
    public function setUserProfile(): ResponseInterface
    {
        return $this->success();
    }
}
