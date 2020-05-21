<div class="wc__popup-videoPreview" style="display: none;">

    <i class="wc__videoClose"></i>

    <video id="J__videoPreview" width="100%" height="100%" controls="controls" x5-video-player-type="h5" x5-video-player-fullscreen="true" webkit-playsinline preload="auto"></video>

</div>

<script type="text/javascript">

    let video = document.getElementById("J__videoPreview");

    $("#J__chatMsgList li").on("click", ".video", function(){

        video.src = $(this).find("img").attr("videoUrl");

        $(".wc__popup-videoPreview").show();

        if(video.paused){

            video.play();

        }else{

            video.pause();

        }

    });

    video.addEventListener("ended", function(){

        video.currentTime = 0;

    }, false);

    // 关闭预览
    $(".wc__popup-videoPreview").on("click", ".wc__videoClose", function(){

        $(".wc__popup-videoPreview").hide();

        video.currentTime = 0;

        video.pause();

    });

    // 进入全屏、退出全屏
    video.addEventListener("x5videoenterfullscreen", function(){

        console.log("进入全屏");

    }, false);

    video.addEventListener("x5videoexitfullscreen", function(){

        $(".wc__popup-videoPreview .wc__videoClose").trigger("click");

    }, false)

</script>
