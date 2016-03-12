<?php 
use yii\helpers\Url;
 ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>登录</title>
    <meta name="keywords" >
    <meta name="description" >

    <link href="css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css?v=4.3.0" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=2.2.0" rel="stylesheet">

</head>

<body class="gray-bg" style="background:url(img/change.jpg) no-repeat center center;">
    <div class="zhezhao po"></div>
    <div class=" text-center loginscreen  animated fadeInDown" style="width:100%;height:auto;padding-top:80px;">
        <div style="width:600px;margin:80px auto 0;">
            <div>

                <h1 class="logo-name" style="color:#00abf3;margin-left:153px;">Hh</h1>

            </div>
            <h3 style="color:#fff;margin-left:153px;">重置成功</h3>

            <form class="m-t" role="form" >
                <div class="h_steps pr" style="margin-left:231px;">
                    <span class="h_circle dk po complete" style="top:0;left:0;">1</span>
                    <span class="h_circle dk po complete" style="left:140px;">2</span>
                    <span class="h_circle dk po complete" style="left:270px;">3</span>
                    <span class="h_duan po complete"></span>
                    <span class="h_duan po complete" style="left:160px;"></span>
                    

                </div>
                <p class="h_tishi">
                    <span class="fl" style="margin-left:196px;">验证码</span>
                    <span class="fl" style="margin-left:80px;">重置密码</span>
                    <span class="fl" style="margin-left:80px;">完成</span>
                </p>
                
                <p class="h_ok">密码重置成功</p>
                <p class="h_wenzi" id="time">3秒后自动跳转回登录页面……</p>
                
           

            </form>
        </div>
    </div>

  

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script>
    setTimeout("location.href='<?= Url::toRoute('site/index');?>'",3000);
    </script>
</body>

</html>
