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

            //好友 ==> 我 互为好友
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
        $chatMessages = FriendChatMessage::where(['user_id' => $user->id])->orWhere('friend_id', $user->id)->orderBy('id', 'desc')->select(['id','user_id','friend_id','content','created_at'])->selectRaw('IF(`user_id` = 1, concat(`user_id`, `friend_id`), concat(`friend_id`, `user_id`)) as group_key')->get();

        //去重
        $chatMessages = array_unset_by_key($chatMessages, 'group_key');

        foreach ($chatMessages as $chatMessage) {

            $chatMessage->time = Carbon::parse($chatMessage->created_at)->toDateTimeString();

            if (Carbon::now() < Carbon::parse(time())->addDays(3)) {

                $chatMessage->time = Carbon::parse($chatMessage->created_at)->diffForHumans();

            }

            //好友对我发送的消息
            if($chatMessage->friend_id === $user->id) {

                $chatMessage->unread_counts = $a = FriendChatMessage::where('friend_id', $user->id)->where('user_id', $chatMessage->user_id)->where('is_read', 0)->count();

                $total_unread_count += $chatMessage->unread_counts;

                //好友对我发送的消息
                $chatMessage->unread_counts = $a = FriendChatMessage::where('friend_id', $user->id)->where('user_id', $chatMessage->user_id)->where('is_read', 0)->count();

                $total_unread_count += $chatMessage->unread_counts;

            } else {

                //好友信息
                $chatMessage->friend_info = User::where('id', $chatMessage->friend_id)->first(['id', 'avatar']);

                $chatMessage->friend_info->remarks = UserFriend::where('user_id', $user->id)->where('friend_id', $chatMessage->friend_id)->value('remarks');

            }

        }

        print_r($chatMessages);
//
//        //二维数组通过key排序
//        $chats = arraySortByKey($chats, 'created_at', 'desc');
//
//        print_r(['total_unread_count' => $total_unread_count, 'contacts' => $contacts, 'chats' => $chatMessages]);

    }

}
