<?php
require_once public_path("jssdk.php");//引入相应路径下的jssdk文件
//appID
//wx1647b3429377748f
//appsecret
//7c837f2ff2887845c13558742232a43d

//第三方平台APPID：wx062a1b8f9e01e151
//微信公众号APPID：wx2055b6314cd25ac1
//skey：gb6hs2up

//$jssdk = new JSSDK("wx062a1b8f9e01e151","gb6hs2up");//按照自己的公众号填写
//$jssdk = new JSSDK("wx062a1b8f9e01e151","gb6hs2up");//按照自己的公众号填写
//$signPackage = $jssdk->GetSignPackage();


$jssdk = new JSSDK("wx062a1b8f9e01e151");//按照自己的公众号填写

$signPackage = $jssdk->GetSignPackage();

$data = array(
    'appId' => $signPackage["appId"],
    'nonceStr' => $signPackage["nonceStr"],
    'timestamp' => $signPackage["timestamp"],
    'signature' => $signPackage["signature"]);
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <script type="text/javascript" src="https://libs.baidu.com/jquery/1.7.2/jquery.min.js"></script>
    <title>地图</title>
    <style type="text/css">
        body, html{width: 100%;height: 100%; margin:0;font-family:"微软雅黑";}
        #l-map{height:300px;width:100%;}
        #r-result{width:100%;}
    </style>
</head>
<body>
haha <button onclick="a()"></button>
</body>
</html>
<script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
<script>

    var url=window.location.href;
    wx.config({
        debug:true,
        appId: '<?php echo $data["appId"];?>',
        timestamp: <?php echo $data["timestamp"];?>,
        nonceStr: '<?php echo $data["nonceStr"];?>',
        signature: '<?php echo $data["signature"];?>',
        url:url,
        jsApiList: [
            'updateAppMessageShareData',
            'updateTimelineShareData',
            'onMenuShareAppMessage',
            'onMenuShareTimeline',
            'onMenuShareQQ',
            'onMenuShareQZone'
        ]
    });
    wx.error(function(res){
        console.log(res);
        // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
    });

    wx.checkJsApi({
        jsApiList: ['updateTimelineShareData','updateAppMessageShareData'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
        success: function(res) {
            // alert(res);
            // 以键值对的形式返回，可用的api值true，不可用为false
            // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
        }
    });


    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.updateTimelineShareData({
            title: '我是自定义文案', // 分享标题
            link: 'https://mssocial.una-ad.com/api/wxs', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'https://mssocial.una-ad.com/offline/176.jpg', // 分享图标
            success: function () {
                alert('su');
                // 设置成功
            }
        })
    });


</script>

