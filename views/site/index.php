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
    <style>
       ::-webkit-input-placeholder {
　　      color: #fff !important; 
　　}
    :-moz-placeholder {
         color: #fff !important;
    }
    :-ms-input-placeholder {
       color: #fff !important; 
    }
    </style>
</head>

<body class="gray-bg pr" style="background:url(img/login_bg.jpg) no-repeat center center;">
    <div class="zhezhao po"></div>
    <div class=" text-center loginscreen  animated fadeInDown" style="width:600px;height:auto;margin:0 auto ;overflow:hidden;padding-top:80px;">
        <div style="width:100%;">
            <div>

                <h1 class="logo-name" style="color:#00abf3;margin-left:153px;">Hh</h1>

            </div>
            <h2 style="color:#fff;margin-left:153px;">登录界面</h2>
                <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">用户名：</span>
                    <input type="text" class="number fl h_form_control account" style="width:360px;"  placeholder="请输入登陆账号或者手机号" required  autofocus="autofocus">                   
                </div>
                <div class="inputs" style="margin-top:20px;">
                    <span class="h_title fl" style="color:#fff;">密码：</span>
                    <input type="password" class="number fl h_form_control pwd" style="width:360px;" placeholder="请输入密码" required>                   
                </div>
               <input type="submit" id="submit" value="登录" class="l_zhanghao_bg" style="width:160px;">

                <p class="text-muted text-center h_text_center" style="margin-left:153px;"> <a href="<?= Url::toRoute('site/forget_pass');?>" style="height:50px;font-size:20px;"><small>忘记密码了？</small></a> | <a href="<?= Url::toRoute('site/reginster');?>">注册一个新账号</a>
                </p>

            </form>
        </div>
    </div>

    <!-- 弹窗 -->
    <div class="theme-popover-mask" ></div><!-- 遮罩 -->

            <!-- 登录失败内容 -->
                <div class="pop them1" style="height:auto;padding-bottom:20px;width:40%;margin-left:-20%;">
                    <div class="pop_title pr">登录失败<span class="close "></span></div>
                   
                    <div class="pop_all">
                      <?=$jihuo->content?>
                    </div>
                    <div class="h_btns" style="margin-top:30px;width:130px;">
                        <button type="button" class="btn btn-w-m btn-primary button">确定</button>  
                    </div>
                </div>
                
            <!-- 登录失败内容 -->

            <!-- 封号弹框内容 -->
                <div class="pop them2" style="top:50%;padding-bottom:3rem;">
                    <div class="pop_title pr">封号<span class="close "></span></div>
                   
                    <div class="pop_all">
                        <div class="h_reminder">对不起！由于您xxxx，您已被封号！</div> 
                        <p class="h_reminders">您可以 <a href="javascript:;" class="tan3 parent" style="text-decoration:underline !important;">联系推荐人</a></p>    
                        <p class="h_btns" style="margin-top:30px;width:130px;">                        
                            <button type="button" class="btn btn-w-m btn-primary button1">确定</button>                           
                        </p>
                    </div>
                </div>
                
                <!-- 封号弹框内容 -->

                <!-- 推荐人弹框内容 -->
                <div class="pop them3" style="top:30%;padding-bottom:3rem;width:20%;margin-left:-10%;">
                    <div class="pop_title pr">推荐人信息<span class="close "></span></div>
                   
                    <div class="pop_all parent_info"></div>
                    <div class="h_btns" style="margin-top:30px;width:130px;">
                        <button type="button" class="btn btn-w-m btn-primary button2">确定</button>  
                    </div>
                </div>
                
                <!-- 推荐人弹框内容 -->
    <!-- 弹窗 -->

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js?v=3.4.0"></script>
    <script src="js/tan.js"></script>
    <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script><!--统计代码，可删除-->
    <script>
        $("body").on('click', '.tan1', function(event) {
            pop_Up1();
        });
         $("body").on('click', '.tan2', function(event) {
            pop_Up2();
           
        });
          $("body").on('click', '.tan3', function(event) {
            pop_Up3();
            $(".them2").hide();
        });
    </script>
    <script>
    $('#submit').click(function(){
    var 
        account  =   $('.account').val();
        pwd       =   $('.pwd').val();
        data = {
            account :account,
            pwd_log :pwd,
            _csrf:"<?= Yii::$app->request->csrfToken ?>",
        };
        $.post('<?=Url::toRoute("site/login")?>',data,function(data){
                if(data.status == 1  ){
                     $('.them2').slideDown(200);
                     $('.button1').click(function(){
                         $('.them2').slideUp(200);
                          $('.theme-popover-mask').hide();
                     }) 
                     $('.parent').click(function(){
                        var msg  = {
                            user_id:data.user_id,
                            _csrf:"<?= Yii::$app->request->csrfToken ?>",
                        }
                        $.post('<?=Url::toRoute("site/parent_desc")?>',msg,function(msg){
                            var str = '<p class="recommend_inf" > <span class="recommend_inf_left fl">姓名：</span> <span class="recommend_inf_right fl">'+msg.nickname+'</span> </p> <p class="recommend_inf" > <span class="recommend_inf_left fl">电话：</span> <span class="recommend_inf_right fl">'+msg.phone+'</span> </p> <p class="recommend_inf" > <span class="recommend_inf_left fl">微信号：</span> <span class="recommend_inf_right fl">'+msg.weixin+'</span> </p> <p class="recommend_inf" > <span class="recommend_inf_left fl">等级：</span> <span class="recommend_inf_right fl">'+msg.level+'</span> </p> ';
                            $('.parent_info').html(str).slideDown(200);
                            $('.them3').slideDown(200);
                            $('.button2').unbind().click(function(){
                                    $('.them3').slideUp(200);
                                    $('.theme-popover-mask').hide();
                            })
                        },'json')
                     })

                }else if(data.status == 0){
                     $('.them1').slideDown(200);
                     $('.button').click(function(){
                         $('.them1').slideUp(200);
                     })
                }else if(data.status == 2 ){
                    alert(data.message);
                    if(data.nickname == null){
                        window.location ="<?=Url::toRoute('site/complete_info')?>";
                    }else{
                        window.location ="<?=Url::toRoute('user/index')?>";
                    }
                }else if(data.status ==3){
                    alert(data.message);return;
                }
        },'json')
})
    </script>
</body>

</html>
