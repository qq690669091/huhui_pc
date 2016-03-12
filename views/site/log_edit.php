<?php 
use yii\helpers\Url;
 ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>修改交易密码</title>
    <meta name="keywords" >
    <meta name="description" >

    <link href="css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css?v=4.3.0" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=2.2.0" rel="stylesheet">

</head>

<body class="gray-bg pr" style="background:url(img/set.jpg) no-repeat center center;">
    <div class="zhezhao po" ></div>
    <div class=" text-center loginscreen  animated fadeInDown" style="width:100%;height:auto;padding-top:5px;">
        <div style="width:600px;margin: 0 auto;">
            <div>

                <h1 class="logo-name" style="color:#00abf3;margin-left:153px;">Hh</h1>

            </div>
            <h2 style="color:#fff;margin-left:153px;">修改登录密码</h2>

            <form action="<?=Url::toRoute('site/log_edit')?>" method="POST" >
                <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">原登录密码：</span>
                    <input type="password" class="number fl h_form_control" style="width:360px;" name="log_pwd" minlength="6"  maxlength="20" placeholder="请输入登陆密码" required >                   
                </div>
                
                <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">新登录密码：</span>
                    <input type="password" class="number fl h_form_control" style="width:360px;" name="new_pwd1" minlength="6"  maxlength="20" placeholder="请设置6~20位登陆密码" required>  
                    <input type="hidden" class="inputs " name="_csrf" value="<?= Yii::$app->request->csrfToken ?>" placeholder="请设置6~20位登录密码">                 
                </div>

                <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">确认信交易密码：</span>
                    <input type="password" class="number fl h_form_control" style="width:360px;" name="new_pwd2"  minlength="6"  maxlength="20"  placeholder="请输入新设置的密码" required>                   
                </div>
                
                <input type="submit" id="submit" value="提交" class="l_zhanghao_bg" style="width:160px;">
                <input type="button"  value="返回"  onclick="window.history.back(-1);" class="l_zhanghao_bg" style="width:160px;">
            </form>
        </div>
    </div>

  

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js?v=3.4.0"></script>
    <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script><!--统计代码，可删除-->
   
</body>

</html>
