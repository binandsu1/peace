<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <script type="text/javascript" src="//api.map.baidu.com/api?type=webgl&v=1.0&ak=6ho8muDORIA2j1TNIvyG5F8Now40OPLg"></script>
    <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=6ho8muDORIA2j1TNIvyG5F8Now40OPLg"></script>
    <script type="text/javascript" src="https://libs.baidu.com/jquery/1.7.2/jquery.min.js"></script>
    <title>地图</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</head>
<body>
<span id="city"></span>
<ul class="list-group" id="list-group">
</ul>
</body>
</html>
<script type="text/javascript">
    window.onload = dz();

    function dz() {
        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function getinfo(position){
            // console.log(position);
            city = position.address.city;
            province = position.address.province;
            alert('当前城市:'+city);
            $.ajax({
                type: "GET",
                url: "{{route('store-map-list',['api_token'=>request('api_token')])}}",
                dataType: 'json',
                header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    "city":city,
                },
                success: function (data) {
                     console.log(data);
                    $.each(data,function(i,n){
                            $("#list-group").append(" <li class=\"list-group-item\"><span class=\"badge\">"+n.store_id+"</span>"+n.store_name+"</li>");
                            console.log('索引' + i + ';对应值为：' + n.store_name +';');
                    });
                },

            });

        }, function(e) {
            alert("获取百度定位位置信息失败");
        }, {provider: 'baidu'});
    }

</script>

