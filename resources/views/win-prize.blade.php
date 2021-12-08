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
            background-size: 100vw 100vh;
            width: 100vw;
            height: 99vh;
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
            margin-top: -22vh;
        }

        .btn-2 {
            width: 70vw;
            height: 12vh;
            padding: 1vh;
            position: fixed;
            overflow: hidden;
            left: 50%;
            top: 100%;
            margin-left: -9vw;
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
            margin-left: 12vw;
            margin-top: -10vh;
            font-size: 1rem;
            text-align: center;
            transform: scale(.76);
            transform-origin: left;
        }

        @media only screen and (min-width: 375px) and (min-height: 812px) {
            .demo-1 .large-header {
                {{--background-image: url("<?= asset('/jy/'.$bg.'X.jpg')?>");--}}
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
                margin-left: 12vw;
                margin-top: -10vh;
                font-size: 1rem;
                text-align: center;
                transform: scale(.76);
                transform-origin: left;
            }
        }
    </style>
    <!--[if IE]>
    <script src="<?=asset('/jy/html5.js')?>"></script>
    <![endif]-->
</head>
<body>
<div class="container demo-1">

        <div id="large-header" class="large-header">
            <div class="logo_box">

                <div class="mb2 btn-1">
                    <a type="button" class="act-but submit" style="color: #744323"  href="{{route('poster',['api_token'=>request('api_token')])}}">新年新愿上海报</a>
                </div>
                <?php
                    if ($prize_num == 1) {
                 ?>
                <div class="mb2 btn-3">
                    <a type="button" class="" style="color: #744323" >*您授权使用的ID将被作为海报的设计元素</a>
                </div>
                <?php
                    } else {
                ?>
                <div class="mb2 btn-2">
                    <a type="button" class="" style="color: #744323" href="{{$url}}" target="_blank">兑奖链接</a>
                </div>
                <?php
                }
                ?>


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

        var url = "<?= asset('/jy/'.$bg)?>";

        var bg_image = url+type+".jpg";

        $('#large-header').css('background-image',('url("'+bg_image+'")'));

    });
</script>
</body>
</html>
