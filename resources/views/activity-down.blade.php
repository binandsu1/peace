<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="<?= asset('/jy/normalize.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset('/jy/demo.css') ?>">
    <!--必要样式-->
    <link rel="stylesheet" type="text/css" href="<?= asset('/jy/component.css') ?>">
    <style>
        @media screen and (-webkit-min-device-pixel-ratio: 2), screen and (min--moz-device-pixel-ratio: 3) {
            .demo-1 .large-header {
                background-image: url("<?= asset('/jy/flag-bg1.jpg')?>");
                background-size: 375px 812px;
                width: 375px;
                height: 812px;
                background-repeat: no-repeat;
            }
            .flag-unchecked {
                background-image: url("<?= asset('/jy/btn-2.png')?>");
                background-size: auto 50px;
                background-repeat: no-repeat;
                background-position: right center;
                margin:30px 0;
                font-size: 1.2rem;
                padding: 6px;
                border-radius: 50px;
                color: royalblue;
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
                <h1>立下属于你的新年flag</h1>

                <form class="form-horizontal" method="post" action="">
                    <div class="dropdown">
                        @foreach($flagModels as $k=>$v)
                            <div class="flag-unchecked"><li style="list-style: none"><input type="checkbox" name="flags" value="{{$v->id}}"> {{$v->flag_model}}</li></div>
                        @endforeach
                            <li id="customize_li" style="list-style: none; display: none;"><input type="checkbox" name="self_flag" ></li>
                        <div id="cus_div" class="input-group">
                            <input id="customize_flag" type="text" name="flag" class="form-control" placeholder="自定义flag" aria-describedby="basic-addon1"><button type="button" onclick="check_mgc()">保存</button>
                        </div>
                    </div>
                    <br>
                    <div class="mb2" onclick="set_flag()"><a type="button" class="act-but submit" style="color: #FFFFFF">立下Flag 参与抽奖</a></div>
                </form>
            </div>
        </div>
    </div>
</div><!-- /container -->
<script src="<?=asset('/jy/jquery-1.7.2.min.js')?>"></script>
{{--<script src="<?=asset('/jy/TweenLite.min.js')?>"></script>--}}
{{--<script src="<?=asset('/jy/EasePack.min.js')?>"></script>--}}
{{--<script src="<?=asset('/jy/rAF.js')?>"></script>--}}
{{--<script src="<?=asset('/jy/demo-1.js')?>"></script>--}}
<script>
    // 自定义flag 敏感词检测
    function check_mgc() {
        var flag_wb = $('#customize_flag').val();
        if (flag_wb.length==0) {
            return false;
        }
        $.ajax({
            type: "POST",
            url: "{{ url('/api/mgc?api_token='.request('api_token')) }}",
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "flag_wb": flag_wb,
            },
            success: function (data) {
                if(data.code == '200') {
                    $("#customize_li").text(flag_wb);
                    $("#cus_div").css('display','none');
                    $("#customize_li").css('display','block');
                } else {
                    alert('自定义flag包含敏感词，请修改后再次提交！');
                }
            },
//            error: function(request, status, error){
//                alert(error);
//            },
        });
    };


    // 保存flag并前往抽奖
    function set_flag() {

        var flag_wb = $('#customize_li').text();
        var chk_value ='';
        $('input[name="flags"]:checked').each(function(){
            chk_value += $(this).val()+',';
        });

        if (flag_wb.length==0) {
            if (chk_value.length==0) {
                alert( '您还没有选择任何内容！');
                return false;
            }
        }

        $.ajax({
            type: "POST",
            url: "{{route('set-flag',['api_token'=>request('api_token')])}}",
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "customize_flag": flag_wb,
                "model_ids": chk_value,
            },
            success: function (data) {
                if(data.code == '200'){
                    window.location="{{route('lucky-draw2',['api_token'=>request('api_token')])}}";
                } else {

                }
            }
        });
    };


</script>
</body>
</html>
