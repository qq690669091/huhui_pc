<?php 
use yii\helpers\Url;
 ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>手机验证</title>
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
            <h2 style="color:#fff;margin-left:153px;">手机验证</h2>
                <div class="inputs">
                    <span class="h_title fl" style="color:#fff;" >手机号：</span>
                    <input type="text" class="number fl h_form_control" id="phone"  placeholder="请输入手机号">
                    <input type="text" class="code fl" value="发送验证码"  style="height:50px;line-height:50px;" >
                </div>

                <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">验证码：</span>
                    <input type="text" class="number fl h_form_control" style="width:360px;"  id="code_data" placeholder="请确认验证码">                   
                </div>
                <input type="submit" id="submit" value="下一步" class="l_zhanghao_bg" style="width:160px;">
                <input type="button"  value="上一步"   onclick="window.location='<?=Url::toRoute('site/index')?>'" class="l_zhanghao_bg" style="width:160px;">
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
     * 手机号合法性检测
     */
    $("#phone").change(function(){
        var phone = $(this).val();
        if(phone ==''){
            alert('请输入手机号码');
            $(this).val('');
        }
        if(! /^1\d{10}$/.test(phone)){
            alert("手机号码有误，请重填");
            $(this).val('');
            $(this).focus();
        }
    });

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
            type:1,
          };
          $.post("<?= Url::toRoute('site/send_sms');?>",data,function(msg){
              if(!msg.status){
                  alert(msg.error);
                  location.reload();
              }
          },'json')
        }
    });

    /**
     * 点击下一步,进行服务器验证
     */
    $('#submit').click(function(){
        var parent_id = getUrlParam('parent_id');  //获取上级用户id
        var phone  = $('#phone').val();
        var code_data = $("#code_data").val();
        if(!phone || !code_data){
            alert("手机号码和验证码不为空!");
            location.reload();
        }else{
            var data  = {
                _csrf:"<?= Yii::$app->request->csrfToken ?>",
                phone:phone,
                parent_id:parent_id,
                code_data:code_data
            };
            //请求服务器验证
            $.post("<?= Url::toRoute('site/reginster_code');?>",data,function(msg){
                if(msg.status){
                    window.location = "<?= Url::toRoute('site/reginster_pwd');?>";
                }else{
                    alert(msg.error);
                }
            },'json')
        }
    });


    function getUrlParam(name){
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r!=null) return unescape(r[2]); return null; //返回参数值
} 
    </script>
</body>

</html>
