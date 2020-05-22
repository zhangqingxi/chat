<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Models\FriendChatMessage;
use App\Models\UserFriend;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Storage;
use Swoole\WebSocket\Server;

class FriendController extends BaseController
{

    /**
     * 新好友申请列表
     */
    public function apply()
    {

        try {

            /**@var User $user */
            $user = auth()->user();

            $friend_users = UserFriend::with('friend')->where('friend_id', $user->id)->orderBy('id', 'desc')->get();

            foreach ($friend_users as $k => $u){

                $friend_users[$k]['is_friend_count'] = UserFriend::where('user_id', $u->friend_id)->where('friend_id', $u->user_id)->count();

            }

            return json(RESPONSE_SUCCESS_CODE, '获取数据列表成功', ['lists' => $friend_users]);

        } catch (ValidationException $e) {

            return json(REQUEST_PARAMS_VALIDATE_ERROR_CODE, array_values($e->errors())[0][0]);

        } catch (ApiException $e) {

            return json($e->getCode(), $e->getMessage());

        } catch (Exception $e) {

            return json(RESPONSE_SERVER_EXCEPTION_CODE, RESPONSE_SERVER_EXCEPTION_MSG, ['exception_message' => $e->getMessage()]);

        }

    }

    /**
     * 添加好友
     */
    public function add(Request $request)
    {

        try {

            $this->validate($request, [
                'chat_no' => 'required',
            ], [
                'chat_no.required' => '微聊号不能为空',
            ]);

            $chat_no = $request->input('chat_no');

            /**@var User $user */
            $user = auth()->user();

            $friend_user = User::whereChatNo($chat_no)->first(['id', 'nickname', 'username']);

            //没有此微聊号
            if(!$friend_user){

                throw new ApiException(NOT_FIND_CHAT_NO_MSG, NOT_FIND_CHAT_NO_CODE);

            }

            //不能添加自己为好友
            if($friend_user->id === $user->id){

                throw new ApiException(YOU_CAN_NOT_ADD_YOURSELF_AS_FRIEND_MSG, YOU_CAN_NOT_ADD_YOURSELF_AS_FRIEND_CODE);

            }

            //添加还有
            $userFriend = UserFriend::firstOrCreate([
                'user_id' => $user->id,
                'friend_id' => $friend_user->id,
                'remarks' => $friend_user->nickname ?: $friend_user->username

            ]);

            //给好友发送消息通知
            $server = app('swoole');

            $table = $server->wsTable->get('uid:' . $userFriend->friend_id);

            if($table && isset($table['value']) && $server->isEstablished($fd = $table['value'])) {

                $server->push($fd, json_encode(['type' => 'add_friend', 'message' => '收到来自'.($user->nickname ?: $user->username).'的好友申请']));

            }

            return json(RESPONSE_SUCCESS_CODE, '发送申请成功');

        } catch (ValidationException $e) {

            return json(REQUEST_PARAMS_VALIDATE_ERROR_CODE, array_values($e->errors())[0][0]);

        } catch (ApiException $e) {

            return json($e->getCode(), $e->getMessage());

        } catch (Exception $e) {

            return json(RESPONSE_SERVER_EXCEPTION_CODE, RESPONSE_SERVER_EXCEPTION_MSG, ['exception_message' => $e->getMessage()]);

        }

    }


