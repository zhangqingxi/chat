<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserFriend
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFriend newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFriend newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFriend query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id 用户ID
 * @property int $friend_id 好友id
 * @property string $remarks 备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFriend whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFriend whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFriend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFriend whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFriend whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFriend whereUserId($value)
 * @property-read \App\User $friend
 */
class UserFriend extends Model
{

    protected $fillable = [
        'user_id', 'friend_id', 'remarks'
    ];


    protected $hidden = [
        'created_at', 'updated_at',
    ];


    /**
     * 申请者信息
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function friend()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * 好友信息
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(User::class, 'friend_id', 'id');
    }

}
