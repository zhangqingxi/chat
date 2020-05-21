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

                                    <div style="display: inline-block"><em class="user-nickname" style="font-size: 18px"></em>&nbsp;<img alt="" class="user-sex-img" style="height: 18px;width: 18px;" src=""/></div><i>微聊号：<span class="user-chat_no"></span></i>

                                </label>

                            </div>

                        </li>

                        <li>

                            <div class="item flexbox flex-alignc wc__material-cell">

                                <label class="lbl">备注</label>

                                <div class="cnt flex1 c-999 user_remarks"></div>

                            </div>

                            <div class="item flexbox flex-alignc wc__material-cell">

                                <label class="lbl">个人相册</label>

                                <div class="cnt flex1">

{{--                                    <img src="img/placeholder/wcZone-img01.jpg" /><img src="img/placeholder/wchat__img01.jpg" />--}}

                                </div>

                            </div>

                            <div class="item flexbox flex-alignc wc__material-cell">

                                <label class="lbl">个性签名</label>

                                <div class="cnt flex1 c-999 user-signature"></div>

                            </div>

                        </li>

                    </ul>

                </div>

                <div class="wc__btns-panel">

                    <input type="hidden" value="{{$uid ?? 0}}" class="friend_id">

                    <a class="wc__btn-primary" href="{{url('chat/'.$uid)}}">发消息</a>

{{--                    <a class="wc__btn-default mt20" href="javascript:void (0);">视频聊天</a>--}}

                </div>

            </div>

        </div>

    </div>

    @include('chat.common.main')

@endsection
