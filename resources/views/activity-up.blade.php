<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>login</title>
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
                <h1>立下属于你的新年flag</h1>
              	
        <form class="form-horizontal" method="post" action="<?=route('lucky-draw')?>">
            <div class="input-group">
                <input type="text" name="flag" class="form-control" placeholder="请输入flag" aria-describedby="basic-addon1">
            </div>

            <br>
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true">
                    请选择 flag
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="{{route('lucky-draw',['flag'=>'帝国'])}}">帝国</a></li>
                    <li><a href="{{route('lucky-draw',['flag'=>'约德尔'])}}">约德尔</a></li>
                    <li><a href="{{route('lucky-draw',['flag'=>'战斗学院'])}}">战斗学院</a></li>
                    <li><a href="{{route('lucky-draw',['flag'=>'格斗家'])}}">格斗家</a></li>
                </ul>
            </div>
	  <br>
<div class="mb2"><a class="act-but submit" href="{{route('activity-up')}}" style="color: #FFFFFF">立下Flag 参与抽奖</a></div>
            <!--<button type="submit" class="btn btn-success">go</button>-->
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
