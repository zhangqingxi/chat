<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Models\UserFriend;
use App\User;
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

            /**@var User $user */
            $user = auth()->user();

            //是否存在此好友申请
            $userFriend = UserFriend::where('user_id', $user->id)->where('friend_id', $friend_id)->first();

            //没有此申请记录
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

}
