<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <script type="text/javascript" src="//api.map.baidu.com/api?type=webgl&v=1.0&ak=6ho8muDORIA2j1TNIvyG5F8Now40OPLg"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=6ho8muDORIA2j1TNIvyG5F8Now40OPLg"></script>
    <script type="text/javascript" src="http://libs.baidu.com/jquery/1.7.2/jquery.min.js"></script>
    <title>地图</title>
    <style type="text/css">
        body, html{width: 100%;height: 100%; margin:0;font-family:"微软雅黑";}
        #l-map{height:300px;width:100%;}
        #r-result{width:100%;}
    </style>
</head>
<body>
<div id="l-map"></div>
<button onclick="gs('微软门店')">微软查询</button>
<button onclick="gs('微软售后')">售后服务站</button>

<div id="r-result"></div>

<div id="allmap"></div>
</body>
</html>
<script type="text/javascript">
    window.onload = gs('微软门店');
    // 百度地图API功能
    function gs(g){
        //list
        var map = new BMapGL.Map("l-map");            // 创建Map实例
        map.centerAndZoom(new BMapGL.Point(116.404, 39.915), 11);
        var local = new BMapGL.LocalSearch(map, {
            renderOptions: {map: map, panel: "r-result"}
        });
        local.search(g);
        //经纬
        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function(r){

            if(this.getStatus() == BMAP_STATUS_SUCCESS){
                var mk = new BMap.Marker(r.point);
                map.addOverlay(mk);
                map.panTo(r.point);
                // alert('您的位置：'+r.point.lng+','+r.point.lat);
                theLocation(r.point.lng,r.point.lat);
            }
            else {
                alert('failed'+this.getStatus());
            }
        });
        map.enableScrollWheelZoom(true);

        // 用经纬度设置地图中心点
        function theLocation(x,y) {
            console.log(x);
            console.log(y);
            if (x && y) {
                map.clearOverlays();
                var new_point = new BMapGL.Point(x, y);
                var marker = new BMapGL.Marker(new_point);  // 创建标注
                map.addOverlay(marker);              // 将标注添加到地图中
                map.panTo(new_point);
            }
        }


    }


</script>

