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
						<h3>点亮海报活动</h3><br><br><br>
						<form action="#" name="f" method="post">
							<div class="mb2"><a class="act-but submit" onclick="up()" style="color: #FFFFFF">线上点亮</a></div><br>
							<div class="mb2"><a class="act-but submit" onclick="down()" style="color: #FFFFFF">线下点亮</a></div>
							<input id="sqbtn" type="checkbox"> 我已阅读并同意<a style="color:red;" href="{{route('agreement',['api_token'=>request('api_token')])}}">《用户协议与隐私条款》</a>
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
//			var $sq = $("#sqbtn").val();


            function up() {

                if (!$("#sqbtn").prop('checked')) {
                    alert("请先阅读并同意《用户协议与隐私条款》");
                    return false;
                }

				window.location="{{route('activity-up',['api_token'=>request('api_token')])}}";

			}

			function down() {

                if (!$("#sqbtn").prop('checked')) {
                    alert("请先阅读并同意《用户协议与隐私条款》");
                    return false;
                }

                window.location="{{route('activity-down',['api_token'=>request('api_token')])}}";

			}
		</script>
	</body>
</html>
