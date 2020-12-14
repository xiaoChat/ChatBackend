<?php

declare (strict_types=1);
namespace App\Model\Entity;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $msg_type 
 * @property int $user_id 
 * @property string $friend_id 
 * @property string $context 
 * @property string $send_time 
 * @property int $is_read 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'message';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'msg_type',
        'user_id',
        'friend_id',
        'context',
        'send_time',
        'is_read',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'msg_type' => 'integer', 'user_id' => 'integer', 'is_read' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}