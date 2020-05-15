<div class="wechat__tabBar">

    <div class="bottomfixed wc__borT">

        <ul class="flexbox flex-alignc wechat-pagination">

            <li class="flex1"><i class="ico i1"><em class="wc__badge">12</em></i><span>微聊</span></li>

            <li class="flex1"><i class="ico i2"></i><span>通讯录</span></li>

            <li class="flex1"><i class="ico i3"><em class="wc__badge wc__badge-dot"></em></i><span>探索</span></li>

            <li class="flex1"><i class="ico i4"></i><span>我</span></li>

        </ul>

    </div>

</div>

<!-- 左右滑屏切换.Start -->
<script type="text/javascript">
    let name = '', chatSwiper = new Swiper('.swiper-container',{
        pagination: '.wechat-pagination',
        paginationClickable: true,
        paginationBulletRender: function (chatSwiper, index, className) {
            switch (index) {
                case 0:
                    name='<i class="ico i1"><em class="wc__badge">12</em></i><span>微聊</span>';
                    break;
                case 1:
                    name='<i class="ico i2"></i><span>通讯录</span>';
                    break;
                case 2:
                    name='<i class="ico i3"><em class="wc__badge wc__badge-dot"></em></i><span>探索</span>';
                    break;
                case 3:
                    name='<i class="ico i4"></i><span>我</span>';
                    break;
                default: name='';
            }
            return '<li class="flex1 ' + className + '">' + name + '</li>';
        }
    });
</script>
<!-- 左右滑屏切换 end -->
