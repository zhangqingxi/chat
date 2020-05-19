<?php

namespace App\Services;

use App\Models\UserFriend;
use App\User;
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

                    $server->push($frame->fd, json_encode(['type' => 'init', 'message' => '初始化Socket', 'data' => ['contacts' => $contacts]]));

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
