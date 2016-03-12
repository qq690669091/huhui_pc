<?php 
use yii\helpers\Url;
 ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>注册</title>
    <meta name="keywords" >
    <meta name="description" >

    <link href="css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css?v=4.3.0" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=2.2.0" rel="stylesheet">

</head>

<body class="gray-bg pr" style="background:url(img/zhuce.jpg) no-repeat center center;">
    <div class="zhezhao po" ></div>
    <div class=" text-center loginscreen  animated fadeInDown" style="width:100%;height:auto;padding:5px 0 70px;">
        <div style="width:600px;margin: 0 auto;">
            <div>

                <h1 class="logo-name" style="color:#00abf3;margin-left:153px;">Hh</h1>

            </div>
            <h2 style="color:#fff;margin-left:153px;">注册</h2>

            <form class="m-t" role="form" action="<?=Url::toRoute('site/adduser')?>" method="post">
                <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">用户名：</span>
                    <input type="text" class="number fl h_form_control account" style="width:360px;" name="account" minlength="1" maxlength="20" placeholder="6-20个字符，必须字母和数字的结合" required autofocus="autofocus">                   
                </div>

                <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">登录密码：</span>
                    <input type="password" class="number fl h_form_control" style="width:360px;" name="pwd1" minlength="6" maxlength="20" placeholder="请设置6~20位登录密码" required>                   
                </div>

                 <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">确认登录密码：</span>
                    <input type="password" class="number fl h_form_control" style="width:360px;"  name="pwd2" minlength="6" maxlength="20"  placeholder="请设置6~20位登录密码" required>                   
                </div>

                <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">交易密码：</span>
                    <input type="password" class="number fl h_form_control" style="width:360px;" name="pwd3" minlength="6" maxlength="20"  placeholder="请设置6~20位交易密码" required>                   
                </div>
                
                <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">确认交易密码：</span>
                    <input type="password" class="number fl h_form_control" style="width:360px;" name="pwd4" minlength="6" maxlength="20"   placeholder="请设置6~20位交易密码"  requried>                   
                </div>

                <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">介绍人用户名：</span><?php $name = Yii::$app->session['parent_name'];$parent_id = Yii::$app->session['parent_id'];?>
                    <input type="hidden" name="parent_id" value="<?=$parent_id ? $parent_id : 0?>" />
                    <input type="text" class="number fl h_form_control" style="width:360px;" value="<?php if($name) echo $name;else if($parent_id) echo $parent_id;else echo "系统默认"; ?>" disabled>
                    <input type="hidden" class="inputs " name="_csrf" value="<?= Yii::$app->request->csrfToken ?>" placeholder="请设置6~20位登录密码">                   
                </div>
                
                <input type="submit" id="submit" value="注册" class="l_zhanghao_bg" style="width:160px;">
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
	$(".account").change(function(){
		var 
			username  =	$(this).val();
			$this  = $(this);
			data      =  {
				_csrf:"<?= Yii::$app->request->csrfToken ?>",
				username :username,
			};
		$.post("<?= Url::toRoute('site/testuser');?>",data,function(msg){
				if(msg.status ==1){
					alert(msg.message);
					$this.select(); 
					$this.focus(); 
				}
			},'json')
		})

		$('#submit').click(function(){
			var pwd1 = $("input[name='pwd1']").val();
			var pwd2 = $("input[name='pwd2']").val();
			var pwd3 = $("input[name='pwd3']").val();
			var pwd4 = $("input[name='pwd4']").val();
	   	 	if(pwd1  !== pwd2){
       	 	    alert('两次登陆密码不一致,请重新输入');return false;
       	 	}
       	 	 if(pwd3  !== pwd4){
       	 	    alert('两次交易密码不一致,请重新输入');return false;
       	 	}
	})
    </script>
</body>

</html>
