<?php

declare(strict_types=1);

namespace App\Model\Logic;

use App\Constants\ModelCode;
use App\Helper\Common;
use App\Model\Entity\Friend;
use Hyperf\Di\Annotation\Inject;

class FriendLogic
{
    /**
     * @Inject
     * @var Common
     */
    private $Common;

    public function addFriendsByUserId(int $friend_id, array $others)
    {
        $user_id = $others['id'];
        if (! $user_id || $user_id == $friend_id) {
            return ModelCode::USER_NOT_SELF_ERROR;
        }

        $friendInfo = Friend::query()->where('friend_id', $friend_id)->first();
        if ($friendInfo) {
            // 该用户已经添加过。
            return ModelCode::FRIEND_IS_ADDED;
        }
        $data = [
            'user_id' => $user_id,
            'friend_id' => $friend_id,
            'name' => $others['name'] ?? '',
            'add_date' => date('Y-m-d H:i:s'),
        ];
        return Friend::create($data);
    }

    public function getFriendsByUserId(int $user_id)
    {
        return Friend::query()->where('user_id', $user_id)->with('friend')->get()->map(function ($v) {
            $friends = $v->friend;
            unset($v->friend);
            $v->friend = [
                'id' => $friends->id,
                'username' => $friends->username,
                'avatar' => $friends->avatar,
                'nickname' => $friends->nickname,
            ];
            return $v;
        });
    }
}
