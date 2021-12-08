<?php
require_once public_path("jssdk.php");//引入相应路径下的jssdk文件

$jssdk = new JSSDK("wx2055b6314cd25ac1");//按照自己的公众号填写

$signPackage = $jssdk->GetSignPackage();
$data = array(
    'appId' => $signPackage["appId"],
    'nonceStr' => $signPackage["nonceStr"],
    'timestamp' => $signPackage["timestamp"],
    'signature' => $signPackage["signature"]);
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>现在就耀，与现同框</title>
    <link rel="stylesheet" type="text/css" href="<?= asset('/jy/normalize.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset('/jy/demo.css') ?>">
    <!--必要样式-->
    <link rel="stylesheet" type="text/css" href="<?= asset('/jy/component.css') ?>">
    <style>

        .demo-1 .large-header {
            {{--<?php--}}
                {{--if ($flag_id == 8) {--}}
                    {{--?>--}}
                         {{--background-image: url("<?= asset('/images/'.$bg.'P.jpg')?>");--}}
                    {{--<?php--}}
                {{--} else {--}}
                    {{--?>--}}
                            {{--background-image: url("<?= asset('/jy/'.$bg.'P.jpg')?>");--}}
                    {{--<?php--}}
                {{--}--}}
             {{--?>--}}

            background-size: 100vw 100vh;
            width: 100vw;
            height: 100vh;
            background-repeat: no-repeat;
            position: fixed;
        }

        .btn-1 {
            width: 70vw;
            height: 14vh;
            padding: 1vh;
            position: fixed;
            overflow: hidden;
            left: 50%;
            top: 100%;
            margin-left: -35vw;
            margin-top: -25vh;
            text-align: center;
        }

        .btn-3 {
            background-image: url("<?= asset('/jy/不加班.jpg')?>");
            background-size: 100vw 60vh;
            width: 62vw;
            height: 50vh;
            padding: 1vh;
            position: fixed;
            overflow: hidden;
            left: 0;
            top: 100%;
            margin-left: 20vw;
            margin-top: -76vh;
            font-size: 1rem;
            text-align: center;
            opacity: 0;
        }

        .flag-unchecked {
            margin:2vh 2vw;
            font-size: 2vh;
            padding: 0;
            border-radius: 50px;
            color: #6e4531;

        }


        @media only screen and (max-width: 375px) and (min-height: 812px) {
            .demo-1 .large-header {
                {{--<?php--}}
                    {{--if ($flag_id == 8) {--}}
                 {{--?>--}}
                        {{--background-image: url("<?= asset('/images/'.$bg.'X.jpg')?>");--}}
                {{--<?php--}}
                    {{--} else {--}}
                {{--?>--}}
                        {{--background-image: url("<?= asset('/jy/'.$bg.'X.jpg')?>");--}}
                {{--<?php--}}
                  {{--}--}}
                 {{--?>--}}

                background-size: 100vw 100vh;
                width: 100vw;
                height: 100vh;
                background-repeat: no-repeat;
                position: fixed;
            }

            .btn-1 {
                width: 70vw;
                height: 14vh;
                padding: 1vh;
                position: fixed;
                overflow: hidden;
                left: 50%;
                top: 100%;
                margin-left: -35vw;
                margin-top: -20vh;
                text-align: center;
            }

            .btn-3 {
                background-image: url("<?= asset('/jy/不加班.jpg')?>");
                background-size: 100vw 60vh;
                width: 76vw;
                height: 50vh;
                padding: 1vh;
                position: fixed;
                overflow: hidden;
                left: 0;
                top: 100%;
                margin-left: 12vw;
                margin-top: -74vh;
                font-size: 1rem;
                text-align: center;
                /*opacity: 0;*/
            }

            .flag-unchecked {
                margin:2vh 2vw;
                font-size: 2vh;
                padding: 0;
                border-radius: 50px;
                color: #6e4531;

            }
        }
    </style>


    <!--[if IE]>
    <script src="<?=asset('/jy/html5.js')?>"></script>
    <![endif]-->