    /**
     * 验证好友
     */
    public function verify(Request $request)
    {

        try {

            $id = $request->input('id');

            $type = $request->input('type');

            /**@var User $user */
            $user = auth()->user();

            //是否存在此好友申请
            $userFriend = UserFriend::whereFriendId($user->id)->find($id);

            //没有此申请记录
            if(!$userFriend){

                throw new ApiException(NOT_FIND_FRIEND_APPLY_MSG, NOT_FIND_FRIEND_APPLY_CODE);

            }

            $friend_user = User::whereId($userFriend->user_id)->first(['id', 'nickname', 'username']);

            if(!$friend_user){

                throw new ApiException(FRIEND_NOT_EXIST_MSG, FRIEND_NOT_EXIST_CODE);

            }

            if($type && UserFriend::where('user_id', $userFriend->friend_id)->where('friend_id', $userFriend->user_id)->count() === 0){

                $userFriend->delete();

                return json(REFUSED_FRIEND_APPLY_CODE, REFUSED_FRIEND_APPLY_MSG);

            }

            //添加还有
            $userFriend = UserFriend::firstOrCreate([
                'user_id' => $userFriend->friend_id,
                'friend_id' => $userFriend->user_id,
                'remarks' => $friend_user->nickname ?: $friend_user->username
            ]);

            //给好友发送消息通知
            $server = app('swoole');

            $table = $server->wsTable->get('uid:' . $userFriend->friend_id);

            if($table && isset($table['value']) && $server->isEstablished($fd = $table['value'])) {

                $server->push($fd, json_encode(['type' => 'add_friend', 'message' => ($user->nickname ?: $user->username).'已通过您的好友申请']));

            }

            return json(RESPONSE_SUCCESS_CODE, '添加好友成功');

        } catch (ApiException $e) {

            return json($e->getCode(), $e->getMessage());

        } catch (Exception $e) {

            return json(RESPONSE_SERVER_EXCEPTION_CODE, RESPONSE_SERVER_EXCEPTION_MSG, ['exception_message' => $e->getMessage()]);

        }

    }

    /**
     * 更新备注
     */
    public function remarks(Request $request)
    {

        try {

            $this->validate($request, [
                'remarks' => 'required',
            ], [
                'remarks.required' => '备注信息不能为空',
            ]);

            $remarks = $request->input('remarks');

            $friend_id = $request->input('friend_id');

            $friend_user = User::find($friend_id);

            //用户不存在
            if(!$friend_user){

                throw new ApiException(FRIEND_NOT_EXIST_MSG, FRIEND_NOT_EXIST_CODE);

            }

            /**@var User $user */
            $user = auth()->user();

            //是否存在此好友申请
            $userFriend = UserFriend::where('user_id', $user->id)->where('friend_id', $friend_id)->first();

            //不是你的好友
            if(!$userFriend){

                throw new ApiException(FRIEND_NOT_EXIST_ON_CONTACT_MSG, FRIEND_NOT_EXIST_ON_CONTACT_CODE);

            }

            $userFriend->remarks = $remarks;

            $userFriend->save();

            if(!$userFriend->wasChanged('remarks')){

                throw new ApiException(FRIEND_REMARKS_SAVE_FAIL_MSG, FRIEND_REMARKS_SAVE_FAIL_CODE);

            }

            return json(RESPONSE_SUCCESS_CODE, '修改备注成功');

        } catch (ValidationException $e) {

            return json(REQUEST_PARAMS_VALIDATE_ERROR_CODE, array_values($e->errors())[0][0]);

        } catch (ApiException $e) {

            return json($e->getCode(), $e->getMessage());

        } catch (Exception $e) {

            return json(RESPONSE_SERVER_EXCEPTION_CODE, RESPONSE_SERVER_EXCEPTION_MSG, ['exception_message' => $e->getMessage()]);

        }

    }


    /**
     * 聊天
     */
    public function chat(Request $request)
    {

        try {

            $this->validate($request, [
                'content' => 'required',
            ], [
                'content.required' => '聊天内容不能为空',
            ]);

            $content = $request->input('content');

            $content_type = $request->input('type');

            //这个ID是好友ID
            $uid = $request->input('uid');

            $friend_user = User::find($uid);

            //用户不存在
            if(!$friend_user){

                throw new ApiException(FRIEND_NOT_EXIST_MSG, FRIEND_NOT_EXIST_CODE);

            }

            //未读消息条数
            $unreadMessageCount = $friend_user->chatMessages->where('is_read', 0)->count();

            /**@var User $user */
            $user = auth()->user();

            $friend_user = UserFriend::where('friend_id', $user->id)->where('user_id',  $uid)->first();

            //不是你的好友
            if(!$friend_user){

                throw new ApiException(FRIEND_NOT_EXIST_ON_CONTACT_MSG, FRIEND_NOT_EXIST_ON_CONTACT_CODE);

            }

            $friendChatMessage = FriendChatMessage::create([

                'user_id' => $user->id,

                'friend_id' => $friend_user->user_id,

                'content' => $content,

                'content_type' => $content_type,

            ]);

            if(!$friendChatMessage->wasRecentlyCreated){

                throw new ApiException(SEND_CHAT_MESSAGE_FAIL_MSG, SEND_CHAT_MESSAGE_FAIL_CODE);

            }

            $unreadMessageCount ++;

            //给好友发送消息通知
            $server = app('swoole');

            $table = $server->wsTable->get('uid:' . $friend_user->user_id);

            if($table && isset($table['value']) && $server->isEstablished($fd = $table['value'])) {

                $time = Carbon::parse()->diffForHumans();

                $server->push($fd, json_encode(['type' => 'friend_chat', 'message' => '收到来自'.($user->nickname ?: $user->username).'聊天消息', 'data' => ['avatar' => $user->avatar, 'friend_id' => $user->id, 'remarks' => $friend_user->remarks, 'aa' => $friend_user, 'content' => $content, 'counts' => $unreadMessageCount, 'time' => $time, 'type' => $content_type]]));

            }

            return json(RESPONSE_SUCCESS_CODE, '发送消息成功');

        } catch (ValidationException $e) {

            return json(REQUEST_PARAMS_VALIDATE_ERROR_CODE, array_values($e->errors())[0][0]);

        } catch (ApiException $e) {

            return json($e->getCode(), $e->getMessage());

        } catch (Exception $e) {

            return json(RESPONSE_SERVER_EXCEPTION_CODE, RESPONSE_SERVER_EXCEPTION_MSG, ['exception_message' => $e->getMessage()]);

        }

    }

