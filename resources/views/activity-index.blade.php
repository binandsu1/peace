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
		/*@media screen and (min-width:320px){font-size: 12px;}*/
		/*@media screen and (min-width:360px){font-size: 14px;}*/
		/*@media screen and (min-width:420px){font-size: 16px;}*/
		/*@media screen and (min-width:480px){font-size: 20px;}*/
		/*@media screen and (min-width:520px){font-size: 24px;}*/
		/*@media screen and (min-width:640px){font-size: 28px;}*/
		/*@media screen and (min-width:750px){font-size: 32px;}*/

			.demo-1 .large-header {
				{{--background-image: url("<?= asset('/jy/home-1280.jpg')?>");--}}
				{{--background-image: url("<?= asset('/jy/new-bgP.jpg')?>");--}}
				background-size: 100vw 100vh;
				width: 100vw;
				height: 100vh;
				background-repeat: no-repeat;
				position: fixed;
			}

			.logo_box_home {
				width: 90vw;
				height: 100vh;
				padding: 4vh;
				position: fixed;
				left: 50%;
				top: 50%;
				margin-left: -44vw;
				margin-top: 10vh;
			}

			.btn-2 {
				width: 100vw;
				height: 22vh;
				padding: 1vh;
				position: fixed;
				overflow: hidden;
				left: 50%;
				top: 100%;
				margin-left: -36vw;
				margin-top: -19vh;
				font-size: 0.5em;
				/*text-align: center;*/
				transform: scale(.75);
				transform-origin: left;
			}

		@media only screen and (max-width: 375px) and (min-height: 812px) {
			.demo-1 .large-header {
				{{--background-image: url("<?= asset('/jy/home-bg1.jpg')?>");--}}
				{{--background-image: url("<?= asset('/jy/new-bgX.jpg')?>");--}}
				background-size: 100vw 100vh;
				width: 100vw;
				height: 100vh;
				background-repeat: no-repeat;
				position: fixed;
			}

			.logo_box_home {
				width: 90vw;
				height: 100vh;
				padding: 4vh;
				position: fixed;
				left: 50%;
				top: 50%;
				margin-left: -44vw;
				margin-top: 8vh;
			}

			.btn-2 {
				width: 90vw;
				height: 24vh;
				padding: 1vh;
				position: fixed;
				overflow: hidden;
				left: 50%;
				top: 100%;
				margin-left: -32vw;
				margin-top: -22vh;
				font-size: 0.5em;
				transform: scale(.76);
				transform-origin: left;
				/*text-align: center;*/
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
						</form>
						<div class="mb2 btn-2">
							<p>
								活动说明：
							</p>
							<p>
								1、参与“线上点亮”活动用户可直接通过活动页面抽奖，获得上海报与李现同框的机会，或其他对应奖项；“线下点亮”活动用户通过活动页面抽奖后，到微软线下授权经销商门店参与活动，并领取奖品。
							</p>
							<p>
								2、“线上点亮”海报用参与者授权的微博或微信ID名作为海报组成元素；“线下点亮”特殊海报使用用户在线下参与活动后授权的拍照照片作为海报组成元素。
							</p>
							<p>
								<br/>
							</p>
						</div>
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
            $(document).ready(function(){

                var w = $(document).width(); //浏览器当前窗口文档的高度
                var h = $(document).height(); //浏览器当前窗口文档的高度
                var b = h/w;
                var size = b.toFixed(2);

                var type = "";

                if (size < 1.87) {
                    type = "P";
                } else {
                    type = "X";
                }


                var url = "<?= asset('/jy/new-bg')?>";

                var bg_image = url+type+".jpg";
//        alert(bg_image);

                $('#large-header').css('background-image',('url("'+bg_image+'")'));

            });


            function up() {

				window.location="{{route('activity-up',['api_token'=>request('api_token')])}}";

			}

			function down() {

                window.location="{{route('activity-down',['api_token'=>request('api_token')])}}";

			}
		</script>
	</body>
</html>
