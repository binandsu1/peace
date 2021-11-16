<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>输入提示后查询</title>
{{--    <link rel="stylesheet" href="https://cache.amap.com/lbs/static/main1119.css"/>--}}
    <script type="text/javascript"
            src="https://webapi.amap.com/maps?v=1.4.15&key=2219e657cb9af608c613f57dabd81523&plugin=AMap.Autocomplete,AMap.PlaceSearch"></script>
    <script type="text/javascript" src="https://cache.amap.com/lbs/static/addToolbar.js"></script>

<style>
    .info{
        width:26rem;
    }
</style>
<link rel="stylesheet" href="https://a.amap.com/jsapi_demos/static/demo-center/css/demo-center.css" />
</head>
<body>
<div style="height: 500px;width: 500px; ">


    <div id="container" style="height: 200px;width: 500px;"></div>
    <div id="myPageTop" style="height: 200px;width: 500px;">
        <table>
            <tr>
                <td>
                    <label>请输入关键字： 微软门店   微软售后服务站  </label>
                </td>
            </tr>
            <tr>
                <td>
                    <input id="tipinput" />
                </td>
            </tr>
        </table>
    </div>


    <div id="panel" style="height: 200px;width: 500px;"></div>

{{--    <div class="info" style="height: 200px;width: 500px;">--}}
{{--        <h4 id='status'></h4><hr>--}}
{{--        <p id='result'></p><hr>--}}
{{--        <p ></p>--}}
{{--    </div>--}}

</div>

<script type="text/javascript">
    //地图加载
    var map = new AMap.Map("container", {
        resizeEnable: true
    });
    //输入提示
    var autoOptions = {
        input: "tipinput"
    };
    var auto = new AMap.Autocomplete(autoOptions);
    var placeSearch = new AMap.PlaceSearch({
        map: map
    });  //构造地点查询类
    AMap.event.addListener(auto, "select", select);//注册监听，当选中某条记录时会触发
    function select(e) {
        placeSearch.setCity(e.poi.adcode);
        placeSearch.search(e.poi.name);  //关键字查询查询
    }

    //后期定位的
    AMap.plugin('AMap.Geolocation', function() {
        var geolocation = new AMap.Geolocation({
            enableHighAccuracy: true,//是否使用高精度定位，默认:true
            timeout: 10000,          //超过10秒后停止定位，默认：5s
            buttonPosition:'RB',    //定位按钮的停靠位置
            buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
            zoomToAccuracy: true,   //定位成功后是否自动调整地图视野到定位点

        });
        map.addControl(geolocation);
        geolocation.getCurrentPosition(function(status,result){
            if(status=='complete'){
                onComplete(result)
            }else{
                onError(result)
            }
        });
    });
    //解析定位结果
    function onComplete(data) {
        // document.getElementById('status').innerHTML='定位成功'
        // var str = [];
        // str.push('定位结果：' + data.position);
        // str.push('定位类别：' + data.location_type);
        // if(data.accuracy){
        //     str.push('精度：' + data.accuracy + ' 米');
        // }//如为IP精确定位结果则没有精度信息
        // str.push('是否经过偏移：' + (data.isConverted ? '是' : '否'));
        // document.getElementById('result').innerHTML = str.join('<br>');
    }
    //解析定位错误信息
    function onError(data) {
        // document.getElementById('status').innerHTML='定位失败'
        // document.getElementById('result').innerHTML = '失败原因排查信息:'+data.message;
    }


    //周边搜索

    AMap.service(["AMap.PlaceSearch"], function() {
        //构造地点查询类
        var placeSearch = new AMap.PlaceSearch({
            type: '餐饮服务', // 兴趣点类别
            pageSize: 5, // 单页显示结果条数
            pageIndex: 1, // 页码
            city: "010", // 兴趣点城市
            citylimit: true,  //是否强制限制在设置的城市内搜索
            map: map, // 展现结果的地图实例
            panel: "panel", // 结果列表将在此容器中进行展示。
            autoFitView: true // 是否自动调整地图视野使绘制的 Marker点都处于视口的可见范围
        });

        var cpoint = [116.405467, 39.907761]; //中心点坐标
        placeSearch.searchNearBy('', cpoint, 200, function(status, result) {

        });
    });
</script>
</body>
</html>



