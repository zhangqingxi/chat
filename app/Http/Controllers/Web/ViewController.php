<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class ViewController extends Controller
{

    /**
     * 登陆
     */
    public function login()
    {

        return view('chat.login');

    }

    /**
     * 注册
     */
    public function register()
    {

        return view('chat.register');

    }

    /**
     * 首页
     */
    public function index()
    {

        return view('chat.index');

    }

    /**
     * 个人信息
     */
    public function user()
    {

        return view('chat.user');

    }

    /**
     * 搜索页面
     */
    public function search()
    {

        return view('chat.search');

    }


    /**
     * 搜索用户
     * @param int $uid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function findUserResult(int $uid = 0)
    {

        return view('chat.friend.add', ['uid' => $uid]);

    }

    /**
     * 新朋友
     */
    public function newFriend()
    {

        return view('chat.friend.new');

    }

    /**
     * 好友详情
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function friendDetail(int $id = 0)
    {

        return view('chat.friend.detail', ['uid' => $id]);

    }

    /**
     * 聊天
     * @param int $uid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function chat(int $uid = 0)
    {

        return view('chat.friend.chat', ['uid' => $uid]);

    }

}
