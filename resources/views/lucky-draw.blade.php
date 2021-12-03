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
    <link rel="stylesheet" href="<?= asset("/jy/lottery.css") ?>">

    <style>
        .demo-1 .large-header {
            background-image: url("<?= asset('/jy/bg-1.jpg')?>");
            background-size: 100vw 100vh;
            width: 100vw;
            height: 100vh;
            background-repeat: no-repeat;
            position: fixed;
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
                <div class='winnerBox'>
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
    var probability1 = "<?php if($prize_type == 1) {echo '100%';} else{ echo '0%';} ?>";
    var probability2 = "<?php if($prize_type == 2) {echo '100%';} else{ echo '0%';} ?>";
    var probability3 = "<?php if($prize_type == 3) {echo '100%';} else{ echo '0%';} ?>";
    var probability4 = "<?php if($prize_type == 4) {echo '100%';} else{ echo '0%';} ?>";
    var probability5 = "<?php if($prize_type == 5) {echo '100%';} else{ echo '0%';} ?>";
    var probability6 = "<?php if($prize_type == 6) {echo '100%';} else{ echo '0%';} ?>";
    var probability7 = "<?php if($prize_type == 7) {echo '100%';} else{ echo '0%';} ?>";
    var token = "<?php echo request('api_token'); ?>";
</script>

<!--大转盘-->
<script src="<?=asset('/jy/awardRotate.js')?>"></script>
<script src="<?=asset('/jy/lottery1.js')?>"></script>

</body>
</html>
