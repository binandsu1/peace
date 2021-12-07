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
            <?php
                if ($flag_id == 8) {
                    ?>
                         background-image: url("<?= asset('/images/'.$bg.'P.jpg')?>");
            <?php
        } else {
            ?>
background-image: url("<?= asset('/jy/'.$bg.'P.jpg')?>");
            <?php
        }
     ?>

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
            margin-left: -33vw;
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
                <?php
                    if ($flag_id == 8) {
                 ?>
                        background-image: url("<?= asset('/images/'.$bg.'X.jpg')?>");
                <?php
                    } else {
                ?>
                        background-image: url("<?= asset('/jy/'.$bg.'X.jpg')?>");
                <?php
                  }
                 ?>

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
            <canvas id="demo-canvas"></canvas>
            <?php
                if ($flag_id == 8) {
                    $src = asset('/images/'.$bg.'Z.jpg');
                } else {
                    $src = asset('/jy/'.$bg.'.jpg');
                }
            ?>
            <div class="logo_box_home">
                <div  class="mb2 btn-3"><img style="width: 76vw; height: 50vh" src="{{$src}}" alt=""></div>
                <form action="#" name="f" method="post">
                    <?php
                    if ($type == "wb") {
                    ?>
                    <div class="mb2 btn-1"><a class="act-but submit" onclick="up()" style="color: #744323">一 键 分 享</a></div>
                    <?php
                    } else {
                    ?>
                    <div class="mb2 btn-1">
                        <p class="flag-unchecked">长按图片保存专属海报</p>
                        <p class="flag-unchecked">点击右上角“…”分享到微信中</p>
                    </div>
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
    //			var $sq = $("#sqbtn").val();


    $(document).ready(function(){
        var h = $(document).height(); //浏览器当前窗口文档的高度

        var w_t =  window.location.href.split('#');
        if (w_t[1] == '0533') {
            window.location.replace("/api/activityIndex?type=wx");
        }

        window.location.href = "#"+"0533";

    });

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

</script>
</body>
</html>
