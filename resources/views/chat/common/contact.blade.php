<div class="swiper-slide">

    <div class="wc__scrolling-panel">

        <div class="wc__addrFriend-list" id="J__addrFriendList">

            <ul class="clearfix contact-list">

                <li>

                    <div class="row flexbox flex-alignc wc__material-cell">

                        <img class="uimg" alt="" src="{{asset('static/img/icon__addrFriend-img01.jpg')}}"/>

                        <a class="name flex1" href="{{url('friend/new')}}">新的朋友</a>

                    </div>

                    <div class="row flexbox flex-alignc wc__material-cell">

                        <img class="uimg" alt="" src="{{asset('static/img/icon__addrFriend-img02.jpg')}}"/>

                        <span class="name flex1">群聊</span>

                    </div>

                </li>

            </ul>

        </div>

    </div>

    <!-- //字母显示 -->
    <div class="wc__addrFriend-showletter">A</div>
    <!-- //26字母 -->
    <div class="wc__addrFriend-floatletter">
        <em>A</em>
        <em>B</em>
        <em>C</em>
        <em>D</em>
        <em>E</em>
        <em>F</em>
        <em>G</em>
        <em>H</em>
        <em>I</em>
        <em>J</em>
        <em>K</em>
        <em>L</em>
        <em>M</em>
        <em>N</em>
        <em>O</em>
        <em>P</em>
        <em>Q</em>
        <em>R</em>
        <em>S</em>
        <em>T</em>
        <em>U</em>
        <em>V</em>
        <em>W</em>
        <em>X</em>
        <em>Y</em>
        <em>Z</em>
    </div>
</div>

<script>

    $(".wc__addrFriend-floatletter").on("click", "em", function() {

        let letter = $(this).text(), item = $(".contact-list #" + letter);

        if(item.length > 0){

            // 滚动到指定位置
            $("#J__addrFriendList").parent().animate({ scrollTop: item.position().top}, 300);

        }

        $(".wc__addrFriend-showletter").text(letter).fadeIn(300);

        setTimeout(function(){

            $(".wc__addrFriend-showletter").fadeOut(300);

        }, 500);

    });

</script>
