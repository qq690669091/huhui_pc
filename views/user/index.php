<?php 
use yii\widgets\LinkPager;
use yii\helpers\Url;
 ?>
    <div id="page-wrapper" class="gray-bg dashbard-1">
            
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>首页</h2>
                    
                </div>
                
            </div>
            <div class="wrapper wrapper-content animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            
                            <div class="ibox-content">
                                <div class="h_news">最新资讯：<a style="color:#090;" href="<?=Url::toRoute(['news/index', 'id'=>$news->news_id])?>">
                    <?php
                            $newstr = strip_tags($news->title);
                            $newstr = mb_substr($newstr,0,15,'utf-8');
                            echo $newstr;
                        ?></a></div>
                                <div class="all_kuai">
                                  <img src="img/sy.jpg" alt="">
                                </div> 
                                <div class="wrapper wrapper-content h_content">
                                    <div class="row animated fadeInRight">
                                        <div class="col-md-6">
                                            <div class="ibox float-e-margins">
                                                <div class="ibox-title">
                                                    <h1>我要帮助其他人</h1>
                                                </div>
                                                
                                                    <div class="ibox-content no-padding border-left-right" style="border:0;">
                                                        <img alt="image" class="img-responsive" src="img/help.png">
                                                    </div>
                                                    <div class="ibox-content profile-content">
                                                    
                                                        <div class="user-button">
                                                            <div class="row">
                                                                <div class="col-md-10" >
                                                                    <a href="<?=Url::toRoute('user/payhelp')?>" ><button type="button" class="btn btn-primary btn-sm btn-block langse" style="margin-left:66px;height:60px;"><i class="fa fa-envelope"></i> 申请提供帮助</button></a>
                                                                </div>
                                                               
                                                            </div>
                                                        </div>
                                                                                                                                                                  
                                                </div>
                                           
                                            </div>

                                        </div>

                                         <div class="col-md-6">
                                            <div class="ibox float-e-margins">
                                                <div class="ibox-title">
                                                    <h1>我需要别人帮助</h1>
                                                </div>
                                                
                                                    <div class="ibox-content no-padding border-left-right" style="border:0;">
                                                        <img alt="image" class="img-responsive" src="img/pay.jpg">
                                                    </div>
                                                    <div class="ibox-content profile-content">
                                                    
                                                        <div class="user-button">
                                                            <div class="row">
                                                                <div class="col-md-10" >
                                                                    <a href="<?=Url::toRoute('user/gethelp')?>"  ><button type="button" class="btn btn-primary btn-sm btn-block langse" style="margin-left:66px;height:60px;"><i class="fa fa-envelope"></i>
                                                                        申请接受帮助
                                                                    </button></a> 
                                                                </div>
                                                               
                                                            </div>
                                                        </div>
                                                                                                                                                                  
                                                </div>
                                           
                                            </div>

                                        </div>
                                    </div>
                              
                                </div>

                                 <div class="table-responsive" style="border:1px solid #ddd;">
                                    <table class="table table-striped he_table">
                                        <thead>
                                            <tr>
                                                <th>状态</th>
                                                <th>类型</th>
                                                <th>配对时间</th>
                                                <th>配对人</th>
                                                <th>支付方式</th>
                                                <th>操作</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($provider)) foreach($provider->models as $models): ?>
                                                <!-- 匹配中 提供帮助 -->
                                            <?php if($models->get_id == 0 && $models->pay_id !=0) if(showtime(($showtime->limt_time*86400 -time() +($models->create_time))/3600)>0){ ?>
                                            <tr >
                                                <td>匹配中</td>
                                                <td>提供帮助</td>
                                                <td>还剩 <?= showtime(($showtime->limt_time*86400 -time() +($models->create_time))/3600)>=0?showtime(($showtime->limt_time*86400 -time() +($models->create_time))/3600):'0' ?> (小时)</td>
                                                <td><?=$models->payhelp->user->nickname?></td>
                                                <td>
                                                    <?php  
                                                        $name='';
                                                        $type=  explode(',',$models->payhelp->pay_type);
                                                        foreach ($type as  $v) {
                                                            if($v ==1) $name .=' 支付宝';
                                                            if($v ==2) $name .=' 微信';
                                                            if($v ==3) $name .=' 银行卡';
                                                        }
                                                        echo $name;
                                                    ?>
                                                </td>                                                             
                                                <td> 
                                                </td>
                                            </tr>
                                            <!-- 提供帮助 交易成功 -->
                                            <?php } if( $models->pay_id !=0) if($models->payhelp->user_id == Yii::$app->session['user_id'] && $models->status ==7){ ?>
                                            <tr >
                                                <td>交易成功</td>
                                                <td>提供帮助</td>
                                                <td><?=date('Y-m-d',$models->create_time)?></td>
                                                <td><?=$models->payhelp->user->nickname?></td>
                                                <td>
                                                    <?php  
                                                        $name='';
                                                        $type=  explode(',',$models->payhelp->pay_type);
                                                        foreach ($type as  $v) {
                                                            if($v ==1) $name .=' 支付宝';
                                                            if($v ==2) $name .=' 微信';
                                                            if($v ==3) $name .=' 银行卡';
                                                        }
                                                        echo $name;
                                                    ?>
                                                </td>                                                             
                                                <td>                                                                                              
                                                    <a href="<?=Url::toRoute(['user/finish_order', 'id'=>$models->mate_id])?>"><button type="button" class="btn btn-outline btn-success">详情</button></a>
                                                </td>
                                              </tr>
                                            <!-- 等待付款 -->
                                            <?php } if( $models->pay_id !=0) if($models->payhelp->user_id == Yii::$app->session['user_id'] && $models->status ==2){ ?>
                                            <tr >
                                                <td>等待您的付款</td>
                                                <td>提供帮助</td>
                                                <td>还剩 <?= showtime(($showtime->pay_time*86400 -time() +($models->create_time))/3600)>=0?showtime(($showtime->pay_time*86400 -time() +($models->create_time))/3600):'0' ?> (小时)</td>
                                                <td><?=$models->payhelp->user->nickname?></td>
                                                <td>
                                                    <?php  
                                                        $name='';
                                                        $type=  explode(',',$models->payhelp->pay_type);
                                                        foreach ($type as  $v) {
                                                            if($v ==1) $name .=' 支付宝';
                                                            if($v ==2) $name .=' 微信';
                                                            if($v ==3) $name .=' 银行卡';
                                                        }
                                                        echo $name;
                                                    ?>
                                                </td>                                                             
                                                <td>                                                                                              
                                                    <a href="javascript:;"  class="tanmima tan2" name="<?=Url::toRoute(['user/paymoney', 'id'=>$models->mate_id])?>"><button type="button" class="btn btn-outline btn-success">确认付款</button></a>
                                                </td>
                                            </tr>
                                            <!-- 等待对方确认 -->
                                             <?php } if( $models->pay_id !=0) if($models->payhelp->user_id == Yii::$app->session['user_id'] && ($models->status ==3 || $models->status ==6)){ ?>
                                            <tr >
                                                <td>等待对方确认</td>
                                                <td>提供帮助</td>
                                                <td>还剩 <?= showtime(($showtime->pay_time*86400 -time() +($models->create_time))/3600)>=0?showtime(($showtime->pay_time*86400 -time() +($models->create_time))/3600):'0' ?> (小时)</td>
                                                <td><?=$models->payhelp->user->nickname?></td>
                                                <td>
                                                    <?php  
                                                        $name='';
                                                        $type=  explode(',',$models->payhelp->pay_type);
                                                        foreach ($type as  $v) {
                                                            if($v ==1) $name .=' 支付宝';
                                                            if($v ==2) $name .=' 微信';
                                                            if($v ==3) $name .=' 银行卡';
                                                        }
                                                        echo $name;
                                                    ?>
                                                </td>                                                             
                                                <td>  
                                                    <a href="<?=Url::toRoute(['user/finish_order', 'id'=>$models->mate_id])?>"><button type="button" class="btn btn-outline btn-success">详情</button></a>                                                                                              
                                                </td>
                                            </tr>
                                            <?php  } ?>
                                                 <!-- 匹配中  接受帮助 -->
                                            <?php  if( $models->get_id !=0) if($models->pay_id == 0) if(showtime(($showtime->limt_time*86400 -time() +($models->create_time))/3600)>0){ ?>
                                            <tr >
                                                <td>匹配中</td>
                                                <td>接受帮助</td>
                                                <td>还剩 <?= showtime(($showtime->limt_time*86400 -time() +($models->create_time))/3600)>=0?showtime(($showtime->limt_time*86400 -time() +($models->create_time))/3600):'0' ?> (小时)</td>
                                                <td><?=$models->gethelp->user->nickname?></td>
                                                <td>
                                                    <?php  
                                                        $name='';
                                                        $type=  explode(',',$models->gethelp->pay_type);
                                                        foreach ($type as  $v) {
                                                            if($v ==1) $name .=' 支付宝';
                                                            if($v ==2) $name .=' 微信';
                                                            if($v ==3) $name .=' 银行卡';
                                                        }
                                                        echo $name;
                                                    ?>
                                                </td>                                                             
                                                <td> 
                                                </td>
                                            </tr>
                                            <!-- 交易成功 接受帮助 -->
                                             <?php } if( $models->get_id !=0) if($models->gethelp->user_id == Yii::$app->session['user_id'] && $models->status ==7){ ?>
                                            <tr >
                                                <td>交易成功</td>
                                                <td>接受帮助</td>
                                                <td><?=date('Y-m-d',$models->create_time)?></td>
                                                <td><?=$models->gethelp->user->nickname?></td>
                                                <td>
                                                    <?php  
                                                        $name='';
                                                        $type=  explode(',',$models->payhelp->pay_type);
                                                        foreach ($type as  $v) {
                                                            if($v ==1) $name .=' 支付宝';
                                                            if($v ==2) $name .=' 微信';
                                                            if($v ==3) $name .=' 银行卡';
                                                        }
                                                        echo $name;
                                                    ?>
                                                </td>
                                                <td>    
                                                     <a href="<?=Url::toRoute(['user/finish_order', 'id'=>$models->mate_id])?>"><button type="button" class="btn btn-outline btn-success">详情</button></a>                                                                                          
                                                </td>
                                            </tr>
                                             <!-- 等待对方付款 -->
                                            <?php } if( $models->get_id !=0) if($models->gethelp->user_id == Yii::$app->session['user_id'] && $models->status ==2){ ?>
                                            <tr >
                                                <td>等待对方付款</td>
                                                <td>接受帮助</td>
                                                <td>还剩 <?= showtime(($showtime->pay_time*86400 -time() +($models->create_time))/3600)>=0?showtime(($showtime->pay_time*86400 -time() +($models->create_time))/3600):'0' ?> (小时)</td>
                                                <td><?=$models->gethelp->user->nickname?></td>
                                                <td>
                                                    <?php  
                                                        $name='';
                                                        $type=  explode(',',$models->gethelp->pay_type);
                                                        foreach ($type as  $v) {
                                                            if($v ==1) $name .=' 支付宝';
                                                            if($v ==2) $name .=' 微信';
                                                            if($v ==3) $name .=' 银行卡';
                                                        }
                                                        echo $name;
                                                    ?>
                                                </td>                                                             
                                                <td> 
                                                    <a href="<?=Url::toRoute(['user/finish_order', 'id'=>$models->mate_id])?>"><button type="button" class="btn btn-outline btn-success">详情</button></a>                                                                                               
                                                </td>
                                            </tr>
                                            <!-- 等待您的确认 -->
                                            <?php } if( $models->get_id !=0) if($models->gethelp->user_id == Yii::$app->session['user_id'] && ($models->status ==3 || $models->status ==6)){ ?>
                                            <tr >
                                                <td>等待您的确认</td>
                                                <td>接受帮助</td>
                                                <td>还剩 <?= showtime(($showtime->get_time*86400 -time() +($models->create_time))/3600)>=0?showtime(($showtime->get_time*86400 -time() +($models->create_time))/3600):'0' ?> (小时)</td>
                                                <td><?=$models->gethelp->user->nickname?></td>
                                                <td>
                                                    <?php  
                                                        $name='';
                                                        $type=  explode(',',$models->gethelp->pay_type);
                                                        foreach ($type as  $v) {
                                                            if($v ==1) $name .=' 支付宝';
                                                            if($v ==2) $name .=' 微信';
                                                            if($v ==3) $name .=' 银行卡';
                                                        }
                                                        echo $name;
                                                    ?>
                                                </td>                                                             
                                                <td>                                                                                              
                                                    <a href="javascript:;" name="<?=Url::toRoute(['user/getmoney', 'id'=>$models->mate_id])?>" class="tanmima tan2" ><button type="button" class="btn btn-outline btn-success">确认收款</button></a>
                                                </td>
                                            </tr>
                                            <?php } endforeach ?>
                                        </tbody>
                                    </table>
                                    <?php if(isset($provider)) { ?>
                                    <?=
                                            LinkPager::widget([
                                            'pagination' => $provider->pagination,
                                            'options' => ['class' => 'pagination pull-left', 'style' => 'align:center;'],
                                            ]);
                                         } ?>
                      <!--               <div class="pages" style="width:80%;margin:0 auto;text-align: center;">
                                        <div class="btn-group" style="margin:10px auto;"> -->
                             <!--                <a href="#" class="btn btn-white"><<i class="fa fa-chevron-left"></i>
                                            </a>
                                            <a href="#"class="btn btn-white">1</a>
                                            <a href="#"class="btn btn-white  active">2</a>
                                            <a href="#"class="btn btn-white">3</a>
                                            <a href="#"class="btn btn-white">4</a>
                                            <a href="#" class="btn btn-white">><i class="fa fa-chevron-right"></i> 
                                            </a> -->
                                 <!--        </div>
                                    </div> -->
                                </div>
                        </div>
                    </div>
                    
                </div>
               
            </div>
          

            </div>
        </div>

    </div>
    <!-- 弹窗 -->
    <div class="theme-popover-mask" ></div><!-- 遮罩 -->
     <!-- 交易密码弹框内容 -->
        <div class="pop them2" style="height:250px;width:400px;margin-left:-200px;top:30%;">
            <div class="pop_title pr">交易密码<span class="close "></span></div>
           
            <div class="pop_all" style="padding-top:50px;">
               <div class="form-group">
                    
                    <input type="password" placeholder="请输入密码" class="form-control">
                </div>
                <input type="button" class="h_pay confirm" value="确认">
                   
            </div>
        </div>
   
        <!-- 密码输入框 开始 -->
    <!-- <div class="mima_hei"></div>
    <div id="smima">
        <h3>输入交易密码<span class="mima_guan">关闭</span></h3>
        <div class="mima_box">
            <input class="pass" type="password"  maxlength="20";>
            <input class="btn btn_mima" type="button"  maxlength="20"; style="font-size:18px;" value="确认支付">
        </div>
    </div> -->
    <!-- 密码输入框 结束 -->
               


    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/tan.js"></script>
    <script>
        $("body").on('click', '.tan1', function(event) {
            pop_Up1();
        });
         $("body").on('click', '.tan2', function(event) {
            pop_Up2();
            $(".them1").hide();
        });
          $("body").on('click', '.tan3', function(event) {
            pop_Up3();
        });
         
    </script>
    <script>
     $('.tanmima').click(function(){
        var url = $(this).attr('name');
        $('.confirm').unbind().click(function(){
            var pwd = $('.form-control').val();
            $.get('<?=Url::toRoute("user/validation")?>',{pwd:pwd},function(msg){
                // console.log(msg);return;
                    alert(msg.message);
                    if(msg.status ==1){
                        window.location.href = url;
                    }
            },'json')
        })
})
    </script>
