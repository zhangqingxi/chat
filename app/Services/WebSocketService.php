<?php

namespace App\Services;

use App\Models\FriendChatMessage;
use App\Models\UserFriend;
use App\User;
use Carbon\Carbon;
use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;
use Illuminate\Support\Facades\Log;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class WebSocketService implements WebSocketHandlerInterface
{
    /**@var \Swoole\Table $wsTable */
    private $wsTable;
    public function __construct()
    {
        $this->wsTable = app('swoole')->wsTable;
    }

    public function onOpen(Server $server, \Swoole\Http\Request $request)
    {
        // TODO: Implement onOpen() method.
        Log::info('WebSocket 连接建立');

    }

    public function onMessage(Server $server, Frame $frame)
    {

        // TODO: Implement onMessage() method.
        $data = json_decode($frame->data, true);

        if(is_array($data)){

            if($data['type'] === 'init') {

                if($user = User::find($data['data']['user_id'])){

                    $this->wsTable->set('uid:' . $user->id, ['value' => $frame->fd]);// 绑定uid到fd的映射

                    $this->wsTable->set('fd:' . $frame->fd, ['value' => $user->id]);// 绑定fd到uid的映射

                    $contacts = [];

                    $total_unread_count = 0;

                    foreach ($user->friends as $u){

                        $is_friend_count = UserFriend::where('user_id', $u->friend_id)->where('friend_id', $u->user_id)->count();

                        if($is_friend_count === 0) continue;

                        $nickname = $u->remarks;

                        $avatar = $u->contact->avatar;

                        $friend_id = $u->friend_id;

                        $charter = getFirstCharter($nickname);

                        $contacts[$charter][] = compact('friend_id', 'nickname', 'avatar', 'is_friend_count');

                    }

                    ksort($contacts);

                    //消息面板
                    $chatMessages = $user->chatMessages()->select('user_id')->distinct()->get();

                    $chats = [];

                    foreach ($chatMessages as $chatMessage){

                        if($message = FriendChatMessage::where('user_id', $chatMessage->user_id)->where('friend_id', $user->id)->orderByDesc('created_at')->first()){

                            $message->time = Carbon::parse($message->created_at)->toDateTimeString();

                            if (Carbon::now() < Carbon::parse(time())->addDays(3)) {

                                $message->time = Carbon::parse($message->created_at)->diffForHumans();

                            }

                            $message->unread_counts = FriendChatMessage::where('user_id', $chatMessage->user_id)->where('is_read', 0)->where('friend_id', $user->id)->count();

                            $total_unread_count += $message->unread_counts;

                            //好友信息
                            $message->friend_info = User::where('id', $chatMessage->user_id)->first(['id','avatar']);

                            $message->friend_info->remarks = UserFriend::where('user_id', $user->id)->where('friend_id', $chatMessage->user_id)->value('remarks');

                            $chats[] = $message;

                        }

                    }

                    //二维数组通过key排序
                    $chats = arraySortByKey($chats, 'created_at', 'desc');

                    $server->push($frame->fd, json_encode(['type' => 'init', 'message' => '初始化Socket', 'data' => ['total_unread_count' => $total_unread_count,'contacts' => $contacts, 'chats' => $chats]]));

                }

            }

        }

    }

    public function onClose(Server $server, $fd, $reactorId)
    {
        // TODO: Implement onClose() method.
        $uid = $this->wsTable->get('fd:' . $fd);
        if ($uid) {
            $this->wsTable->del('uid:' . $uid['value'] ?? ''); // 解绑uid映射
        }
        $this->wsTable->del('fd:' . $fd);// 解绑fd映射
        Log::info('WebSocket 连接关闭');
    }
}
