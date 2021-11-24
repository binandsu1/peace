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
                    {{--<h3>兑奖码：{{$v->num}}</h3>--}}
                @endforeach

                <br>
                <div class="mb2"><a class="act-but submit" href="{{route('poster')}}" style="color: #FFFFFF">点亮个人海报，获取礼品兑换码</a></div><br>

                <form action="#" name="f" method="post">
                    <!--<div class="input_outer">-->
                    <!--<span class="u_user"></span>-->
                    <!--<input name="logname" class="text" style="color: #FFFFFF !important" type="text" placeholder="请输入账户">-->
                    <!--</div>-->
                    <!--<div class="input_outer">-->
                    <!--<span class="us_uer"></span>-->
                    <!--<input name="logpass" class="text" style="color: #FFFFFF !important; position:absolute; z-index:100;"value="" type="password" placeholder="请输入密码">-->
                    <!--</div>-->
                    {{--<div class="mb2"><a class="act-but submit" href="{{route('activity-up')}}" style="color: #FFFFFF">线上点亮</a></div><br>--}}
                    {{--<div class="mb2"><a class="act-but submit" href="{{route('activity-down')}}" style="color: #FFFFFF">线下点亮</a></div>--}}
                </form>
            </div>
        </div>
    </div>


</div><!-- /container -->
<script src="<?=asset('/jy/TweenLite.min.js')?>"></script>
<script src="<?=asset('/jy/EasePack.min.js')?>"></script>
<script src="<?=asset('/jy/rAF.js')?>"></script>
<script src="<?=asset('/jy/demo-1.js')?>"></script>
</body>
</html>
