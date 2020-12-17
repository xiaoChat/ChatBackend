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

    /**
     * @Inject
     * @var User
     */
    private $User;

    public function register(string $username, string $password)
    {
        $res = User::query()->where(['username' => $username])->first();
        if ($res) {
            return false;
        }
        Db::beginTransaction();
        try {
            $userData = [
                'chat_no' => $this->Common->getIdGenerator(),
                'username' => $username,
                'password' => $this->User->password($password),
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
        $userData = User::query()->where(['username' => $username])->first();
        if ($userData && $userData->password === $this->User->password($password)) {
            return $userData->toArray();
        }
        return false;
    }

    public function changePassword(string $password, string $newpassword, int $id): bool
    {
        $userData = User::query()->find($id);
        if ($userData && $userData->password === $this->User->password($password)) {
            $userData->password = $this->User->password($newpassword);
            $userData->save();
            return true;
        }
        return false;
    }

    public function getUserDetailById(int $id)
    {
        $user = User::query()->find($id);
        $user->profile;
        return $user;
    }

    public function setToken(array $userData)
    {
        $token = $this->Common->uuid();
        $key = Redis::TOKEN_KEY . $token;
        Redis::set($key, json_encode($userData), Redis::TTL);
        return $token;
    }

    public function getUserInfoByToken(string $token)
    {
        $key = Redis::TOKEN_KEY . $token;
        $data = Redis::get($key);
        if ($data) {
            return json_decode($data);
        }
        return $data;
    }

    public function checkByUserId(int $user_id)
    {
        return User::query()->find($user_id);
    }

    public function search(string $name)
    {
        return User::query()
            ->select(['id', 'chat_no', 'username', 'nickname', 'avatar'])
            ->where('username', 'like', $name . '%')
            ->get();
    }
}
