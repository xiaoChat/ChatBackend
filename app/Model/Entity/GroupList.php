<?php

declare (strict_types=1);
namespace App\Model\Entity;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $group_no 
 * @property int $owner_user_id 
 * @property int $type 
 * @property string $name 
 * @property string $avatar 
 * @property string $describe 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class GroupList extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_list';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['group_no', 'owner_user_id', 'type', 'name', 'avatar', 'describe'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'group_no' => 'integer', 'owner_user_id' => 'integer', 'type' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}