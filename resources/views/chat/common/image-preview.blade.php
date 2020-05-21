<div class="wc__popup-imgPreview" style="display: none;">

    <div class="swiper-container J__swiperImgPreview">

        <div class="swiper-wrapper"></div>

        <!-- <div class="swiper-pagination pagination-imgPreview"></div> -->

    </div>

</div>

<script type="text/javascript">

    let curIndex = 0, imgPreviewSwiper;

    $("#J__chatMsgList li").on("click", ".picture", function(){

        var html = "",  _src = $(this).find("img").attr("src");

        $("#J__chatMsgList li .picture").each(function(i, item){

            html += '<div class="swiper-slide"><div class="swiper-zoom-container">'+ $(this).html() +'</div></div>';

            if($(this).find("img").attr("src") === _src){

                curIndex = i;

            }

        });

        $(".J__swiperImgPreview .swiper-wrapper").html(html);

        $(".wc__popup-imgPreview").show();

        imgPreviewSwiper = new Swiper('.J__swiperImgPreview',{
            pagination: false,
            paginationClickable: true,
            zoom: true,
            observer: true,
            observeParents: true,
            initialSlide: curIndex
        });

    });

    // 关闭预览
    $(".wc__popup-imgPreview").on("click", function(e){

        let that = $(this);

        imgPreviewSwiper.destroy(true, true);

        $(".J__swiperImgPreview .swiper-wrapper").html('');

        that.hide();

    });

</script>
