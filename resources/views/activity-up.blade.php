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

        .demo-1 .large-header {
            background-image: url("<?= asset('/jy/flag-bg1.jpg')?>");
            background-size: 100vw 100vh;
            width: 100vw;
            height: 100vh;
            background-repeat: no-repeat;
            position: fixed;
        }

        .flag-unchecked {
            margin:1.9vh 2vw;
            font-size: 0.9em;
            padding: 0;
            border-radius: 50px;
            color: #6e4531;
        }
        .logo_box_flag {
            width: 90vw;
            height: 50vh;
            padding: 4vh;
            position: fixed;
            overflow: hidden;
            left: 50%;
            top: 50%;
            margin-left: -44vw;
            margin-top: -22vh;
        }

        .btn-1 {
            width: 90vw;
            height: 20vh;
            padding: 4vh;
            position: fixed;
            overflow: hidden;
            left: 50%;
            top: 100%;
            margin-left: -44vw;
            margin-top: -22vh;
        }

        {{--@media only screen and (max-height: 568px) {--}}
            {{--.demo-1 .large-header {--}}
                {{--background-image: url("<?= asset('/jy/flag-bg1.jpg')?>");--}}
                {{--background-size: 100vw 100vh;--}}
                {{--width: 100vw;--}}
                {{--height: 100vh;--}}
                {{--background-repeat: no-repeat;--}}
                {{--position: fixed;--}}
            {{--}--}}

            {{--.flag-unchecked {--}}
                {{--margin:0.5rem 1rem;--}}
                {{--font-size: 0.5rem;--}}
                {{--padding: 0;--}}
                {{--border-radius: 50px;--}}
                {{--color: #6e4531;--}}
            {{--}--}}
            {{--.logo_box_flag {--}}
                {{--width: 90vw;--}}
                {{--height: 50vh;--}}
                {{--padding: 4vh;--}}
                {{--position: fixed;--}}
                {{--left: 50%;--}}
                {{--top: 50%;--}}
                {{--margin-left: -46vw;--}}
                {{--margin-top: -22vh;--}}
            {{--}--}}
        {{--}--}}

        {{--@media only screen and (min-width: 375px) and (min-height: 812px) {--}}
            {{--.demo-1 .large-header {--}}
                {{--background-image: url("<?= asset('/jy/flag-bg1.jpg')?>");--}}
                {{--background-size: 100vw 100vh;--}}
                {{--width: 100vw;--}}
                {{--height: 100vh;--}}
                {{--background-repeat: no-repeat;--}}
                {{--position: fixed;--}}
            {{--}--}}

            {{--.flag-unchecked {--}}
                {{--margin:1rem 1rem;--}}
                {{--font-size: 0.9rem;--}}
                {{--padding: 0;--}}
                {{--border-radius: 50px;--}}
                {{--color: #6e4531;--}}
            {{--}--}}
            {{--.logo_box_flag {--}}
                {{--width: 90vw;--}}
                {{--height: 100vh;--}}
                {{--padding: 4vh;--}}
                {{--position: fixed;--}}
                {{--left: 50%;--}}
                {{--top: 50%;--}}
                {{--margin-left: -44vw;--}}
                {{--margin-top: -20vh;--}}
            {{--}--}}
        {{--}--}}

        {{--@media only screen and (min-width: 414px) and (min-height: 812px) {--}}
            {{--.demo-1 .large-header {--}}
                {{--background-image: url("<?= asset('/jy/flag-bg1.jpg')?>");--}}
                {{--background-size: 100vw 100vh;--}}
                {{--width: 100vw;--}}
                {{--height: 100vh;--}}
                {{--background-repeat: no-repeat;--}}
                {{--position: fixed;--}}
            {{--}--}}

            {{--.flag-unchecked {--}}
                {{--margin:1rem 1rem;--}}
                {{--font-size: 0.9rem;--}}
                {{--padding: 0;--}}
                {{--border-radius: 50px;--}}
                {{--color: #6e4531;--}}
            {{--}--}}
            {{--.logo_box_flag {--}}
                {{--width: 90vw;--}}
                {{--height: 50vh;--}}
                {{--padding: 4vh;--}}
                {{--position: fixed;--}}
                {{--left: 50%;--}}
                {{--top: 50%;--}}
                {{--margin-left: -44vw;--}}
                {{--margin-top: -20vh;--}}
            {{--}--}}
        {{--}--}}

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

                {{--<form class="form-horizontal" method="post" action="#">--}}

                        {{--@foreach($flagModels as $k=>$v)--}}

                           <div class="flag-unchecked"><li style="list-style: none"><input type="radio" name="flags" value="1"> 人生很贵，请别浪费，再见了拖延君，我的愿望是365天不加班</li></div>
                           <div class="flag-unchecked"><li style="list-style: none"><input type="radio" name="flags" value="2"> 工作是为了好好生活，生活是为了努力工作</li></div>
                           <div class="flag-unchecked"><li style="list-style: none"><input type="radio" name="flags" value="3"> 去<s>美国微软总部</s>微软门店看一看</li></div>
                           <div class="flag-unchecked"><li style="list-style: none"><input type="radio" name="flags" value="4"> 锻炼身体<s>像李现一样</s>量力而行</li></div>
                           <div class="flag-unchecked"><li style="list-style: none"><input type="radio" name="flags" value="5"> <s>找一个像李现一样的男朋友</s>一个人也要好好的</li></div>
                           <div class="flag-unchecked"><li style="list-style: none"><input type="radio" name="flags" value="6"> 做个有效率的人，拒绝熬夜！</li></div>
                           <div class="flag-unchecked"><li style="list-style: none"><input type="radio" name="flags" value="7"> 保持创新，像Windows实时更新</li></div>
                           <div class="flag-unchecked"><li id="customize_li" style="list-style: none; display: none;"><input type="radio" name="flags" value="8"><span id="self_flag"></span></li></div>
                        {{--@endforeach--}}

                        <div id="cus_div" class="input-group flag-unchecked">
                            <input id="customize_flag" type="text" name="flag" class="form-control" placeholder="其他（限15字以内）" aria-describedby="basic-addon1">
                        </div>



                {{--</form>--}}
            </div>
            <div class="mb2 btn-1" onclick="set_flag()"><a type="button" class="act-but submit" style="color: #744323">点 我 上 海 报</a></div>
        </div>
    </div>
</div><!-- /container -->
<script src="<?=asset('/jy/jquery-1.7.2.min.js')?>"></script>
{{--<script src="<?=asset('/jy/TweenLite.min.js')?>"></script>--}}
{{--<script src="<?=asset('/jy/EasePack.min.js')?>"></script>--}}
{{--<script src="<?=asset('/jy/rAF.js')?>"></script>--}}
{{--<script src="<?=asset('/jy/demo-1.js')?>"></script>--}}
<script>
    $(document).keyup(function(event){

        if(event.keyCode ==13){
            // 自定义flag 敏感词检测
            var flag_wb = $('#customize_flag').val();
            if (flag_wb.length==0) {
                return false;
            }
            if (flag_wb.length>15) {
                alert("字数超限！");
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
                        $("#self_flag").text(flag_wb);
                        $("#cus_div").css('display','none');
                        $("#customize_li").css('display','block');
                    } else {
                        alert('请勿输入敏感词，请修改后再次提交！');
                    }
                }
            });
        }
    });





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
                }
            }
        });
    };


</script>
</body>
</html>
