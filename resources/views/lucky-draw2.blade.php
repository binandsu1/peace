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

    <!--大转盘-->
    <link rel="stylesheet" href="<?= asset("/jy/lottery1.css") ?>">
    <style>
        .demo-1 .large-header {
            {{--background-image: url("<?= asset('/jy/背景P.jpg')?>");--}}
            background-size: 100vw 100vh;
            width: 100vw;
            height: 100vh;
            background-repeat: no-repeat;
            position: fixed;
        }
        .box-draw {
            margin-top: -5vh;
        }

        @media only screen and (max-width: 375px) and (min-height: 812px) {
            .demo-1 .large-header {
                {{--background-image: url("<?= asset('/jy/背景X.jpg')?>");--}}
                background-size: 100vw 100vh;
                width: 100vw;
                height: 100vh;
                background-repeat: no-repeat;
                position: fixed;
            }
            .box-draw {
                margin-top: 4vh;
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
            <canvas id="demo-canvas"></canvas>
            {{--<div class="logo_box">--}}
            {{--<h3 style="text-align: center;">抽奖页面</h3>--}}
            {{--</div>--}}
            <div class='winnerBox box-draw'>
                <div class="turnplate_box">
                    <canvas id="myCanvas" width="260px" height="260px">抱歉！浏览器不支持。</canvas>
                    <button id="tupBtn" class="turnplatw_btn">
                        <img src="<?= asset('/jy/guding@2x.png')?>" class="turnplatw_img">
                        <div class="goIcon"></div>
                    </button>
                </div>
            </div>
        </div>
    </div>


</div><!-- /container -->
<script src="<?=asset('/jy/jquery-1.7.2.min.js')?>"></script>

<script>
    $(document).ready(function(){
        var w = $(document).width(); //浏览器当前窗口文档的高度
        var h = $(document).height(); //浏览器当前窗口文档的高度
        var b = h/w;
        var size = b.toFixed(2);

        var type = "";

        if (size < 1.87) {
            type = "P";
        } else {
            type = "X";
        }

        var url = "<?= asset('/jy/背景')?>";

        var bg_image = url+type+".jpg";

        $('#large-header').css('background-image',('url("'+bg_image+'")'));
    });
    var probability1 = "<?php if($prize_type == 11) {echo '100%';} else{ echo '0%';} ?>";
    var probability2 = "<?php if($prize_type == 12) {echo '100%';} else{ echo '0%';} ?>";
    var probability3 = "<?php if($prize_type == 13) {echo '100%';} else{ echo '0%';} ?>";
    var probability4 = "<?php if($prize_type == 14) {echo '100%';} else{ echo '0%';} ?>";
    var probability5 = "<?php if($prize_type == 15) {echo '100%';} else{ echo '0%';} ?>";
    var probability6 = "<?php if($prize_type == 16) {echo '100%';} else{ echo '0%';} ?>";
    var probability7 = "<?php if($prize_type == 17) {echo '100%';} else{ echo '0%';} ?>";
    var token = "<?php echo request('api_token'); ?>";
</script>

<!--大转盘-->
<script src="<?=asset('/jy/awardRotate.js')?>"></script>
<script src="<?=asset('/jy/lottery-down2.js')?>"></script>

</body>
</html>
