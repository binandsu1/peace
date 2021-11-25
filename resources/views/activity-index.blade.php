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
						<h1>现在就<span style="color:red;">耀</span></h1>
						<h3>点亮海报活动111</h3><br><br><br>
						<form action="#" name="f" method="post">
							<!--<div class="input_outer">-->
								<!--<span class="u_user"></span>-->
								<!--<input name="logname" class="text" style="color: #FFFFFF !important" type="text" placeholder="请输入账户">-->
							<!--</div>-->
							<!--<div class="input_outer">-->
								<!--<span class="us_uer"></span>-->
								<!--<input name="logpass" class="text" style="color: #FFFFFF !important; position:absolute; z-index:100;"value="" type="password" placeholder="请输入密码">-->
							<!--</div>-->
							<div class="mb2"><a class="act-but submit" href="{{route('activity-up',['api_token'=>request('api_token')])}}" style="color: #FFFFFF">线上点亮</a></div><br>
							<div class="mb2"><a class="act-but submit" href="{{route('activity-down')}}" style="color: #FFFFFF">线下点亮</a></div>
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
