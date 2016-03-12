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
            <h3 style="color:#fff;margin-left:153px;">忘记密码-验证码</h3>

                <div class="h_steps pr" style="margin-left:231px;">
                    <span class="h_circle dk po complete" style="top:0;left:0;">1</span>
                    <span class="h_circle dk po yet" style="left:140px;">2</span>
                    <span class="h_circle dk po yet" style="left:270px;">3</span>
                    <span class="h_duan po"></span>
                    <span class="h_duan po " style="left:160px;"></span>
                    

                </div>
                <p class="h_tishi">
                    <span class="fl" style="margin-left:196px;">验证码</span>
                    <span class="fl" style="margin-left:80px;">重置密码</span>
                    <span class="fl" style="margin-left:80px;">完成</span>
                </p>
                <div class="inputs">
                    <span class="h_title fl" style="color:#fff;" >手机号：</span>
                    <input type="text" class="number fl h_form_control" id="phone" placeholder="请输入手机号">
                    <input type="text" class="code fl" value="发送验证码" id="time" style="height:50px;line-height:50px;" >
                </div>

                <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">验证码：</span>
                    <input type="text" class="number fl h_form_control" style="width:360px;" id="code_data" placeholder="请确认验证码">                   
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
        /*倒计时*/
         var miao = 60;
        function time(e){

            if(miao == 0)
            {
                e.style.background='#55a32a';
                e.removeAttribute('disabled');
                e.value = '发送验证码';
                miao = 60;
            }
            else
            {
                e.style.background='#abafaa';
                e.setAttribute("disabled", true);
                e.value=" "+ miao +" 秒后重新获取";
                miao--;

                setTimeout(function(){
                    time(e);
                },1000);
            }
        }

    /**
     * 获取验证码
     */
    $('.code').click(function(){
        //倒计时
        var phone  = $('#phone').val();
        if(!phone){
            alert("手机号不为空!");return;
        }else{
             time(this);
          data = {
            _csrf:"<?= Yii::$app->request->csrfToken ?>",
            phone:phone,
            type:2,
          };
          $.post("<?= Url::toRoute('site/send_sms');?>",data,function(msg){
              if(!msg.status){
                  alert(msg.error);
              }
          },'json')
        }
    });


        /**
     * 点击下一步,进行服务器验证
     */
    $('#submit').click(function(){
        var phone  = $('#phone').val();
        var code_data = $("#code_data").val();
        if(!phone || !code_data){
            alert("手机号码和验证码不为空!");
            location.reload();
        }else{
            var data  = {
                _csrf:"<?= Yii::$app->request->csrfToken ?>",
                phone:phone,
                code_data:code_data
            };
            //请求服务器验证
            $.post("<?= Url::toRoute('site/reset_code');?>",data,function(msg){
                if(msg.status){
                    window.location = "<?= Url::toRoute('site/new_pwd');?>";
                }else{
                    alert(msg.error);
                }
            },'json')
        }
    });
    </script>
</body>

</html>
