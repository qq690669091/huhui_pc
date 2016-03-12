<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
    <title>互利系统</title>
    <style>
        .actives{font-weight: 600;}
    </style>
</head>

<body>
<?php $this->beginBody() ?>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">

                        <div class="dropdown profile-element"> <span>
                          <img alt="image" class="img-circle"  style="width:64px;height:64px;"  src="<?=Yii::$app->session['headicon']!=''?Yii::$app->session['headicon']:'img/profile_small.jpg'; ?>" />
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"></strong>
                             </span>
                             <span  style="margin-top:10px;" class="text-muted text-xs block">姓名：<?=Yii::$app->session['nickname']!=''?Yii::$app->session['nickname']:' ';?></span>                              <span  style="margin-top:10px;" class="text-muted text-xs block">用户名:<?=Yii::$app->session['account']!=''?Yii::$app->session['account']:' ';?></span> </span>
                             <span  style="margin-top:10px;" class="text-muted text-xs block">钱包:<?=Yii::$app->session['flow_money']?Yii::$app->session['flow_money']:'0';?>元</span> </span>
                             <span  style="margin-top:10px;" class="text-muted text-xs block">经理:<?=Yii::$app->session['jl']?'是':'否';?></span> </span>
                             <span  style="margin-top:10px;" class="text-muted text-xs block">推荐人:<?=Yii::$app->session['parent_name']?Yii::$app->session['parent_name']:'无';?></span> </span>
                            </a>
                        </div>
                        <div class="logo-element">
                            HL
                        </div>

                    </li>
                    <li class="">
                        <a href="#" class="menu_index menu_top" menu_index="menu_top"><i class="fa fa-th-large"></i> <span class="nav-label">首页</span> <span class="fa arrow"></span></a>
                        <ul class=" leslie nav nav-second-level">
                            <li><a href="<?=Url::toRoute('user/index');?>" >首页</a> </li>
                            <li><a href="<?=Url::toRoute('user/payhelp');?>">提供帮助</a> </li>
                            <li><a href="<?=Url::toRoute('user/gethelp');?>">接受帮助</a> </li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="?"  class="menu_index menu_news" menu_index="menu_news"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">组织管理</span><span class="fa arrow"></span></a>
                        <ul class=" leslie nav nav-second-level">
                            <li><a href="<?=Url::toRoute('user/manage');?>">管理</a> </li>
                            <li><a href="<?=Url::toRoute('user/team');?>">团队</a> </li>
                            <!-- <li><a href="<?=Url::toRoute('user/tree');?>">团队树</a> </li> -->
                        </ul>
                    </li>
                    <li class="">
                        <a href="?" class="menu_index menu_message" menu_index="menu_message"><i class="fa fa-envelope"></i> <span class="nav-label">财务管理 </span><span class="fa arrow"></span>
                        <ul class=" leslie nav nav-second-level">
                            <li><a href="<?=Url::toRoute('orders/index');?>">财务信息</a> </li>
                        </ul>
                    </li>
                    <li class="">
                      <a href="?" class="menu_index menu_rules" menu_index="menu_rules"><i class="fa fa-edit"></i> <span class="nav-label">新闻管理</span><span class="fa arrow"></span></a>
                        <ul class=" leslie nav nav-second-level">
                            <li><a href="<?=Url::toRoute('news/index');?>">新闻信息</a> </li>
                        </ul>
                    </li>
                    <li>
                        <a href="?" class="menu_index menu_manager" menu_index="menu_manager"><i class="fa fa-desktop"></i> <span class="nav-label">联系我们</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level leslie">
                            <li><a href="<?=Url::toRoute('user/contact');?>">联系我们</a> </li>

                            </li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="?" class="menu_index menu_system" menu_index="menu_system"><i class="fa fa-flask"></i> <span class="nav-label">个人中心</span><span class="fa arrow"></span></a>
                        <ul class=" leslie nav nav-second-level">
                            <li><a href="<?=Url::toRoute('user/info');?>">个人信息</a> </li>
                            <li><a href="<?=Url::toRoute('site/log_edit');?>">修改登录密码</a> </li>
                            <li><a href="<?=Url::toRoute('site/tra_edit');?>">修改交易密码</a> </li>
                            <li><a href="<?=Url::toRoute('site/logout');?>">退出登陆</a> </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>
         <?= $content ?>
<?php
// $js = '
//     $(document).ready(function() {
//         $(window).scroll(function() {
//         // $(document).scrollTop() 获取垂直滚动的距离
//         //$(document).scrollLeft() 这是获取水平滚动条的距离
//         if ($(document).scrollTop() <= 0) {
//            location.reload();
//         }
//     });
// });';
// $this->registerJs($js);
?>



<script type="text/javascript">
    $(function(){
        var index_path = $.session.get('menu_index');
        if(index_path){
            var target = "."+index_path+" ul";
            $("ul").removeClass('in');
            $("."+index_path).next().addClass("in");
            $("."+index_path).parent().addClass("active");
        }

    })

    $('.menu_index').on('click',function(){
        var index_path = $(this).attr('menu_index');
        $.session.set('menu_index',index_path);
    });
</script>
 <script>
//     $("body").on('click', '.nav-second-level li', function(event) {
//         alert("jj")
//         $(this).addClass('active').siblings.removeClass('active');
// });
// </script>
</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
