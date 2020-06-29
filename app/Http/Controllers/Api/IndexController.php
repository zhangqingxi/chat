<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Models\FriendChatMessage;
use App\Models\UserFriend;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class IndexController extends BaseController
{


    public function test()
    {

        $user = User::find(1);

        $contacts = [];

        $total_unread_count = 0;

        foreach ($user->friends as $u) {

            $is_friend_count = UserFriend::where('user_id', $u->friend_id)->where('friend_id', $u->user_id)->count();

            if ($is_friend_count === 0) continue;

            $nickname = $u->remarks;

            $avatar = $u->contact->avatar;

            $friend_id = $u->friend_id;

            $charter = getFirstCharter($nickname);

            $contacts[$charter][] = compact('friend_id', 'nickname', 'avatar', 'is_friend_count');

        }

        ksort($contacts);

        //消息面板
//                    select id,user_id,friend_id, distinct(IF(`user_id` = 1, concat(`user_id`, `friend_id`), concat(`friend_id`, `user_id`))) from `chat_friend_chat_messages` where `user_id` = 1 or friend_id = 1  order by created_at desc;
//                    $chatMessages = FriendChatMessage::where(['user_id' => $user->id])->orWhere('friend_id', $user->id)->groupByRaw('IF(`user_id` = ?, concat(`user_id`, `friend_id`), concat(`friend_id`, `user_id`)', [$user->id])->get();

        $chatMessages = $user->chatMessages()->groupBy(['user_id', 'friend_id'])->get();

        $chats = [];

        foreach ($chatMessages as $chatMessage) {

            if ($message = FriendChatMessage::where('user_id', $chatMessage->user_id)->where('friend_id', $user->id)->orderByDesc('created_at')->first()) {

                $message->time = Carbon::parse($message->created_at)->toDateTimeString();

                if (Carbon::now() < Carbon::parse(time())->addDays(3)) {

                    $message->time = Carbon::parse($message->created_at)->diffForHumans();

                }

                $message->unread_counts = FriendChatMessage::where('user_id', $chatMessage->user_id)->where('is_read', 0)->where('friend_id', $user->id)->count();

                $total_unread_count += $message->unread_counts;

                //好友信息
                $message->friend_info = User::where('id', $chatMessage->user_id)->first(['id', 'avatar']);

                $message->friend_info->remarks = UserFriend::where('user_id', $user->id)->where('friend_id', $chatMessage->user_id)->value('remarks');

                $chats[] = $message;

            }

        }

        //二维数组通过key排序
        $chats = arraySortByKey($chats, 'created_at', 'desc');

        print_r(['total_unread_count' => $total_unread_count, 'contacts' => $contacts, 'chats' => $chatMessages]);

    }

}
