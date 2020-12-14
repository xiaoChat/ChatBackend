<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Friend extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'friends';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'friend_id',
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'friend_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
