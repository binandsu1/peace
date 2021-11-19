<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>关键字搜索</title>
</head>
<script charset="utf-8" src="https://map.qq.com/api/gljs?v=1.exp&libraries=service&key=AJ3BZ-V4IWF-J4FJD-N2BMG-7AAR5-VPFEW"></script>
<style type="text/css">
    html,
    body {
        height: 100%;
        margin: 0px;
        padding: 0px;
    }

    #container {
        width: 100%;
        height: 100%;
    }
    #panel {
        position: absolute;
        background: #FFF;
        width:350px;
        padding: 20px;
        z-index: 9999;
        top: 30px;
        left: 30px;
    }
</style>

<body>
<div id="container"></div>
<div id="panel">
    <p>输入关键字，按下搜索，将在屏幕展示的地图范围中搜索相关地点。</p>
    <input id='keyword' type="text" value='地铁站' ><input id="search" type="button" class="btn" value="搜索" onclick="searchByKeyword()" />
</div>
</body>
<script type="text/javascript">
    var map = new TMap.Map('container', {
        zoom: 14,
        center: new TMap.LatLng(40.0402718, 116.2735831),
    });
    var search = new TMap.service.Search({ pageSize: 10 }); // 新建一个地点搜索类
    var markers = new TMap.MultiMarker({
        map: map,
        geometries: [],
    });
    var infoWindowList = Array(10);

    function searchByKeyword() {
        infoWindowList.forEach((infoWindow) => {
            infoWindow.close();
        });
        infoWindowList.length = 0;
        markers.setGeometries([]);
        // 在地图显示范围内以给定的关键字搜索地点
        search
            .searchRectangle({
                keyword: document.getElementById('keyword').value,
                bounds: map.getBounds(),
            })
            .then((result) => {
                result.data.forEach((item, index) => {
                    var geometries = markers.getGeometries();
                    var infoWindow = new TMap.InfoWindow({
                        map: map,
                        position: item.location,
                        content: `<h3>${item.title}</h3><p>地址：${item.address}</p><p>电话：${item.tel}</p>`,
                        offset: { x: 0, y: -50 },
                    }); // 新增信息窗体显示地标的名称与地址、电话等信息
                    infoWindow.close();
                    infoWindowList[index] = infoWindow;
                    geometries.push({
                        id: String(index), // 点标注数据数组
                        position: item.location,
                    });
                    markers.updateGeometries(geometries); // 绘制地点标注
                    markers.on('click', (e) => {
                        infoWindowList[Number(e.geometry.id)].open();
                    }); // 点击标注显示信息窗体
                });
            });
    }
</script>

</html>
