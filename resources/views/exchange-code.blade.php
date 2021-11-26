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
						<span class="us_uer"></span>
						<input id="exchange_code" class="text" style="color: #FFFFFF !important; position:absolute; z-index:100;"value="" type="text" placeholder="请输入兑奖码">
					</div>
					<div class="mb2" type="button" onclick="exchangeCode()"><a class="act-but submit" href="javascript:;" style="color: #FFFFFF">兑奖</a></div>
				</form>
				<br><br>
				<span id="prize_info"></span>
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
    function exchangeCode() {

        $("#prize_info").text("");
        var code = $("#exchange_code").val();
        if (code.length == 0) {
            alert("兑奖码不能为空！");
            return false;
        }

        $.ajax({
            type: "POST",
            {{--url: "{{ url('/api/check-code') }}",--}}
            url: "{{route('check-code', ['kf_token'=>request('kf_token')])}}",
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "code": code
            },
            success: function (data) {
                if(data.code == 200){
                    $("#prize_info").text("奖品为 "+data.result+" 尚未兑奖！");
                    $("#use_code_btn").css('display', 'block');
                } else if(data.code == 300) {
                    $("#prize_info").text("此兑奖码已使用过！请勿重复兑奖！已发放奖品： "+data.result);
                    $("#use_code_btn").css('display', 'none');
				} else if(data.code == 500) {
                    $("#prize_info").text("无效兑奖码");
                } else {
                    alert('状态错误!');
				}
            }
        });
    }

</script>
</body>
</html>
