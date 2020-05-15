@extends('chat.common.header')

@section('content')

    <!-- <>微聊主容器 -->
    <div class="wechat__panel clearfix">

        <div class="wc__home-wrapper flexbox flex__direction-column">

            <!-- //顶部 -->
            <div class="wc__headerBar fixed">

                <div class="inner flexbox">

                    <a class="back splitline" href="javascript:void(0);" onclick="history.go(-1);"></a>

                    <h2 class="barTit flex1">个人信息</h2>

                </div>

            </div>

            <!-- //个人信息页 -->
            <div class="wc__ucinfoPanel wc__scrolling-panel">

                <div class="wc__ucinfo-personal">

                    <ul class="clearfix">

                        <li>

                            <div class="item flexbox flex-alignc wc__material-cell">

                                <label class="lbl flex1">头像</label>

                                <img alt="" class="uimg user-avatar" src=""/>

                                <input class="chooseImg" id="avatar" type="file" accept="image/*" />

                            </div>

                            <div class="item user-info-item flexbox flex-alignc wc__material-cell" data-field="chat_no">

                                <label class="lbl flex1">微聊号</label>

                                <div class="val user-chat_no"></div>

                            </div>

                            <div class="item user-info-item flexbox flex-alignc wc__material-cell" data-field="nickname">

                                <label class="lbl flex1">昵称</label>

                                <div class="val user-nickname"></div>

                            </div>

                            <div class="item user-info-item flexbox flex-alignc wc__material-cell" data-field="sex">

                                <label class="lbl flex1">性别</label>

                                <div class="val user-sex"></div>

                            </div>

                            <div class="item user-info-item flexbox flex-alignc wc__material-cell" data-field="signature">

                                <label class="lbl flex1">个性签名</label>

                                <div class="val user-signature"></div>

                            </div>

                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    @include('chat.common.main')

    <script src="{{asset('static/js/ajaxfileupload.js')}}"></script>

@endsection
