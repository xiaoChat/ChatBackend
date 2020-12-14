<?php

declare(strict_types=1);

namespace App\Model\Logic;

use App\Helper\Common;
use App\Libs\Redis;
use App\Model\Entity\Profile;
use App\Model\Entity\User;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

class UserLogic
{
    /**
     * @Inject
     * @var Common
     */
    private $Common;

    public function register(string $username, string $password)
    {
        $res = User::where(['username' => $username])->first();
        if ($res) {
            return false;
        }
        Db::beginTransaction();
        try {
            $userData = [
                'chat_no' => $this->Common->getIdGenerator(),
                'username' => $username,
                'password' => (new User())->password($password),
            ];
            $user = User::create($userData);
            $profileData = [
                'user_id' => $user->id,
                'register_ip' => $this->Common->getIpAddress(),
                'register_time' => date('Y-m-d H:i:s'),
                'register_time' => date('Y-m-d H:i:s'),
            ];
            $profile = Profile::create($profileData);

            Db::commit();
            $user->profile = $profile;
            return $user;
        } catch (\Throwable $ex) {
            Db::rollBack();
            return false;
        }
    }

    public function login(string $username, string $password)
    {
        $userData = User::where(['username' => $username])->first();
        if ($userData && $userData->password === (new User())->password($password)) {
            return $userData->toArray();
        }
        return false;
    }

    public function setToken(array $userData)
    {
        $token = $this->Common->uuid();
        $key = Redis::TOKEN_KEY . $token;
        Redis::set($key, json_encode($userData), Redis::TTL);
        return $token;
    }
}
