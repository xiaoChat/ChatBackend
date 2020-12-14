<?php

declare (strict_types=1);
namespace App\Model\Entity;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $user_id 
 * @property int $sex 
 * @property int $age 
 * @property string $birthday 
 * @property string $desc 
 * @property string $mobile 
 * @property string $email 
 * @property string $register_ip 
 * @property string $last_login_ip 
 * @property string $register_time 
 * @property string $last_login_time 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Profile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profile';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'sex',
        'age',
        'birthday',
        'desc',
        'mobile',
        'email',
        'register_ip',
        'last_login_ip',
        'register_time',
        'last_login_time',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'sex' => 'integer', 'age' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}