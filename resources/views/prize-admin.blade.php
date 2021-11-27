<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>现在就耀，点亮海报活动</title>
    <link rel="stylesheet" type="text/css" href="<?= asset('/jy/normalize.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset('/jy/demo.css') ?>">
    <!--必要样式-->
    <link rel="stylesheet" type="text/css" href="<?= asset('/jy/component.css') ?>">

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
                <h3>中奖信息：（一等奖，二等奖大于额定数值后改为发放3等奖，但统计数据继续增加的同时增加三等奖）</h3>

                <br>
                <h3>线上上海报：{{$online1}}</h3>
                <h3>线上2等奖：{{$online2}}</h3>
                <h3>线上3等奖：{{$online3}}</h3>
                <h3>线下1等奖：{{$offline1}}</h3>
                <h3>线下2等奖：{{$offline2}}</h3>
                <h3>线下3等奖：{{$offline3}}</h3>
                {{--<div class="mb2"><a class="act-but submit" href="{{route('counter',['api_token'=>request('api_token')])}}" style="color: #FFFFFF">归零计数器</a></div><br>--}}

            </div>
        </div>
    </div>


</div><!-- /container -->
<script src="<?=asset('/jy/TweenLite.min.js')?>"></script>
<script src="<?=asset('/jy/EasePack.min.js')?>"></script>
<script src="<?=asset('/jy/rAF.js')?>"></script>
<script src="<?=asset('/jy/demo-1.js')?>"></script>
<script src="<?=asset('/jy/clipboard.min.js')?>"></script>
<script>
    new Clipboard('.copy_btn');
</script>
</body>
</html>
