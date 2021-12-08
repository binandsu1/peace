<?php
require_once public_path("jssdk.php");//引入相应路径下的jssdk文件
//appID
//wx1647b3429377748f
//appsecret
//7c837f2ff2887845c13558742232a43d
$jssdk = new JSSDK("wx1647b3429377748f","7c837f2ff2887845c13558742232a43d");//按照自己的公众号填写
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
haha
</body>
</html>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
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
            "onMenuShareTimeline", //分享给好友
            "onMenuShareAppMessage", //分享到朋友圈
            "onMenuShareQQ",  //分享到QQ
            "onMenuShareWeibo" //分享到微博
        ]
    });

    wx.ready(function (){
        // alert(111);
        var shareData = {
            title: '标题',
            desc: ' 摘要',
            link: url,
            imgUrl: '图片url'};
        // wx.onMenuShareAppMessage(shareData);
        // wx.onMenuShareTimeline(shareData);
        // wx.onMenuShareQQ(shareData);
        // wx.onMenuShareWeibo(shareData);

        wx.onMenuShareAppMessage({
            title: '标题',
            desc: '标题',
            link: '标题',
            imgUrl: '标题',
            trigger: function (res) {
                // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
                alert('用户点击发送给朋友');
            },
            success: function (res) {
                alert('已分享');
            },
            cancel: function (res) {
                alert('已取消');
            },
            fail: function (res) {
                alert(JSON.stringify(res));
            }
        });



    });

</script>

