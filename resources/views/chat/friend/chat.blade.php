@extends('chat.common.header')

@section('content')

    <!-- <>微聊主容器 -->
    <div class="wechat__panel clearfix">

        <input type="hidden" value="{{$uid ?? 0}}" class="friend_id">

        <img src="" class="user_avatar" style="display: none;" alt="">

        <div class="wc__chat-wrapper flexbox flex__direction-column">

            <!-- //顶部 -->
            <div class="wc__headerBar fixed">

                <div class="inner flexbox">

                    <a class="back splitline" href="javascript:void (0);" onclick="history.back();"></a>

                    <h2 class="barTit flex1 user_remarks"></h2>

                    <a class="barIco u-one" href="{{url('friend/detail/'.$uid)}}"></a>

                </div>

            </div>

            <!-- //微聊消息上墙面板 -->
            <div class="wc__chatMsg-panel flex1" id="chat-msg-container">
                <div class="chatMsg-cnt">
                    <ul class="clearfix" id="J__chatMsgList">
{{--                        <li class="notice"><span>你已经添加了张小龙，现在可以开始聊天了。</span></li>--}}
{{--                        <li class="time"><span>2017年12月31日 晚上22:30</span></li>--}}
{{--                        <!-- 别人-->--}}
{{--                        <li class="others">--}}
{{--                            <a class="avatar" href="好友主页(详细资料).html"><img src="img/uimg/u__chat-img04.jpg" /></a>--}}
{{--                            <div class="content">--}}
{{--                                <div class="msg">--}}
{{--                                    hello 美女，晚上好，最近过的还好吧！！！ <img class="face" src="img/emotion/face01/10.png"><img class="face" src="img/emotion/face01/63.png"><img class="face" src="img/emotion/face01/75.png">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <!--自己-->--}}
{{--                        <li class="me">--}}
{{--                            <div class="content">--}}
{{--                                <div class="msg">--}}
{{--                                    么么哒，张总发个红包呗！<img class="face" src="img/emotion/face01/92.png">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <a class="avatar" href="好友主页(详细资料).html"><img src="img/uimg/u__chat-img14.jpg" /></a>--}}
{{--                        </li>--}}
{{--                        <li class="others">--}}
{{--                            <a class="avatar" href="好友主页(详细资料).html"><img src="img/uimg/u__chat-img04.jpg" /></a>--}}
{{--                            <div class="content">--}}
{{--                                <div class="msg">--}}
{{--                                    晚上好，我还在景区度假呢，去谈了一个项目！ <img class="face" src="img/emotion/face01/61.png">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="others">--}}
{{--                            <a class="avatar" href="好友主页(详细资料).html"><img src="img/uimg/u__chat-img04.jpg" /></a>--}}
{{--                            <div class="content">--}}
{{--                                <div class="msg picture">--}}
{{--                                    <img class="img__pic" src="img/placeholder/wchat__img03.jpg" />--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="time"><span>1月1日 早上02:00</span></li>--}}
{{--                        <li class="others">--}}
{{--                            <a class="avatar" href="好友主页(详细资料).html"><img src="img/uimg/u__chat-img04.jpg" /></a>--}}
{{--                            <div class="content">--}}
{{--                                <div class="msg">--}}
{{--                                    又到了夜深人静的时候，好安静。<img class="face" src="img/emotion/face01/30.png">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="me">--}}
{{--                            <div class="content">--}}
{{--                                <div class="msg">--}}
{{--                                    这么晚还么睡啊！<img class="face" src="img/emotion/face01/74.png">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <a class="avatar" href="好友主页(详细资料).html"><img src="img/uimg/u__chat-img14.jpg" /></a>--}}
{{--                        </li>--}}
{{--                        <li class="me">--}}
{{--                            <div class="content">--}}
{{--                                <div class="msg video">--}}
{{--                                    <img class="img__video" src="img/placeholder/wchat__video01-poster.jpg" videoUrl="img/placeholder/wchat__video01-Y7qk5uVcNcFJIY8O4mKzDw.mp4" />--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <a class="avatar" href="好友主页(详细资料).html">--}}
{{--                                <img src="img/uimg/u__chat-img14.jpg" />--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="time"><span>2月25日 早上09:48</span></li>--}}
{{--                        <li class="others">--}}
{{--                            <a class="avatar" href="好友主页(详细资料).html"><img src="img/uimg/u__chat-img04.jpg" /></a>--}}
{{--                            <div class="content">--}}
{{--                                <div class="msg">--}}
{{--                                    早上好，这次微聊线下活动的视频及PPT预计明天可以公开啦 <img class="face" src="img/emotion/face01/4.png">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="time"><span>"张小龙" 撤回了一条消息</span></li>--}}
{{--                        <li class="others">--}}
{{--                            <a class="avatar" href="好友主页(详细资料).html"><img src="img/uimg/u__chat-img04.jpg" /></a>--}}
{{--                            <div class="content">--}}
{{--                                <div class="msg video">--}}
{{--                                    <img class="img__video" src="img/placeholder/wchat__video02-poster.jpg" videoUrl="img/placeholder/wchat__video02-Y7qk5uVcNcFJIY8O4mKzDw.mp4" />--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="me">--}}
{{--                            <div class="content">--}}
{{--                                <div class="msg picture">--}}
{{--                                    <img class="img__pic" src="img/placeholder/wchat__img01.jpg" />--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <a class="avatar" href="好友主页(详细资料).html"><img src="img/uimg/u__chat-img14.jpg" /></a>--}}
{{--                        </li>--}}
{{--                        <li class="me">--}}
{{--                            <div class="content">--}}
{{--                                <div class="msg">--}}
{{--                                    无聊( ⊙o⊙ )哇，自己爆照一张，我是有多自恋，哈哈哈！<img class="face" src="img/emotion/face01/72.png">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <a class="avatar" href="好友主页(详细资料).html"><img src="img/uimg/u__chat-img14.jpg" /></a>--}}
{{--                        </li>--}}
                    </ul>
                </div>
            </div>

            <!-- //微聊底部功能面板 -->
            <div class="wc__footTool-panel">

                <!-- 输入框模块 -->
                <div class="wc__editor-panel wc__borT flexbox">

                    <div class="wrap-editor flex1"><div class="editor J__wcEditor" contenteditable="true" style="-webkit-user-select:auto;"></div></div>

                    <i class="btn btn-emotion"></i>

                    <i class="btn btn-choose"></i>

                    <button class="btn-submit J__wchatSubmit">发送</button>

                </div>

                <!-- 表情、选择模块 -->
                @include('chat.common.chat-extend')

            </div>

        </div>

    </div>


    <!-- …… 图片预览弹窗.Start -->
    @include('chat.common.image-preview')
    <!-- …… 图片预览弹窗.End -->

    <!-- …… 视频预览弹窗.Start -->
    @include('chat.common.video-preview')
    <!-- …… 视频预览弹窗.End -->

    <!-- …… 表情模板.Start -->
    @include('chat.common.expression')
    <!-- …… 表情模板.End -->

    <!-- …… 红包弹窗模板.Start -->

    <!-- …… 红包弹窗模板.End -->

    @include('chat.common.main')

    <script type="text/javascript">

        let avatar = window.localStorage.getItem('user_avatar');

        // 禁止长按弹出系统菜单
        $(".wechat__panel").on("contextmenu", function(e){

            e.preventDefault();

        });

        // ...滚动聊天区底部
        let wchat_ToBottom = function (){

            $(".wc__chatMsg-panel").animate({scrollTop: $("#J__chatMsgList").height()}, 0);

        };

        // ...点击聊天面板区域
        $('.wc__chatMsg-panel').unbind("click").bind('click', function(e){

            let _tapMenu = $(".wc__chatTapMenu");

            if(_tapMenu.length && e.target !== _tapMenu && !$.contains(_tapMenu[0], e.target)){

                // 关闭长按菜单
                _tapMenu.hide();

                $(".wc__chatMsg-panel").find("li .msg").removeClass("taped");

            }

            $(".wc__choose-panel").hide();

        });

        // ...表情、选择区切换
        $(".wc__editor-panel .btn").unbind("click").bind('click', function(){

            let that = $(this);

            $(".wc__choose-panel").show();

            if (that.hasClass("btn-emotion")) {

                $(".wc__choose-panel .wrap-emotion").show();

                $(".wc__choose-panel .wrap-choose").hide();

                // 初始化swiper表情
                !emotionSwiper && $("#J__emotionFootTab ul li.cur").trigger("click");

            } else if (that.hasClass("btn-choose")) {

                $(".wc__choose-panel .wrap-emotion").hide();

                $(".wc__choose-panel .wrap-choose").show();

            }

            wchat_ToBottom();

        });

        // ...处理编辑器信息
        let $editor = $(".J__wcEditor"), _editor = $editor[0];

        let surrounds = function (){

            setTimeout(function () { //chrome

                let sel = window.getSelection(), anchorNode = sel.anchorNode;

                if (!anchorNode) return;

                if (sel.anchorNode === _editor || (sel.anchorNode.nodeType === 3 && sel.anchorNode.parentNode === _editor)) {

                    let range = sel.getRangeAt(0), p = document.createElement("p");

                    range.surroundContents(p);

                    range.selectNodeContents(p);

                    range.insertNode(document.createElement("br")); //chrome

                    sel.collapse(p, 0);

                    (function clearBr() {

                        let elems = [].slice.call(_editor.children);

                        for (let i = 0, len = elems.length; i < len; i++) {

                            let el = elems[i];

                            if (el.tagName.toLowerCase() === "br") {

                                _editor.removeChild(el);

                            }

                        }

                        elems.length = 0;

                    })();

                }

                wchat_ToBottom();

            }, 10);

        };

        // 格式化编辑器包含标签
        _editor.addEventListener("click", function () {

            $(".wc__choose-panel").hide();

        }, true);

        _editor.addEventListener("focus", function(){

            surrounds();

        }, true);

        _editor.addEventListener("input", function(){

            surrounds();

        }, false);

        let friend_id = $('.friend_id').val() || 0, page = 1;

        //更新消息为已读
        chatMessage(friend_id, page);

        // 点击表情
        $("#J__swiperEmotion").on("click", ".face-list span img", function(){

            let that = $(this), range;

            if(that.hasClass("face")){ //小表情

                let img = that[0].cloneNode(true);

                _editor.focus();

                _editor.blur(); //输入表情时禁止输入法

                setTimeout(function(){

                    if(document.selection && document.selection.createRange){

                        document.selection.createRange().pasteHTML(img);

                    }else if(window.getSelection && window.getSelection().getRangeAt){

                        range = window.getSelection().getRangeAt(0);

                        range.insertNode(img);

                        range.collapse(false);

                        let sel = window.getSelection();

                        sel.removeAllRanges();

                        sel.addRange(range);

                    }

                }, 10);

            }else if(that.hasClass("del")){ //删除

                _editor.focus();

                _editor.blur(); //输入表情时禁止输入法

                setTimeout(function(){

                    range = window.getSelection().getRangeAt(0);

                    range.collapse(false);

                    let sel = window.getSelection();

                    sel.removeAllRanges();

                    sel.addRange(range);

                    document.execCommand("delete");

                }, 10);

            } else if(that.hasClass("lg-face")){ //大表情

                let _img = that.parent().html(),
                     _tpl = [
                        '<li class="me">\
                            <div class="content">\
                                <div class="msg lgface">'+ _img + '</div>\
                            </div>\
                            <a class="avatar" href="javascript:void(0);"><img alt="" src="'+window.localStorage.getItem('user_avatar')+'" /></a>\
                        </li>'
                    ].join("");

                $chatMsgList.append(_tpl);

                //发送消息给用户
                chat(friend_id, _img, 2);

                wchat_ToBottom();

            }

        });

        // 发送信息
        let $chatMsgList = $("#J__chatMsgList");

        let isEmpty = function (){

            let html = $editor.html();

            html = html.replace(/<br[\s\/]{0,2}>/ig, "\r\n");

            html = html.replace(/<[^img].*?>/ig, "");

            html = html.replace(/&nbsp;/ig, "");

            html = html.replace(/\r\n|\n|\r/, "").replace(/(?:^[ \t\n\r]+)|(?:[ \t\n\r]+$)/g, "");

            return html === "";

        };

        let scrollEvent = function (domId, callbackFunc) {
            var dom = document.getElementById(domId);
            var scrollFunc = function(e) {
                var direct = 0;
                e = e || window.event;

                if (e.wheelDelta) {//IE/Opera/Chrome
                    if (e.wheelDelta > 0) {
                        direct = -1;
                    } else {
                        direct = 1;
                    }
                } else if (e.detail) {//Firefox
                    if (e.detail > 0) {
                        direct = 1;
                    } else {
                        direct = -1;
                    }
                }
                if (callbackFunc) {
                    callbackFunc(direct);
                }
            };
            /*注册事件*/
            if (dom.addEventListener) {
                dom.addEventListener('DOMMouseScroll', scrollFunc, false);
            }
            dom.onmousewheel = scrollFunc;//IE/Opera/Chrome
        };

        scrollEvent("chat-msg-container", function(data) {

            if (data === 1) {//向下

            } else {

                if($('#chat-msg-container').offset().top === 50){//顶部

                    chatMessage(friend_id, ++page);

                }

            }

        });

        //发送消息
        $(".J__wchatSubmit").unbind("click").bind('click', function(){

            // 判断内容是否为空
            if(isEmpty()) return;

            let html = $editor.html(), reg = /(http:\/\/|https:\/\/)((\w|=|\?|\.|\/|&|-)+)/g;

            let msgTpl = [
                '<li class="me">\
                    <div class="content">\
                        <div class="msg">'+ html +'</div>\
                    </div>\
                    <a class="avatar" href="javascript:void(0);"><img alt="" src="'+window.localStorage.getItem('user_avatar')+'" /></a>\
                </li>'
            ].join("");

            $chatMsgList.append(msgTpl);

            //发送消息给用户
            chat(friend_id, html);

            // 清空聊天框并获取焦点（处理输入法和表情 - 聚焦）
            if(!$(".wc__choose-panel").is(":hidden")){

                $editor.html("");

            }else{

                $editor.html("").focus().trigger("click");

            }

            wchat_ToBottom();

        });

    </script>

@endsection
