@extends('chat.common.header')

@section('content')

<!-- 微聊主容器 -->
<div class="wechat__panel clearfix">

    <div class="wc__home-wrapper flexbox flex__direction-column">

        <!-- //登录页面 -->
        <div class="wc__lgregPanel flex1">

            <h2 class="hdtips">微聊号/账号登录</h2>

            <div class="forms">

                <form action="#" id="lgregForms">

                    <ul class="clearfix">

                        <li><label class="lbl flexbox"><em>用户账号</em><input class="iptxt flex1" type="text" name="username" autocomplete="off" placeholder="请填写微聊号/账号" /></label></li>

                        <li><label class="lbl flexbox"><em>账号密码</em><input class="iptxt flex1" type="password" name="password" autocomplete="off" placeholder="请填写密码" /></label></li>

                    </ul>

                    <div class="lgway"><a href="{{url('register')}}">没有账号，点击注册</a></div>

                    <div class="btns login"><a class="wc__btn-primary btn__login" href="javascript:void(0);">登录</a></div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection
