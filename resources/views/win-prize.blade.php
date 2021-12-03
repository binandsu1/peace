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
            background-image: url("<?= asset('/jy/win-prize1.jpg')?>");
            background-size: 100vw 100vh;
            width: 100vw;
            height: 100vh;
            background-repeat: no-repeat;
            position: fixed;
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

                    {{--<h3>兑奖码：<span id="prize_code">{{$code}}</span> <button class="copy_btn" type="button" data-clipboard-target="#prize_code">复制</button></h3>--}}


                <br>
                <?php
                    if ($prize_code >=2 && $prize_code<=4) {
                        ?>
                <a href="https://microsoftstore.tmall.com/search.htm?spm=a220m.1000858.1000725.8.5ba337f2l7pCLB&user_number_id=1621790841&rn=a1319c299d61088ad743153cd6c58259&keyword=%CE%A2%C8%ED" target="_blank">天猫微软</a>
                <?php
                    } else if($prize_code>=5 && $prize_code<=7) {
?>
                <a href="" target="_blank">京东微软</a>
                <?php
                    }
                ?>

                <div class="mb2"><a class="act-but submit" href="{{route('poster',['api_token'=>request('api_token')])}}" style="color: #FFFFFF">点亮个人海报，获取礼品兑换码</a></div><br>

            </div>
        </div>
    </div>


</div><!-- /container -->
{{--<script src="<?=asset('/jy/TweenLite.min.js')?>"></script>--}}
{{--<script src="<?=asset('/jy/EasePack.min.js')?>"></script>--}}
{{--<script src="<?=asset('/jy/rAF.js')?>"></script>--}}
{{--<script src="<?=asset('/jy/demo-1.js')?>"></script>--}}
{{--<script src="<?=asset('/jy/clipboard.min.js')?>"></script>--}}
<script>
//    new Clipboard('.copy_btn');
</script>
</body>
</html>
