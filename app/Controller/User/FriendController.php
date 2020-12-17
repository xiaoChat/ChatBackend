<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Constants\ApiCode;
use App\Constants\ModelCode;
use App\Controller\BaseController;
use App\Model\Logic\FriendLogic;
use App\Model\Logic\UserLogic;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;

class FriendController extends BaseController
{
    /**
     * @Inject
     * @var UserLogic
     */
    protected $UserLogic;

    /**
     * @Inject
     * @var FriendLogic
     */
    protected $FriendLogic;

    public function getFriends(): ResponseInterface
    {
        $user_id = $this->request->getAttribute('user_id');
        if ($user_id) {
            $res = $this->FriendLogic->getFriendsByUserId($user_id);
            return $this->success($res);
        }
        return $this->fail();
    }

    /**
     * 目前仅支持搜索用户名.
     */
    public function searchFriends(): ResponseInterface
    {
        $name = $this->request->input('name');
        if ($name) {
            $res = $this->UserLogic->search($name);
            return $this->success($res);
        }
        return $this->fail();
    }

    public function addFriends(int $id): ResponseInterface
    {
        $friend_id = $id;
        $user_id = $this->request->getAttribute('user_id');
        if (! $friend_id) {
            return $this->fail(ApiCode::PARAMS_REQUEST);
        }
        if (! $this->UserLogic->checkByUserId($friend_id)) {
            return $this->fail(ApiCode::USER_INFO_ERROR);
        }

        // TODO 后续改成审核的方式
        $res = $this->FriendLogic->addFriendsByUserId($friend_id, ['id' => $user_id]);
        if (is_numeric($res)) {
            return $this->fail($res, null, ModelCode::MODEL_TYPE);
        }
        if ($res) {
            return $this->success($res);
        }
        return $this->fail();
    }
}
