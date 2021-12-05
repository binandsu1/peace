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
    <style>
        .demo-1 .large-header {
            background-image: url("<?= asset('/jy/'.$bg.'P.jpg')?>");
            background-size: 100vw 100vh;
            width: 100vw;
            height: 100vh;
            background-repeat: no-repeat;
            position: fixed;
        }

        .btn-1 {
            width: 70vw;
            height: 12vh;
            padding: 1vh;
            position: fixed;
            overflow: hidden;
            left: 50%;
            top: 100%;
            margin-left: -34vw;
            margin-top: -17vh;
        }

        .btn-2 {
            width: 70vw;
            height: 12vh;
            padding: 1vh;
            position: fixed;
            overflow: hidden;
            left: 50%;
            top: 100%;
            margin-left: -10vw;
            margin-top: -6vh;
        }
        .btn-3 {
            width: 100vw;
            height: 14vh;
            padding: 1vh;
            position: fixed;
            overflow: hidden;
            left: 0;
            top: 100%;
            margin-left: 0;
            margin-top: -5.5vh;
            font-size: 0.3rem;
            text-align: center;
        }

        @media only screen and (min-width: 375px) and (min-height: 812px) {
            .demo-1 .large-header {
                background-image: url("<?= asset('/jy/'.$bg.'X.jpg')?>");
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
                margin-left: -34vw;
                margin-top: -20vh;
            }
            .btn-2 {
                width: 70vw;
                height: 14vh;
                padding: 1vh;
                position: fixed;
                overflow: hidden;
                left: 50%;
                top: 100%;
                margin-left: -10vw;
                margin-top: -10vh;
            }
            .btn-3 {
                width: 100vw;
                height: 14vh;
                padding: 1vh;
                position: fixed;
                overflow: hidden;
                left: 0;
                top: 100%;
                margin-left: 0;
                margin-top: -10vh;
                font-size: 0.3rem;
                text-align: center;
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
            <div class="logo_box">
                <h3>恭喜您-线下！</h3>
                @foreach($prize_code as $k=>$v)
                    {{--{{$v->gift_id}}--}}
                    <?php
                        switch($v->gift_id) {
                            case 1:
                                echo "<h3>获得 上海报机会！</h3>";
                                break;
                            case 2:
                                echo "<h3>获得 ING联名袜子</h3>";
                                break;
                            case 3:
                                echo "<h3>获得 ING联名马克杯</h3>";
                                break;
                        }

                    ?>
                    {{--<h3>兑奖码：<span id="prize_code">{{$code}}</span> <button class="copy_btn" type="button" data-clipboard-target="#prize_code">复制</button></h3>--}}
                @endforeach

                <br>
                <div class="mb2"><a class="act-but submit" href="{{route('store-map',['api_token'=>request('api_token')])}}" style="color: #FFFFFF">查询线下门店</a></div><br>

            </div>
        </div>
    </div>


</div><!-- /container -->
<script src="<?=asset('/jy/TweenLite.min.js')?>"></script>
<script src="<?=asset('/jy/EasePack.min.js')?>"></script>
<script src="<?=asset('/jy/rAF.js')?>"></script>
<script src="<?=asset('/jy/demo-1.js')?>"></script>
{{--<script src="<?=asset('/jy/clipboard.min.js')?>"></script>--}}
{{--<script>--}}
    {{--new Clipboard('.copy_btn');--}}
{{--</script>--}}
</body>
</html>
