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
        <div style="width:600px;margin:0 auto 0;">
            <div>

                <h1 class="logo-name" style="color:#00abf3;margin-left:153px;">Hh</h1>

            </div>
            <h3 style="color:#fff;margin-left:153px;">重置密码</h3>

                <div class="h_steps pr" style="margin-left:231px;">
                    <span class="h_circle dk po complete" style="top:0;left:0;">1</span>
                    <span class="h_circle dk po complete" style="left:140px;">2</span>
                    <span class="h_circle dk po yet" style="left:270px;">3</span>
                    <span class="h_duan po complete"></span>
                    <span class="h_duan po " style="left:160px;"></span>
                    

                </div>
                <p class="h_tishi">
                    <span class="fl" style="margin-left:196px;">验证码</span>
                    <span class="fl" style="margin-left:80px;">重置密码</span>
                    <span class="fl" style="margin-left:80px;">完成</span>
                </p>
            <form action="<?=Url::toRoute('site/new_pwd')?>" method="POST">
                <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">新密码：</span>
                    <input type="password" class="number fl h_form_control" style="width:360px;" name="pwd" minlength="6" maxlength="20" placeholder="请设置6~20位登录密码" required autofocus="autofocus"> 
                    <input type="hidden" class="inputs " name="_csrf" value="<?= Yii::$app->request->csrfToken ?>" placeholder="请设置6~20位登录密码">                  
                </div>

                 <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">确认新密码：</span>
                    <input type="password" class="number fl h_form_control" style="width:360px;" minlength="6" maxlength="20" name="pwd_two" placeholder="确认登录密码" required>                   
                </div>
        
                 <input type="submit" id="submit" value="下一步" class="l_zhanghao_bg" style="width:160px;">
                 <input type="button"  value="上一步"  onclick="window.history.back(-1);" class="l_zhanghao_bg" style="width:160px;">
            </form>
        </div>
    </div>

  

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js?v=3.4.0"></script>
    <script src="js/tan.js"></script>
    <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script><!--统计代码，可删除-->
   <script>
        $('#submit').click(function(){
            var pwd1 = $("input[name='pwd']").val();
            var pwd2 = $("input[name='pwd_two']").val();
            if(pwd1  !== pwd2){
                alert('两次登陆密码不一致,请重新输入');return false;
            }
    })
   </script>
</body>

</html>
