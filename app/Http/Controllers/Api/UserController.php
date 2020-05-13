<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends BaseController
{

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

            /**@var User $user*/
            $user = auth()->user();

            switch ($field){

                case 'chat_no':

                    if($user->$field === $value){

                        throw new ApiException(USER_CHAT_NO_NOT_UPDATE_ERROR_MSG, USER_CHAT_NO_NOT_UPDATE_ERROR_CODE);

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
                'chat_no'  => $request->input('username'),
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
