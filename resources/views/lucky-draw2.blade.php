<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="<?= asset('/jy/normalize.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset('/jy/demo.css') ?>">
    <!--必要样式-->
    <link rel="stylesheet" type="text/css" href="<?= asset('/jy/component.css') ?>">

    <!--大转盘-->
    <!--<link rel="stylesheet" href="<?= asset("/jy/sp.css") ?>">-->
    <link rel="stylesheet" href="<?= asset("/jy/lottery.css") ?>">

    <!--[if IE]>
    <script src="<?=asset('/jy/html5.js')?>"></script>
    <![endif]-->
</head>
<body>
<div class="container demo-1">
    <div class="content">
        <div id="large-header" class="large-header">
            <canvas id="demo-canvas"></canvas>
            <div class="logo_box">
                <h3>幸运大转盘-线下点亮</h3>
                <div class='winnerBox'>
                    <div class="turnplate_box">
                        <canvas id="myCanvas" width="260px" height="260px">抱歉！浏览器不支持。</canvas>
                        <button id="tupBtn" class="turnplatw_btn">
                            <img src="<?= asset('/jy/guding@2x.png')?>" class="turnplatw_img">
                            <div class="goIcon"></div>
                        </button>
                    </div>
                </div>
                {{--@foreach($prize_type as $k=>$v)--}}
                    {{--<button type="button"  class="btn btn-default"><a href="{{route('win-prize',['prize'=>"$k",'flag'=>request('flag')])}}">中奖{{$k}}：{{$v}}</a></button>--}}
                {{--@endforeach--}}
            </div>
        </div>
   </div>


</div><!-- /container -->
<script src="<?=asset('/jy/jquery-1.7.2.min.js')?>"></script>
<script src="<?=asset('/jy/TweenLite.min.js')?>"></script>
<script src="<?=asset('/jy/EasePack.min.js')?>"></script>
<script src="<?=asset('/jy/rAF.js')?>"></script>
<script src="<?=asset('/jy/demo-1.js')?>"></script>

<script>
    var probability1 = "<?php if($prize_type == 1) {echo '100%';} else{ echo '0%';} ?>";
    var probability2 = "<?php if($prize_type == 2) {echo '100%';} else{ echo '0%';} ?>";
    var probability3 = "<?php if($prize_type == 3) {echo '100%';} else{ echo '0%';} ?>";
    var token = "<?php echo request('api_token'); ?>";
</script>

<!--大转盘-->
<script src="<?=asset('/jy/awardRotate.js')?>"></script>
<script src="<?=asset('/jy/lottery-down.js')?>"></script>

</body>
</html>