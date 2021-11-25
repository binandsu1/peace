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
                <h3>恭喜您！</h3>
                @foreach($prize_code as $k=>$v)
                    {{--{{$v->gift_id}}--}}
                    <?php
                        switch($v->gift_id) {
                            case 1:
                                echo "<h3>获得 上海报机会！</h3>";
                                break;
                            case 2:
                                echo "<h3>获得 M365个人版+爱奇异季卡</h3>";
                                break;
                            case 3:
                                echo "<h3>获得 319 限量多彩 “新”意套装（M365+精巧鼠标）</h3>";
                                break;
                        }

                    ?>
                    <h3>兑奖码：<span id="prize_code">{{$code}}</span> <button class="copy_btn" type="button" data-clipboard-target="#prize_code">复制</button></h3>
                @endforeach

                <br>
                <div class="mb2"><a class="act-but submit" href="{{route('poster')}}" style="color: #FFFFFF">点亮个人海报，获取礼品兑换码</a></div><br>

            </div>
        </div>
    </div>


</div><!-- /container -->
<script src="<?=asset('/jy/TweenLite.min.js')?>"></script>
<script src="<?=asset('/jy/EasePack.min.js')?>"></script>
<script src="<?=asset('/jy/rAF.js')?>"></script>
<script src="<?=asset('/jy/demo-1.js')?>"></script>
<script src="<?=asset('/jy/clipboard.min.js')?>"></script>
<script>
    new Clipboard('.copy_btn');
</script>
</body>
</html>
