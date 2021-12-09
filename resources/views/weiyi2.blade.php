<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <script type="text/javascript" src="//api.map.baidu.com/api?type=webgl&v=1.0&ak=6ho8muDORIA2j1TNIvyG5F8Now40OPLg"></script>
    <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=6ho8muDORIA2j1TNIvyG5F8Now40OPLg"></script>
    <script type="text/javascript" src="https://libs.baidu.com/jquery/1.7.2/jquery.min.js"></script>
    <title>线下授权门店列表</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</head>
<style>

    a:link {
        color:white;
        text-decoration:none;
    }

    a:visited {
        color:white;
        text-decoration:none;
    }

    a:hover {
        color:white;
        text-decoration:none;
    }

    a:active {
        color:white;
        text-decoration:none;
    }

    </style>
<body>
<h4>&nbsp;&nbsp;&nbsp;<span id="city_name"></span>的微软授权店地址如下：</h4>
<b><span id="city" style="height: 30rem;font-size: small"></span></b>

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
//            alert('当前城市:'+city);
            $("#city_name").text(city);
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
                        // alert(n.j);return false;
                             var url= "store-map3?j="+n.j+"&w="+n.w;

                            $("#list-group").append(" <li class=\"list-group-item\"><span class=\"badge\"><a href=\""+url+"\">跳转地图</a></span>"+n.store_name+"</li>");
                            console.log('索引' + i + ';对应值为：' + n.store_name +';');
                    });
                },

            });

        }, function(e) {
            alert("获取定位位置信息失败");
        }, {provider: 'baidu'});
    }

</script>

