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

}
