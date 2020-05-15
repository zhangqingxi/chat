@extends('chat.common.header')

@section('content')

    <!-- <>微聊主容器 -->
    <div class="wechat__panel clearfix">

        <div class="wc__home-wrapper flexbox flex__direction-column">
            <!-- //顶部 -->
            <div class="wc__headerBar fixed">

                <div class="inner flexbox">

                    <a class="back splitline" href="javascript:void (0);" onclick="history.back();"></a>

                    <h2 class="barTit flex1">详细资料</h2>

                </div>

            </div>

            <!-- //好友详细资料页 -->
            <div class="wc__ucinfoPanel">

                <div class="wc__ucinfo-detail">

                    <ul class="clearfix" id="J__ucinfoPanel">

                        <li>

                            <div class="item flexbox flex-alignc wc__material-cell">

                                <img alt="" class="uimg user-avatar" src=""/>

                                <label class="lbl flex1">

                                    <div style="display: inline-block"><em class="user-nickname" style="font-size: 18px"></em>&nbsp;<img alt="" class="" style="height: 18px;width: 18px;" src="{{asset('demo/img/boy.png')}}"/></div><i>微聊号：<span class="user-chat_no"></span></i>

                                </label>

                            </div>

                        </li>

                        <li>

                            <div class="item flexbox flex-alignc wc__material-cell">

                                <label class="lbl">个性签名</label>

                                <div class="cnt flex1 c-999 user-signature"></div>

                            </div>

                        </li>

                    </ul>

                </div>

                <div class="wc__btns-panel">

                    <a class="wc__btn-primary add-contact" href="javascript:void (0);">添加到通讯录</a>

                </div>

            </div>

        </div>

    </div>

    @include('chat.common.main')

@endsection
