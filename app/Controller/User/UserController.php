<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Model\Mongo\MessageMongo;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface;

class UserController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/user/login",
     *     tags={"User"},
     *     description="登录",
     *     @OA\Parameter(description="传入user，测试", in="query", name="user", required=false, @OA\Schema(type="string"), example="Yexk test"),
     *     @OA\Parameter(description="测试data参数", in="query", name="data", required=false, @OA\Schema(type="string"), example="测试啊！！！"),
     *     @OA\Response(
     *         response="default",
     *         description="successful"
     *     ),
     * )
     */
    public function login(): ResponseInterface
    {
        $Message = new MessageMongo();
        $res = $Message->add();
        return $this->success($res);
    }

    /**
     * 注册.
     */
    public function register(): ResponseInterface
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
