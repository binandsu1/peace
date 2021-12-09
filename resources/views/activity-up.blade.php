<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>现在就耀，与现同框</title>
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

        body{
            height: calc(100% - 250px);
            min-height: 200px;
        }


        @media only screen and (min-height: 900px) and (max-height: 1000px) {
            .demo-1 .large-header {
                background-size: 100vw 100vh;
                width: 100vw;
                height: 100vh;
                background-repeat: no-repeat;
                position: fixed;
            }

            .flag-unchecked {
                /*margin: 1.6vh 1vw;*/
                font-size: 1.6vh;
                /*padding: 0.5vw;*/
                border-radius: 50px;
                color: #6e4531;
                /*transform: scale(.88);*/
                /*transform-origin: left;*/
            }

            .logo_box_flag {
                width: 60vw;
                height: 50vh;
                padding: 0;
                position: fixed;
                overflow: hidden;
                left: 60%;
                top: 50%;
                margin-left: -39vw;
                margin-top: -20vh;
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
        }

        @media only screen and (min-height: 800px) and (max-height: 900px) {
            .demo-1 .large-header {
                background-size: 100vw 100vh;
                width: 100vw;
                height: 100vh;
                background-repeat: no-repeat;
                position: fixed;
            }

            .flag-unchecked {
                /*margin: 1.2vh 1vw;*/
                font-size: 1.6vh;
                /*padding: 0;*/
                border-radius: 50px;
                color: #6e4531;
                /*transform: scale(.88);*/
                /*transform-origin: left;*/
            }

            .logo_box_flag {
                width: 60vw;
                height: 50vh;
                padding: 0;
                position: fixed;
                overflow: hidden;
                left: 60%;
                top: 50%;
                margin-left: -39vw;
                margin-top: -20vh;
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
        }


        @media only screen and (min-height: 600px) and (max-height: 800px) {
            .demo-1 .large-header {
                background-size: 100vw 100vh;
                width: 100vw;
                height: 100vh;
                background-repeat: no-repeat;
                position: fixed;
            }

            .flag-unchecked {
                margin: 1.8vh 2vw;
                font-size: 1.6vh;
                padding: 0;
                border-radius: 50px;
                color: #6e4531;
                /*transform: scale(.88);*/
                /*transform-origin: left;*/
            }

            .logo_box_flag {
                width: 60vw;
                height: 50vh;
                padding: 0;
                position: fixed;
                overflow: hidden;
                left: 60%;
                top: 50%;
                margin-left: -39vw;
                margin-top: -24vh;
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
        }

        @media only screen and (min-height: 200px) and (max-height: 600px) {
            .demo-1 .large-header {
                background-size: 100vw 100vh;
                width: 100vw;
                height: 100vh;
                background-repeat: no-repeat;
                position: fixed;
            }

            .flag-unchecked {
                margin: 1vh 2vw;
                font-size: 1vh;
                padding: 0;
                border-radius: 50px;
                color: #6e4531;
                transform: scale(.76);
                transform-origin: left;
            }

            .logo_box_flag {
                width: 80vw;
                height: 80vh;
                padding: 0;
                position: fixed;
                overflow: hidden;
                left: 60%;
                top: 50%;
                margin-left: -39vw;
                margin-top: -30vw;
            }

            .btn-1 {
                width: 70vw;
                height: 18vh;
                padding: 1vh;
                position: fixed;
                overflow: hidden;
                left: 50%;
                top: 100%;
                margin-left: -34vw;
                margin-top: -26vh;
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
            <div class="logo_box_flag">

                   <div class="flag-unchecked"><li style="list-style: none"><input type="radio" name="flags" value="1"> 告别拖延君，365天天天不加班</li></div>
                   <div class="flag-unchecked"><li style="list-style: none"><input type="radio" name="flags" value="2"> 工作是为了好好生活，生活是为了努力工作</li></div>
                   <div class="flag-unchecked"><li style="list-style: none"><input type="radio" name="flags" value="3"> 去<s>美国微软总部</s>微软门店看一看</li></div>
                   <div class="flag-unchecked"><li style="list-style: none"><input type="radio" name="flags" value="4"> 锻炼身体<s>像李现一样</s>量力而行</li></div>
                   <div class="flag-unchecked"><li style="list-style: none"><input type="radio" name="flags" value="5"> <s>找一个像李现一样的男朋友</s>一个人也要好好的</li></div>
                   <div class="flag-unchecked"><li style="list-style: none"><input type="radio" name="flags" value="6"> 做个有效率的人，拒绝熬夜！</li></div>
                   <div class="flag-unchecked"><li style="list-style: none"><input type="radio" name="flags" value="7"> 保持创新，像Windows实时更新</li></div>
                   <div class="flag-unchecked"><li id="customize_li" style="list-style: none; display: none;"><input type="radio" name="flags" value="8"><span id="self_flag"></span></li></div>

                    <div id="cus_div" class="input-group flag-unchecked">
                        <input id="customize_flag" type="text" name="flag" class="form-control" placeholder="其他（限14字以内）" maxlength="14" aria-describedby="basic-addon1"><span onclick="click_set()"><b> 点击保存</b></span>

                    </div>

            </div>
            <div class="mb2 btn-1">
                <a type="button" class="act-but submit" style="color: #744323"  onclick="set_flag()">点 我 上 海 报</a>
            </div>
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

        var url = "<?= asset('/jy/新年新愿')?>";

        var bg_image = url+type+".jpg";

        $('#large-header').css('background-image',('url("'+bg_image+'")'));


        if (h>900 && w>400) {
            $(".flag-unchecked").css({
                padding:"0.8vh",
            });
            $(".logo_box_flag").css({
                width:"30vh",margin:"-20vh"
            });
        }

        if (h>900 && w<400) {
            $(".flag-unchecked").css({
                padding:"0.8vh",
            });
            $(".logo_box_flag").css({
                width:"29vh",margin:"-19vh"
            });
        }

        if (h>800 && h<=900 && w<400) {
            $(".flag-unchecked").css({
                padding:"1vh",
            });
            $(".logo_box_flag").css({
                width:"27vh",margin:"-20vh -42vw"
            });
        }

        if (h>800 && h<=900 && w>400) {
            $(".flag-unchecked").css({
                padding:"1vh",
            });
            $(".logo_box_flag").css({
                width:"36vh",margin:"-20vh -42vw"
            });
        }

        if (h>700 && h<=800 && w<=400) {
            $(".flag-unchecked").css({
                padding:"0.4vh",margin:"1vh"
            });

            $(".logo_box_flag").css({
                width:"34vh",margin:"-21vh"
            });
        }
        if (h>550 && h<=700 && w<=400) {
            $(".flag-unchecked").css({
                padding:"0.4vh",margin:"1vh"
            });

            $(".logo_box_flag").css({
                width:"34vh",margin:"-23vh"
            });
        }
        if (h>450 && h<=550) {
            $(".flag-unchecked").css({
                padding:"0.2vh",margin:"1vh"
            });

            $(".logo_box_flag").css({
                width:"44vh",margin:"-32vh"
            });
        }

        var winHeight = $(window).height();  //获取当前页面高度
        $(window).resize(function () {
            var thisHeight = $(this).height();
            if ( winHeight - thisHeight > 140 ) {
                //键盘弹出
//                $('.logo_box_flag').css('position','static');
//                alert("1");
                $(".flag-unchecked").css({
                    padding:"0.2vh",margin:"1vh"
                });

                $(".logo_box_flag").css({
                    width:"44vh",margin:"-32vh"
                });
            } else {
//                alert("2");
                //键盘收起
//                $('.logo_box_flag').css({'position':'fixed','bottom':'0'});
            }
        })


    });

        function click_set (){
            // 自定义flag 敏感词检测
            var flag_wb = $('#customize_flag').val();
            if (flag_wb.length==0) {
                return false;
            }
            if (flag_wb.length>=15) {
                alert("字数超限！");
                return false;
            }
            $.ajax({
                type: "POST",
                url: "{{route('mgc',['api_token'=>request('api_token')])}}",
                dataType: 'json',
                header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    "flag_wb": flag_wb,
                },
                success: function (data) {
                    if(data.code == '200') {
                        $("#self_flag").text(' '+flag_wb);
                        $("#cus_div").css('display','none');
                        $("#customize_li").css('display','block');
                    } else {
                        alert('请勿输入敏感词，请修改后再次提交！');
                    }
                }
            });
        }



    // 保存flag并前往抽奖
    function set_flag() {
        var flag_id = $("input[name='flags']:checked").val();

        if (flag_id == undefined) {
            alert("许下一个属于你的新年新愿吧！");
            return false;
        }

        $.ajax({
            type: "POST",
            url: "{{route('set-flag',['api_token'=>request('api_token')])}}",
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "flag_id": flag_id
            },
            success: function (data) {
                if(data.code == '200'){
                    window.location="{{route('lucky-draw',['api_token'=>request('api_token')])}}";
                } else {
                    alert("许愿次数太多就不灵了！");
                    window.location="{{route('lucky-draw',['api_token'=>request('api_token')])}}";
                }
            }
        });
    };


</script>
</body>
</html>
