<?php

namespace App\Services;

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

                $user = User::find($data['data']['user_id']);

                $uid = $user ? $user->id : 0; // 0 表示未登录的访客用户

                $this->wsTable->set('uid:' . $uid, ['value' => $frame->fd]);// 绑定uid到fd的映射

                $this->wsTable->set('fd:' . $frame->fd, ['value' => $uid]);// 绑定fd到uid的映射

                $server->push($frame->fd, json_encode(['type' => 'init', 'message' => '初始化']));

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
