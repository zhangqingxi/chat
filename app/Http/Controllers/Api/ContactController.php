<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use phpDocumentor\Reflection\Types\Compound;
use Storage;

class ContactController extends BaseController
{

    /**
     * 添加好友到通讯录
     */
    public function add(Request $request)
    {

        try {

            $this->validate($request, [
                'keyword' => 'required',
            ], [
                'keyword.required' => '搜索词不能为空',
            ]);

            $keyword = $request->input('keyword');

            /**@var User $user */
            $user = auth()->user();

            //好友
            $friends = [];

            //群聊
            $groupChats = [];

            //查找好友
            $uid = User::where('id', '<>', $user->id)->where('chat_no', $keyword)->orWhere('username', $keyword)->orWhere('nickname', $keyword)->value('id') ?: '';

            return json(RESPONSE_SUCCESS_CODE, '获取用户搜索结果成功', compact('friends', 'groupChats', 'uid'));

        } catch (ValidationException $e) {

            return json(REQUEST_PARAMS_VALIDATE_ERROR_CODE, array_values($e->errors())[0][0]);

        } catch (Exception $e) {

            return json(RESPONSE_SERVER_EXCEPTION_CODE, RESPONSE_SERVER_EXCEPTION_MSG, ['exception_message' => $e->getMessage()]);

        }

    }

    /**
     * 更新用户信息
     */
    public function update(Request $request)
    {

        try {

            $this->validate($request, [
                'value' => 'required',
            ], [
                'value.required' => '值不能为空',
            ]);

            $field = $request->input('field');

            $value = $request->input('value');

            /**@var User $user */
            $user = auth()->user();

            switch ($field) {

                case 'chat_no':

                    if ($user->$field === $value) {

                        throw new ApiException(USER_CHAT_NO_NOT_UPDATE_ERROR_MSG, USER_CHAT_NO_NOT_UPDATE_ERROR_CODE);

                    }

                    break;

                case 'sex':

                    $value = $value === '女' ? 1 : 0;

                    break;

                case 'avatar':

                    list(2 => $type, 'mime' => $mime) = getimagesize($value);

                    if (!in_array($type, [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG])) {

                        throw new ApiException(NOT_ALLOW_UPLOAD_FILE_FORMAT_MSG, NOT_ALLOW_UPLOAD_FILE_FORMAT_CODE);

                    }

                    //文件后缀
                    $ext = image_type_to_extension($type);

                    preg_match('/^(data:\s*image\/(\w+);base64,)/', $value, $matches);

                    if (isset($matches[2])) {

                        $image = base64_decode(str_replace($matches[1],'', $value));

                        $value = $filename = './uploads/avatar/'.md5(generateRandom()).$ext;

                        Storage::disk('public')->put($filename, $image);

                    } else {

                        throw new ApiException(FILE_UPLOAD_FAIL_MSG, FILE_UPLOAD_FAIL_CODE);

                    }

                    break;

            }

            $user->$field = $value;

            $user->save();

            return json(RESPONSE_SUCCESS_CODE, '修改成功');

        } catch (ValidationException $e) {

            return json(REQUEST_PARAMS_VALIDATE_ERROR_CODE, array_values($e->errors())[0][0]);

        } catch (ApiException $e) {

            return json($e->getCode(), $e->getMessage());

        } catch (Exception $e) {

            return json(RESPONSE_SERVER_EXCEPTION_CODE, RESPONSE_SERVER_EXCEPTION_MSG, ['exception_message' => $e->getMessage()]);

        }

    }

    /**
     * 登陆
     */
    public function register(Request $request)
    {

        try {

            $this->validate($request, [
                'username' => 'required|min:3|max:10',
                'password' => 'required|min:6|max:16',
            ], [
                'username.required' => '用户名不能为空',
                'username.min' => '用户名长度最少3个字符',
                'username.max' => '用户名长度最多10个字符',
                'password.required' => '密码不能为空',
                'password.min' => '密码长度最少6个字符',
                'password.max' => '密码长度最多16个字符',
            ]);

            $user = User::create([
                'username' => $request->input('username'),
                'password' => bcrypt($request->input('password')),
                'chat_no' => $request->input('username'),
            ]);

            $token = $user->createToken('chatForToken')->accessToken;

            return json(RESPONSE_SUCCESS_CODE, '注册成功', ['token' => $token]);

        } catch (ValidationException $e) {

            return json(REQUEST_PARAMS_VALIDATE_ERROR_CODE, array_values($e->errors())[0][0]);

        } catch (Exception $e) {

            return json(RESPONSE_SERVER_EXCEPTION_CODE, RESPONSE_SERVER_EXCEPTION_MSG, ['exception_message' => $e->getMessage()]);

        }

    }

}
