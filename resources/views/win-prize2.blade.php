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
            margin-top: -32vh;
        }

        .btn-2 {
            width: 70vw;
            height: 12vh;
            padding: 1vh;
            position: fixed;
            overflow: hidden;
            left: 50%;
            top: 100%;
            margin-left: -34vw;
            margin-top: -22vh;
            text-align: center;
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
                margin-top: -24vh;
            }
            .btn-2 {
                width: 70vw;
                height: 14vh;
                padding: 1vh;
                position: fixed;
                overflow: hidden;
                left: 50%;
                top: 100%;
                margin-left: -34vw;
                margin-top: -16vh;
                text-align: center;
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
            <div class="logo_box">

                <div class="mb2 btn-2"><a class="act-but submit" href="{{route('win-prize3',['api_token'=>request('api_token')])}}" style="color: #744323">我 在 店 内</a></div><br>
                <div class="mb2 btn-1"><a class="act-but submit" href="{{route('store-map',['api_token'=>request('api_token')])}}" style="color: #744323">查询线下门店</a></div><br>

            </div>
        </div>
    </div>


</div><!-- /container -->

{{--<script src="<?=asset('/jy/clipboard.min.js')?>"></script>--}}
{{--<script>--}}
    {{--new Clipboard('.copy_btn');--}}
{{--</script>--}}
</body>
</html>
