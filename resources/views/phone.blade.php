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

        #fileBtn{width: 84vw;height: 50vh; position: absolute;display: block;top: 0;left: 0;opacity: 0;}
        .fileBtn{width: 84vw;height: 50vh;border: 2px dashed lightskyblue;text-align: center;position: relative;left: 50px;top: 50px;}
        .fileBtn p{line-height: 46vh;}
        #img{width: 84vw;height: 50vh;position: absolute;top: 0;left: 0;z-index: 10;display: none;}
        .img{width: 100px;height: 100px;}
        .img-box{margin-top: 80px;}


        .demo-1 .large-header {
            background-image: url("<?= asset('/jy/主背景.jpg')?>");
            background-size: 100vw 100vh;
            width: 100vw;
            height: 100vh;
            background-repeat: no-repeat;
            position: fixed;
        }

        .btn-1 {
            width: 70vw;
            height: 50vh;
            padding: 1vh;
            position: fixed;
            overflow: hidden;
            left: 50%;
            top: 100%;
            margin-left: -34vw;
            margin-top: -24vh;
        }

        .btn-2 {
            width: 90vw;
            height: 14vh;
            padding: 1vh;
            position: fixed;
            overflow: hidden;
            left: 50%;
            top: 100%;
            margin-left: -30vw;
            margin-top: -80vh;
        }
        .btn-3 {
            width: 76vw;
            height: 50vh;
            padding: 1vh;
            position: fixed;
            overflow: hidden;
            left: 0;
            top: 100%;
            margin-left: 12vw;
            margin-top: -80vh;
            font-size: 1rem;
            text-align: center;
        }

        @media only screen and (min-width: 375px) and (min-height: 812px) {
            .demo-1 .large-header {
                background-image: url("<?= asset('/jy/主背景.jpg')?>");
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
                margin-top: -26vh;
            }
            .btn-2 {
                width: 90vw;
                height: 14vh;
                padding: 1vh;
                position: fixed;
                overflow: hidden;
                left: 50%;
                top: 100%;
                margin-left: -30vw;
                margin-top: -80vh;
            }
            .btn-3 {
                width: 76vw;
                height: 50vh;
                padding: 1vh;
                position: fixed;
                overflow: hidden;
                left: 0;
                top: 100%;
                margin-left: 12vw;
                margin-top: -80vh;
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

    <div id="large-header" class="large-header">
        <div class="logo_box">

            {{--<div style="margin-left:10%">--}}
                <form id="myform" class="form-horizontal" method="post" action="<?=route('phone',['api_token'=>request('api_token')])?>" enctype="multipart/form-data">

                        <div class="fileBtn btn-3">
                            <p style="color:#744323;">点 击 拍 照</p>
                            <input id="fileBtn" type="file" onchange="upload();" accept="image/*" capture="camera" />
                            <!--单张图片容器-->
                            <img src="" id="img"/>
                        </div>

                    <div class="mb2 btn-1">
                        <a type="submit" class="act-but submit btn btn-success" style="color: #744323;" href="#" onclick="document.getElementById('myform').submit();return false;" >照片上传/授权</a>
                    </div>
                </form>


        </div>
    </div>

</div><!-- /container -->
<script src="<?=asset('/jy/jquery-1.7.2.min.js')?>"></script>
<script>
    //单张图片上传
    function upload(){
        var $c = document.querySelector("#fileBtn");//上传出发按钮
        var $d = document.querySelector("#img");//图片容器
        var file = $c.files[0];//获取file对象单张
        var reader = new FileReader();//创建filereader对象
        reader.readAsDataURL(file);//转换数据
        reader.onload = function(e){//加载ok时触发的事件
            console.log(file);
            $d.setAttribute("src", e.target.result);//给图片地址,显示缩略图
            $d.style.display="block";//样式显示
        };
    };
</script>
</body>
</html>
