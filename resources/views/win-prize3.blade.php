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

        input[type="text"]{
            color:#6e4531;
            border-radius: 0;

            border-bottom:1px solid #005aa7; /* 下划线效果 */

            border-top:0px;

            border-left:0px;

            border-right:0px;

            background-color:transparent; /* 背景色透明 */
        }

        .demo-1 .large-header {
            background-image: url("<?= asset('/jy/'.$bg.'p.jpg')?>");
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
            margin-top: -18vh;
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
            margin-top: -22vh;
            font-size: 1rem;
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
                margin-top: -24vh;
                font-size: 1rem;
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
                <div id="md_div" class="input-group flag-unchecked btn-3">
                   <span style="color: #744323">门店ID：</span> <input id="md_code1" type="text" class="form-control" placeholder="请询问店内工作人员" aria-describedby="basic-addon1">
                </div>
                <?php
                if ($prize_num == 11) {
                ?>
                    <div class="mb2 btn-1"><a class="act-but submit" onclick="winner1()" style="color: #744323">拍照上传</a></div><br>
                <?php
                } else {
                ?>
                    <div class="mb2 btn-1"><a class="act-but submit" onclick="winner2()" style="color: #744323">立即领取</a></div><br>
                <?php
                }
                ?>

            </div>
        </div>
    </div>


</div><!-- /container -->

<script src="<?=asset('/jy/jquery-1.7.2.min.js')?>"></script>
<script>

    function winner1() {

        var md_code = $("#md_code1").val();
        if (md_code.length==0) {
            alert("请输入正确的门店ID");
            return false;
        }

        $.ajax({
            type: "POST",
            url: "{{route('md-code',['api_token'=>request('api_token')])}}",
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "md_code": md_code
            },
            success: function (data) {
                if(data.code == '200'){
                    window.location="{{route('phone',['api_token'=>request('api_token')])}}";
                } else if (data.code == '300') {
                    alert("照片已上传成功！请勿重复上传！");
                    window.location="{{route('poster2',['api_token'=>request('api_token')])}}";
                } else {
                    alert("请输入正确的门店ID");
                }
            }
        });
    }

    function winner2() {
        var md_code2 = $("#md_code1").val();
        if (md_code2.length==0) {
            alert("请输入正确的门店ID");
            return false;
        }

        $.ajax({
            type: "POST",
            url: "{{route('md-code',['api_token'=>request('api_token')])}}",
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "md_code": md_code2
            },
            success: function (data) {
                if(data.code == '200'){
                    window.location="{{route('poster2',['api_token'=>request('api_token')])}}";
                } else if (data.code == '300') {
                    alert("奖品已被领取，请勿重复领取！");
                    window.location="{{route('poster2',['api_token'=>request('api_token')])}}";
                } else {
                    alert("请输入正确的门店ID");
                }
            }
        });

    }
</script>
</body>
</html>
