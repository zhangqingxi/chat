@extends('chat.common.header')

@section('content')

    <!-- 微聊主容器 -->
    <div class="wechat__panel clearfix">

        <div class="wc__home-wrapper flexbox flex__direction-column">

            <!-- //顶部 -->
            <div class="wc__headerBar fixed">

                <div class="inner flexbox">

                    <!--最新未读消息-->
                    <h2 class="barTit barTitLg flex1">微聊<span class="total_unread"><em class="ff-ar"></em></span></h2>

                    <a class="barIco sear" href="{{url('search')}}"></a>

                    <a class="barIco add" href="javascript:void(0);" id="J__topbarAdd"></a>

                </div>

            </div>

            <!-- //4个tabBar滑动切换 -->
            <div class="wc__swiper-tabBar flex1">

                <div class="swiper-container">

                    <div class="swiper-wrapper">

                        <!-- //1、）微聊主页-->
                        @include('chat.common.chat')

                        <!-- //2、通讯录-->
                        @include('chat.common.contact')

                        <!-- //3、探索-->
                        @include('chat.common.explore')

                        <!-- //4、我-->
                        @include('chat.common.mine')

                    </div>

                </div>

            </div>

            <!-- //底部tabbar -->
            @include('chat.common.footer')

        </div>

    </div>

    <!-- …… 顶部快捷弹窗.Start -->
    <div class="wc__popup-topbar" id="J__popupTopBar">

        <div class="wrap__topbar-mask"></div>

        <div class="wrap__topbar-menu">

            <ul class="clearfix animated anim-zoomInDownSmall">

                <li class="wc__material-cell"><i class="ico i1"></i><span>发起群聊</span></li>

                <li class="wc__material-cell"><i class="ico i2"></i><span>添加朋友</span></li>

{{--                <li class="wc__material-cell"><i class="ico i3"></i><span>帮助与反馈</span></li>--}}
            </ul>

        </div>

    </div>

    @include('chat.common.main')

    <script>

        $(function () {

            // 顶部添加按钮
            $(".wc__headerBar").on("click", "#J__topbarAdd", function () {
                $("#J__popupTopBar").show();
            });
            $("#J__popupTopBar").on("click", ".wrap__topbar-mask", function () {
                $(this).parent().hide();
            });
            // 禁止长按弹出系统菜单
            $(".wechat__panel").on("contextmenu", function(e){
                e.preventDefault();
            });

        })

    </script>



@endsection
