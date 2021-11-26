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
				<h3>现在就耀，点亮海报活动兑奖页面</h3>
				<form action="#" name="f" method="post">
					<div class="input_outer">
						<span class="u_user"></span>
						<input id="name" name="logname" class="text" style="color: #FFFFFF !important" type="text" placeholder="请输入账户">
					</div>
					<div class="input_outer">
						<span class="us_uer"></span>
						<input id="pwd" name="logpass" class="text" style="color: #FFFFFF !important; position:absolute; z-index:100;"value="" type="password" placeholder="请输入密码">
					</div>
					<div class="mb2" type="button" onclick="doLogin()"><a class="act-but submit" href="javascript:;" style="color: #FFFFFF">登录</a></div>
				</form>
			</div>
		</div>
	</div>
</div><!-- /container -->
<script src="<?=asset('/jy/jquery-1.7.2.min.js')?>"></script>
<script src="<?=asset('/jy/TweenLite.min.js')?>"></script>
<script src="<?=asset('/jy/EasePack.min.js')?>"></script>
<script src="<?=asset('/jy/rAF.js')?>"></script>
<script src="<?=asset('/jy/demo-1.js')?>"></script>
<script>

	function doLogin() {

	    var name = $("#name").val();
	    var pwd = $("#pwd").val();
		if (name.length == 0) {
		    alert("请输入用户名！");
		    return false;
		}
		if (pwd.length == 0) {
		    alert("密码不能为空！");
		    return false;
		}


        $.ajax({
            type: "POST",
            url: "{{route('check-online', ['kf_token'=>request('kf_token')])}}",
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "name": name,
                "pwd": pwd
            },
            success: function (data) {
                if(data.code == '200'){
                    {{--window.location="{{route('exchange-code', ['kf_token'=>data.token])}}";--}}
                    window.location="/api/exchange-code?kf_token="+data.token;
                } else {
					alert("用户名密码错误！")
                }
            },
//            error: function(request, status, error){
//                alert(error);
//            },
        });
    }

</script>
	</body>
</html>
