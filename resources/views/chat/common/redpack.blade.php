<div class="wc__choosePanel-tmpl">

    <!-- //红包模板.begin -->

    <div id="J__popupTmpl-Hongbao" style="display:none;">

        <div class="wc__popupTmpl tmpl-hongbao">

            <i class="wc-xclose"></i>

            <ul class="clearfix">

                <li class="item flexbox">

                    <label class="txt">总金额</label><input class="ipt-txt flex1" type="tel" name="hbAmount" placeholder="0.00" /><em class="unit">元</em>

                </li>

                <li class="item flexbox">

                    <label class="txt">红包个数</label><input class="ipt-txt flex1" type="tel" name="hbNum" placeholder="填写个数" /><em class="unit">个</em>

                </li>

                <li class="tips">在线人数共<em class="memNum">186</em>人</li>

                <li class="item item-area">

                    <textarea class="describe" name="content" placeholder="恭喜发财，大吉大利"></textarea>

                </li>

                <li class="amountTotal">￥<em class="num">0.00</em></li>

            </ul>

        </div>

    </div>

    <!-- //红包模板.end -->
</div>

<script type="text/javascript">

    /* ...红包事件.start */
    $(".J__wchatHb").on("click", function(){

        var bpidx = wcPop({
            skin: 'ios',
            content: $("#J__popupTmpl-Hongbao").html(),
            style: 'background-color: #f3f3f3; max-width: 320px; width: 90%;',
            shadeClose: false,
            btns: [
                {
                    text: '塞钱进红包',
                    style: 'background:#ffba00;color:#fff;font-size:18px;',
                    onTap() {
                        alert("塞钱成功！");
                        wcPop.close(bpidx);
                    }
                }
            ]
        });
    });
    /* ...红包事件.end */
    // ...关闭
    $("body").on("click", ".wc__popupTmpl .wc-xclose", function(){
        wcPop.close();
    });
</script>