    /**
     * 聊天消息
     */
    public function messages(Request $request)
    {

        try {

            //这个ID是好友ID
            $uid = $request->input('uid');

            $friend_user = User::find($uid);

            //用户不存在
            if(!$friend_user){

                throw new ApiException(FRIEND_NOT_EXIST_MSG, FRIEND_NOT_EXIST_CODE);

            }

            /**@var User $user */
            $user = auth()->user();

            $friend_user = UserFriend::where('friend_id', $user->id)->where('user_id',  $uid)->first();

            //不是你的好友
            if(!$friend_user){

                throw new ApiException(FRIEND_NOT_EXIST_ON_CONTACT_MSG, FRIEND_NOT_EXIST_ON_CONTACT_CODE);

            }

            $messages = FriendChatMessage::where(['user_id' => $user->id, 'friend_id' => $friend_user->user_id])->orWhereRaw('(`user_id` = ? and `friend_id` = ?)', [$friend_user->user_id, $user->id])->orderByDesc('created_at')->paginate(10);

            if(!$messages->items() && $request->input('page') !== 1){

                throw new ApiException(NO_HAVE_MORE_MESSAGE_MSG, NO_HAVE_MORE_MESSAGE_CODE);

            }

            foreach ($messages as $message){

                $message->time = Carbon::parse($message->created_at)->toDateTimeString();

                if (Carbon::now() < Carbon::parse(time())->addDays(3)) {

                    $message->time = Carbon::parse($message->created_at)->diffForHumans();

                }

                //我发的消息
                if($message->user_id === $user->id){

                    $message->mine = true;

                    $info['id'] = $user->id;

                    $info['avatar'] = $user->avatar;

                    $info['remarks'] = '';

                }else{

                    $message->mine = false;

                    $info['id'] = $message->user_id;

                    $info['avatar'] = User::where('id', $message->user_id)->value('avatar');

                    $info['remarks'] = UserFriend::where('user_id', $user->id)->where('friend_id', $message->user_id)->value('remarks');

                }

                $message->user = $info;

            }

            //更新未读消息为已读
            FriendChatMessage::where('user_id', $friend_user->user_id)->where('friend_id', $user->id)->where('is_read', 0)->update(['is_read' => 1]);

            return json(RESPONSE_SUCCESS_CODE, '获取聊天数据成功', ['messages' => $messages->items()]);

        } catch (ApiException $e) {

            return json($e->getCode(), $e->getMessage());

        } catch (Exception $e) {

            return json(RESPONSE_SERVER_EXCEPTION_CODE, RESPONSE_SERVER_EXCEPTION_MSG, ['exception_message' => $e->getMessage(), 'message' => $e->getMessage()]);

        }

    }

    public function test()
    {

        echo 4112111;
//        $chatMessages = FriendChatMessage::where(['user_id' => 1])->orWhere('friend_id', 1)->groupBy('user_id')->get();
//
//        print_r($chatMessages);
    }

}
