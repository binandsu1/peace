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
	<style>

		@media only screen and (min-width: 320px) {
			.demo-1 .large-header {
				background-image: url("<?= asset('/jy/home-bg1.jpg')?>");
				background-size: 20rem ;
				width: 20rem;
				height: 40rem;
				background-repeat: no-repeat;
				position: fixed;
			}

			.logo_box_home{
				width: 20rem;
				height: 30rem;
				padding: 1rem;
				position: absolute;
				left: 50%;
				top:50%;
				margin-left: -10rem;
				margin-top: 2rem;
				font-size: 0.9rem;
			}
		}

		@media only screen and (min-width: 360px) {
			.demo-1 .large-header {
				background-image: url("<?= asset('/jy/home-bg1.jpg')?>");
				background-size: 22.5rem ;
				width: 22.5rem;
				height: 48rem;
				background-repeat: no-repeat;
				position: fixed;
			}

			.logo_box_home{
				width: 20rem;
				height: 30rem;
				padding: 1rem;
				position: absolute;
				left: 50%;
				top:50%;
				margin-left: -10rem;
				margin-top: 2rem;
				font-size: 0.9rem;
			}
		}

		@media only screen and (min-width: 375px) and (min-height: 667px){
			.demo-1 .large-header {
				background-image: url("<?= asset('/jy/home-bg1.jpg')?>");
				background-size: 375px ;
				width: 375px;
				height: 750px;
				background-repeat: no-repeat;
				position: fixed;
			}

			.logo_box_home{
				width: 380px;
				height: 700px;
				padding: 35px;
				position: absolute;
				left: 50%;
				top:50%;
				margin-left: -190px;
				margin-top: 80px;
			}
		}

		@media only screen and (min-width: 375px) and (min-height: 812px){
			.demo-1 .large-header {
				background-image: url("<?= asset('/jy/home-bg1.jpg')?>");
				background-size: 24rem ;
				width: 24rem;
				height: 51rem;
				background-repeat: no-repeat;
				position: fixed;
			}

			.logo_box_home{
				width: 24rem;
				height: 50rem;
				padding: 2.2rem;
				position: absolute;
				left: 50%;
				top:50%;
				margin-left: -12rem;
				margin-top: 6rem;
			}

		}
		@media only screen and (min-width: 414px){
			.demo-1 .large-header {
				background-image: url("<?= asset('/jy/home-bg1.jpg')?>");
				background-size: 414px ;
				width: 414px;
				height: 820px;
				background-repeat: no-repeat;
				position: fixed;
			}

			.logo_box_home{
				width: 380px;
				height: 800px;
				padding: 35px;
				position: absolute;
				left: 50%;
				top:50%;
				margin-left: -190px;
				margin-top: 100px;
			}
		}
		@media only screen and (min-width: 768px){
			.demo-1 .large-header {
				background-image: url("<?= asset('/jy/home-bg1.jpg')?>");
				background-size: 768px 1024px;
				width: 768px;
				height: 1024px;
				background-repeat: no-repeat;
				position: fixed;
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
					<div class="logo_box_home">
						<form action="#" name="f" method="post">
							<div class="mb2"><a class="act-but submit" onclick="up()" style="color: #744323">线 上 点 亮</a></div>
							<div class="mb2"><a class="act-but2 submit" onclick="down()" style="color: #744323">线 下 点 亮</a></div>
							<input id="sqbtn" type="checkbox" style="font-size: 0.8rem"> 我已阅读并同意<a style="color:red;" href="{{route('agreement',['api_token'=>request('api_token')])}}">《用户协议与隐私条款》</a>
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
