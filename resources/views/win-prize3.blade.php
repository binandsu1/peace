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
                <h3>恭喜您-线下到店展示页面！</h3>
                @foreach($prize_code as $k=>$v)
                    {{--{{$v->gift_id}}--}}
                    <?php
                        switch($v->gift_id) {
                            case 1:
                                echo "<h3>获得 上海报机会！</h3>";
                                echo "<div class=\"mb2\"><a class=\"act-but submit\" onclick=\"winner1()\" >拍 照 上 传</a></div><br>";
                                break;
                            case 2:
                                echo "<h3>获得 ING联名袜子</h3>";
                                echo "<div class=\"mb2\"><a class=\"act-but submit\" onclick=\"winner2()\" >立 即 领 取</a></div><br>";
                                break;
                            case 3:
                                echo "<h3>获得 ING联名马克杯</h3>";
                                echo "<div class=\"mb2\"><a class=\"act-but submit\" onclick=\"winner2()\" >立 即 领 取</a></div><br>";
                                break;
                        }

                    ?>
                    {{--<h3>兑奖码：<span id="prize_code">{{$code}}</span> <button class="copy_btn" type="button" data-clipboard-target="#prize_code">复制</button></h3>--}}
                @endforeach

                <br>

                {{--<div class="mb2"><a class="act-but submit" href="{{route('store-map',['api_token'=>request('api_token')])}}" style="color: #FFFFFF">点击</a></div><br>--}}

            </div>
        </div>
    </div>


</div><!-- /container -->
<script src="<?=asset('/jy/TweenLite.min.js')?>"></script>
<script src="<?=asset('/jy/EasePack.min.js')?>"></script>
<script src="<?=asset('/jy/rAF.js')?>"></script>
<script src="<?=asset('/jy/demo-1.js')?>"></script>
{{--<script src="<?=asset('/jy/clipboard.min.js')?>"></script>--}}
<script>
    function winner1() {
        // TODO::演示结束之后，改为ajax请求
        window.location="{{route('phone',['api_token'=>request('api_token')])}}";
    }

    function winner2() {
        // TODO::演示结束之后，改为ajax请求

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
                    window.location="{{route('poster2',['api_token'=>request('api_token')])}}";
                } else {

                }
            }
        });


    }
</script>
</body>
</html>
