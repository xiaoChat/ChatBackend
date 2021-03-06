<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Constants\ApiCode;
use App\Controller\BaseController;
use App\Model\Logic\UserLogic;
use Hyperf\Di\Annotation\Inject;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface;

class UserController extends BaseController
{
    /**
     * @Inject
     * @var UserLogic
     */
    protected $UserLogic;

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
        $username = trim($this->request->input('username'));
        $password = trim($this->request->input('password'));
        if (! $username || ! $password) {
            return $this->fail(ApiCode::PARAMS_REQUEST);
        }
        $user = $this->UserLogic->login($username, $password);
        if ($user) {
            // 设置缓存
            $token = $this->UserLogic->setToken($user);
            return $this->success([
                'token' => $token,
                'userinfo' => $user,
            ]);
        }
        return $this->fail();
    }

    /**
     * 注册.
     */
    public function register(): ResponseInterface
    {
        $username = trim($this->request->input('username'));
        $password = trim($this->request->input('password'));
        if (! $username || ! $password) {
            return $this->fail(ApiCode::PARAMS_REQUEST);
        }
        $user = $this->UserLogic->register($username, $password);
        if ($user) {
            $token = $this->UserLogic->setToken($user->toArray());
            return $this->success([
                'token' => $token,
                'userinfo' => $user,
            ]);
        }
        return $this->fail(ApiCode::USER_REGISTER_FAIL);
    }

    /**
     * 忘记密码，找回密码
     */
    public function changePassword(): ResponseInterface
    {
        $password = trim($this->request->input('password'));
        $newpassword = trim($this->request->input('newpassword'));
        if (! $password || ! $newpassword) {
            return $this->fail(ApiCode::PARAMS_REQUEST);
        }
        $user_id = $this->request->getAttribute('user_id');
        $res = $this->UserLogic->changePassword($password, $newpassword, $user_id);
        if ($res) {
            return $this->success();
        }
        return $this->fail();
    }
}
