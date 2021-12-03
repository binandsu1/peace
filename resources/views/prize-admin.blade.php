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
                <h3>中奖信息：</h3>

                <br>
                <h3>线上上海报 1019：{{$online1}}</h3>
                <h3>天猫A 365+腾讯季卡（20000）：{{$online2}}</h3>
                <h3>天猫B 365+帆布袋+袜子（30000）：{{$online3}}</h3>
                <h3>天猫C Surface GO3+闪迪卡128G+ING杯子（12000）：{{$online4}}</h3>
                <h3>京东A 365+电影兑换券（60000）：{{$online5}}</h3>
                <h3>京东B 365+鼠标+布袋（60000）：{{$online6}}</h3>
                <h3>京东C Surface GO3+闪迪卡128G+ING杯子（40000）：{{$online7}}</h3>

                <h3>线下上海报 520：{{$offline1}}</h3>
                <h3>李现海报（2500）：{{$offline2}}</h3>
                <h3>帽子（400）：{{$offline3}}</h3>
                <h3>背包（2000）：{{$offline4}}</h3>
                <h3>袜子（1800）：{{$offline5}}</h3>
                <h3>贴纸（2500）：{{$offline6}}</h3>
                <h3>优惠券（10000）：{{$offline7}}</h3>
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
