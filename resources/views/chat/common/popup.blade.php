<style>
    .popui__ios .popui__panel-cnt:first-child {
        padding: 20px 20px 5px !important;
    }
    .wc__popupTmpl .wc-xclose {
        background-size: 15px;
        height: 15px;
        width: 15px;
        top: 15px;
        right: 15px;
    }
</style>
<div id="J__popupTmpl-input" style="display:none;">
    <div class="wc__popupTmpl">
        <i class="wc-xclose"></i>
        <ul class="clearfix">
            <li class="item">
                <div class="itembox wc__borB">
                    <div class="pt-15 flexbox">
                        <label><input class="ipt-txt flex1" value="" type="text" style="font-size: 18px;text-align: left;"></label>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>

<div id="J__popupTmpl-input" style="display:none;">
    <div class="wc__popupTmpl">
        <i class="wc-xclose"></i>
        <ul class="clearfix">
            <li class="item">
                <div class="itembox wc__borB">
                    <div class="pt-15 flexbox">
                        <label><input class="ipt-txt flex1" value="" type="text" style="font-size: 18px;text-align: left;"></label>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>

<script>
    // ...关闭
    $("body").on("click", ".wc__popupTmpl .wc-xclose", function () {
        wcPop.close();
    });
</script>

