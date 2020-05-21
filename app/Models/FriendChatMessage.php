<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FriendChatMessage
 *
 * @property int $id
 * @property int $user_id 用户ID
 * @property int $friend_id 好友id
 * @property string $content 聊天内容
 * @property int $content_type 内容类型 0文本 1语音 2图片 3视频 4表情
 * @property int $is_read 是否已读 0未读 1已读
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $contact
 * @property-read \App\User $friend
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FriendChatMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FriendChatMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FriendChatMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FriendChatMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FriendChatMessage whereContentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FriendChatMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FriendChatMessage whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FriendChatMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FriendChatMessage whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FriendChatMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FriendChatMessage whereUserId($value)
 * @mixin \Eloquent
 */
class FriendChatMessage extends Model
{

    protected $fillable = [
        'user_id', 'friend_id', 'content', 'content_type', 'is_read'
    ];


    protected $hidden = [
        'updated_at',
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