</head>
<body>
<div class="container demo-1">
    <div class="content">
        <div id="large-header" class="large-header">
            <?php
            if ($flag_id == 8) {
                $src = asset('/images/'.$bg.'Z.jpg');
            } else {
                $src = asset('/jy/'.$bg.'.jpg');
            }
            ?>
            <div class="logo_box_home">
                <div  class="mb2 btn-3"><img style="width: 76vw; height: 50vh" src="{{$src}}" alt=""></div>
                {{--<a class="act-but1 submit" href="<?= asset('/images/'.$bg.'Z.jpg')?>" style="color: #744323">保 存 图 片</a>--}}
                <form action="#" name="f" method="post">
                    <?php
                        if ($type == "wb") {
                    ?>
                        <div class="mb2 btn-1"><a class="act-but submit" onclick="up()" style="color: #744323">一 键 分 享</a></div>
                    <?php
                        } else {
                    ?>
                        <div id="fx_btn" class="mb2 btn-1">
                            <p class="flag-unchecked">长按图片保存专属海报</p>
                            <p class="flag-unchecked">点击右上角“…”分享到微信中</p>
                        </div>
                        <div id="cy_btn" class="mb2 btn-1" style="display: none;"><a class="act-but submit" onclick="go_home()" style="color: #744323">立 即 参 与</a></div>
                    <?php
                        }
                    ?>

                </form>
            </div>
        </div>
    </div>


</div><!-- /container -->
<script src="<?=asset('/jy/jquery-1.7.2.min.js')?>"></script>
<script>


    $(document).ready(function(){
        var h = $(document).height(); //浏览器当前窗口文档的高度

        var type = "";

        if (h < 780) {
            type = "P";
        } else {
            type = "X";
        }

        <?php if($flag_id == 8) { $dir = "image";} else { $dir = "jy";} ?>

        var url = "<?= asset('/'.$dir.'/'.$bg)?>";

        var bg_image = url+type+".jpg";

        $('#large-header').css('background-image',('url("'+bg_image+'")'));

        var w_t =  window.location.href.split('#');
        if (w_t[1] == '0533') {
            $("#cy_btn").css("display","block");
            $("#fx_btn").css("display","none");
        }

        window.location.href = "#"+"0533";

    });

    function go_home() {
        window.location.replace("/api/activityIndex?type=wx");
    }

    function up() {

        $.ajax({
            type: "POST",
            url: "{{route('share',['api_token'=>request('api_token')])}}",
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

            success: function (data) {
                if(data.code == '200') {
                    alert('分享成功！');
                }
            }
        });

    }

//    $(function(){
//        $("#touchArea").on({
//            touchstart: function(e){
//                timeOutEvent = setTimeout("longPress()",500);
//                e.preventDefault();
//            },
//            touchmove: function(){
//                clearTimeout(timeOutEvent);
//                timeOutEvent = 0;
//            },
//            touchend: function(){
//                clearTimeout(timeOutEvent);
//                if(timeOutEvent!=0){
//                    alert("你这是点击，不是长按");
//                }
//                return false;
//            }
//        })
//    });
//    function longPress(){
//        timeOutEvent = 0;
//        alert("长按事件触发发");
//    }

</script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
<script>
    var url=window.location.href;
    wx.config({
        debug:false,
        appId: '<?php echo $data["appId"];?>',
        timestamp: <?php echo $data["timestamp"];?>,
        nonceStr: '<?php echo $data["nonceStr"];?>',
        signature: '<?php echo $data["signature"];?>',
        url:url,
        jsApiList: [
            'updateAppMessageShareData',
            'updateTimelineShareData',
            'onMenuShareAppMessage',
            'onMenuShareTimeline',
            'onMenuShareQQ',
            'onMenuShareQZone'
        ]
    });
    wx.error(function(res){
        console.log(res);
        // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
    });

    wx.checkJsApi({
        jsApiList: ['updateTimelineShareData','updateAppMessageShareData'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
        success: function(res) {
            // alert(res);
            // 以键值对的形式返回，可用的api值true，不可用为false
            // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
        }
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.updateTimelineShareData({
            title: '微软零售全品牌大使李现的特殊海报上还有位置，等你哟！', // 分享标题
            link: 'https://mssocial.una-ad.com/api/activityIndex?type=wx', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'https://mssocial.una-ad.com/offline/share.jpg', // 分享图标
            success: function () {
                // alert('su');
                // 设置成功
            }
        })
    });

</script>
</body>
</html>
