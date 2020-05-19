@extends('chat.common.header')

@section('content')

    <style>

        .friend-span{

            float: right;

        }

        .friend-span span{

            box-sizing: border-box; display:inline-block;color:#fff;text-align:center;outline:none;overflow:hidden;text-decoration:none;position: relative;height: 30px;width: 50px;line-height: 30px;

        }

        .friend-span span.friend-passed, span.friend-refused{

            color: #333;

        }

        .friend-span span.friend-pass{

            background-color:#ffd100;

        }

        .friend-span span.friend-refuse{

            background-color:red;

        }
    </style>

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

            <div class="wc__ucinfoPanel">

                <div class="wc__addrFriend-list" id="J__addrFriendList">

                    <ul class="clearfix" id="J__ucinfoPanel">

                        <li class="new-friends">

                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    @include('chat.common.main')

    <script>

        newFriendsList();

    </script>

@endsection
