<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>现在就耀，与现同框</title>


<!--[if IE]>
    <script src="<?=asset('/jy/html5.js')?>"></script>
    <![endif]-->
</head>
<body>
<div class="container demo-1">




                <h1>phone</h1>
                <form class="form-horizontal" method="post" action="<?=route('phone',['api_token'=>request('api_token')])?>" enctype="multipart/form-data">

                    <input type="file" name="image" accept="image/*" capture="camera">


                    <button type="submit" class="btn btn-success">开始上传</button>
                </form>
                <img width="300px" height="300px" src="<?= asset('/offline/'.$userinfo->pic_name)?>" class="img-rounded">
                {{--  <img width="300px" height="300px" src="http://peace.local/{{$image->path}}" class="img-rounded">--}}





</div><!-- /container -->
</body>
</html>
