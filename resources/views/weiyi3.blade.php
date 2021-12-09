<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="//api.map.baidu.com/api?type=webgl&v=1.0&ak=6ho8muDORIA2j1TNIvyG5F8Now40OPLg"></script>
    <title>根据经纬度定位</title>
    <style>
        html, body, #allmap{
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }
        #result{
            padding: 7px 10px;
            position: fixed;
            top: 10px;
            left: 20px;
            width: 450px;
            background: #fff;
            box-shadow: 0 2px 6px 0 rgba(27, 142, 236, 0.5);
            border-radius: 7px;
            z-index: 99;
        }
        #result input{
            width:130px;
            margin-right:10px;
            height:25px;
            border: 1px solid rgba(27, 142, 236, 0.5);
            border-radius: 5px;
        }
        #result button{
            border: 1px solid rgba(27, 142, 236, 0.5);
            border-radius: 5px;
            background: rgba(27, 142, 236, 0.5);
            color: #fff
        }
    </style>
</head>
<body>
<div id='allmap' style=""></div>
     <input id="lng" type="hidden" value="{{request('j')}}"/>
     <input id="lat" type="hidden" value="{{request('w')}}"/>
<script>
    // 百度地图API功能
    var map = new BMapGL.Map("allmap");
    map.centerAndZoom(new BMapGL.Point(116.331398,39.897445),11);
    map.enableScrollWheelZoom(true);
    window.onload = theLocation();

    // 用经纬度设置地图中心点
    function theLocation(){

        if(document.getElementById("lng").value != "" && document.getElementById("lat").value != ""){
            map.clearOverlays();
            var new_point = new BMapGL.Point(document.getElementById("lng").value,document.getElementById("lat").value);
            var marker = new BMapGL.Marker(new_point);  // 创建标注
            map.addOverlay(marker);              // 将标注添加到地图中
            map.panTo(new_point);
        }
    }
</script>
</body>
</html>
