@extends('chat.common.header')

@section('content')

<!-- 微聊主容器 -->
<div class="wechat__panel clearfix">

    <div class="wc__home-wrapper flexbox flex__direction-column">

        <!-- //登录页面 -->
        <div class="wc__lgregPanel flex1">

            <h2 class="hdtips">账号注册</h2>

            <div class="forms">

                <form action="#" id="lgregForms">

                    <ul class="clearfix">

                        <li><label class="lbl flexbox"><em>用户账号</em><input class="iptxt flex1" type="text" name="username" autocomplete="off" placeholder="请填写您的账号" /></label></li>

                        <li><label class="lbl flexbox"><em>账号密码</em><input class="iptxt flex1" type="password" name="password" autocomplete="off" placeholder="请填写您的账号密码" /></label></li>

                        <li><label class="lbl flexbox"><em>确认密码</em><input class="iptxt flex1" type="password" name="re-password" autocomplete="off" placeholder="请填写您的账号密码" /></label></li>

                    </ul>

                    <div class="lgway"><a href="{{url('login')}}">已有账号，点击登陆</a></div>

                    <div class="btns register"><a class="wc__btn-primary btn__register" href="javascript:void(0);">注册</a></div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection
