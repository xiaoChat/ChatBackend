<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface;

class ProfileController extends BaseController
{
    /**
     * 获取用户信息
     */
    public function getUserProfile(): ResponseInterface
    {
        return $this->success();
    }
    
    /**
     * 设置用户信息
     */
    public function setUserProfile(): ResponseInterface
    {
        return $this->success();
    }

    /**
     * 忘记密码，找回密码
     */
    public function changePassword(): ResponseInterface
    {
        return $this->success();
    }

}
