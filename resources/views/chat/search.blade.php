@extends('chat.common.header')

@section('content')

    <style>
        ::-webkit-input-placeholder { /* WebKit browsers */
            color: #FFF;
            font-size: 16px;
        }

        ::-moz-placeholder { /* Mozilla Firefox 19+ */
            color: #FFF;
            font-size: 16px;
        }

        :-ms-input-placeholder { /* Internet Explorer 10+ */
            color: #FFF;
            font-size: 16px;
        }
    </style>

    <!-- <>微聊主容器 -->
    <div class="wechat__panel clearfix">

        <div class="wc__home-wrapper flexbox flex__direction-column">

            <!-- //顶部 -->
            <div class="wc__headerBar fixed">

                <div class="inner flexbox">

                    <label for="search"></label><input id="search" type="text" class="search" style="text-align: left;width: 80%;color:#fff;font-size: 17px;border: 1px solid #ffd100;text-indent: 35px;" placeholder="请输入您要搜索的内容">

                    <span style="font-size: 18px;padding-left: 5%; padding-top: 12px;color: #fff" onclick="history.back()">取消</span>

                </div>

            </div>

            <div class="wc__scrolling-panel">

                <div class="wc__addrFriend-list search-result">

                    <ul class="clearfix contact" style="margin-top: 10px;display: none;">

                        <li>

                            <h2 class="initial wc__borT">联系人</h2>

                            <div class="row flexbox flex-alignc wc__material-cell">

                                <img class="uimg" alt="" src="{{asset('static/img/uimg/u__chat-img09.jpg')}}"/>

                                <span class="name flex1">Aster</span>

                            </div>

                            <div class="row flexbox flex-alignc wc__material-cell">

                                <img class="uimg" alt="" src="{{asset('static/img/uimg/u__chat-img01.jpg')}}"/>

                                <span class="name flex1">Alibaba-马云</span>

                            </div>

                        </li>

                    </ul>

                    <ul class="clearfix group_chat" style="margin-top: 10px;display: none;">

                        <li>

                            <h2 class="initial wc__borT">群聊</h2>

                            <div class="row flexbox flex-alignc wc__material-cell">

                                <img class="uimg" alt="" src="{{asset('static/img/uimg/u__chat-img09.jpg')}}"/>

                                <span class="name flex1">Aster</span>

                            </div>

                            <div class="row flexbox flex-alignc wc__material-cell">

                                <img class="uimg" alt="" src="{{asset('static/img/uimg/u__chat-img01.jpg')}}"/>

                                <span class="name flex1">Alibaba-马云</span>

                            </div>

                        </li>

                    </ul>

                    <ul class="clearfix find-user" style="margin-top: 10px;display: none;">

                        <li>

                            <div class="row flexbox flex-alignc wc__material-cell">

                                <img class="uimg" alt="" src="{{asset('static/img/icon__addrFriend-img01.jpg')}}"/>

                                <span class="name flex1">查找微聊号/昵称：<span class="value"></span></span>

                            </div>

                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    @include('chat.common.main')

@endsection
