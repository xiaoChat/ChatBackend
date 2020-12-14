<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Hyperf\Database\Model\SoftDeletes;
use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id
 * @property int $chat_no
 * @property string $username
 * @property string $password
 * @property string $avatar
 * @property string $nickname
 * @property int $user_state_id
 * @property int $status
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class User extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chat_no',
        'username',
        'password',
        'avatar',
        'nickname',
        'user_state_id',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'chat_no' => 'integer', 'user_state_id' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function password($password)
    {
        return md5(md5($password . config('app_key')));
    }
}
