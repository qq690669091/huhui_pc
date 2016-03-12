 <?php 
use yii\helpers\Url;
use yii\widgets\LinkPager;
 ?>     
 <link rel="stylesheet" href="css/mima.css">
        <div id="page-wrapper" class="gray-bg dashbard-1">
            
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>财务管理</h2>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeIn">
                

                <div class="recommended_amount">
                    <div class="flow_money fl ">
                        <h3 style="color:#fff;">钱包金额（元）</h3>
                        <p class="money_num wallet_num"><?=$money?></p>
                    </div> 
                    <div class="recommended_amount_in fr">
                        <span class="in_left fl dk">推荐奖金（元）</span>
                        <span class="in_center fl dk">
                            <p class="gold">流动：<?=$rc_money?>元</p>
                            <p >待定：<?=$user->money_rec?>元</p>
                        </span>
                        <a href="<?=Url::toRoute(['orders/gethelp','id'=>1])?>"  class="accept_help dk fl">接受帮助</a>
                        <!-- <span class="accept_help dk fl">接受帮助</span> -->
                    </div>
                    <div class="recommended_amount_in fr">
                        <span class="in_left fl dk">经理奖金（元）</span>
                        <span class="in_center fl dk">
                            <p class="gold">流动：<?=$manager_money?>元</p>
                            <p >待定：<?=$user->money_manager?>元</p>
                        </span>
                        <a href="<?=Url::toRoute(['orders/gethelp','id'=>2])?>" class="accept_help dk fl">接受帮助</a>
                        <!-- <span class="accept_help dk fl">接受帮助</span> -->
                    </div>
                </div>  
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                             <div class="ibox-title">
                                <h5>操作明细：</h5>
                                
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive" style="border:1px solid #ddd;">
                                    <table class="table table-striped he_table">
                                        <thead>
                                            <tr>

                                                <th>编号</th>
                                                <th>日期</th>
                                                <th>说明</th>
                                                <th>金额</th>
                                                <th>利息可提/已提</th> 
                                                <th>天数</th>                   
                                                <th>提现</th>
                                                <th>是否转出</th> 
                                                <th>匹配编号</th>                   
                                                <th>匹配状态</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <?php if(isset($tixian)) foreach($tixian->models as $models){ ?>
                                                <?php if($models->is_tx ==0){ ?>
                                                <td><?=$models->pay_id?></td>
                                                <td><?= date('Y-m-d H:i:s',$models->create_time) ?></td>
                                                <td>提供帮助</td>
                                                <td><?=$models->money?></td>
                                                <td><?=$models->accrual?></td>
                                                <td><?=floor(intval(time()-$models->create_time)/86400)?></td>
                                                <td>
                                                    <button pid=<?=$models->pay_id?> type="button" class="btn btn-w-m btn-primary mima tan1 langse" style="margin-top:-10px;" <?=floor(intval(time()-$models->create_time)/86400) < $prule->limit_days?'disabled':''?>> 
                                                    提现</button>

                                                </td>
                                                <td><?=$models->is_tx ==0?'未转出':'已转出';?></td>                                                          
                                                <td><?=$models->status == 1?'未匹配':'已匹配';?></td>
                                                <td><?=$models->status == 1?'排队中':'匹配成功';?></td>
                                            </tr>
                                            <?php } } ?>
                                        </tbody>
                                    </table>
                                 <?php if(isset($user_list)) { ?>
                                    <?=
                                            LinkPager::widget([
                                            'pagination' => $user_list->pagination,
                                            'options' => ['class' => 'pagination pull-left', 'style' => 'align:center;'],
                                            ]);
                                     } ?>
                                </div>
                            </div>
                        </div>
                    
                    </div>
               
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                             <div class="ibox-title">
                                <h5>互助钱包记录：</h5>
                                
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive" style="border:1px solid #ddd;">
                                    <table class="table table-striped he_table">
                                        <thead>
                                            <tr>

                                                <th>编号</th>
                                                <th>日期</th>
                                                <th>说明</th>
                                                <th>原金额</th>
                                                <th>+收入/-支出 (RMB)</th> 
                                                <th>新余额</th>                   
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(isset($moneylog)) foreach($moneylog->models as $models){ ?>
                                            <tr >
                                                <td><?=$models->log_id?></td>
                                                <td><?= date('Y-m-d H:i:s',$models->create_time) ?></td>
                                                <td><?=$models->desc?></td>
                                                <td><?=$models->old_money?></td>
                                                <td><?=$models->handle?></td>
                                                <td><?=$models->new_money?></td>

                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                     <?php if(isset($moneylog)) { ?>
                                    <?=
                                            LinkPager::widget([
                                            'pagination' => $moneylog->pagination,
                                            'options' => ['class' => 'pagination pull-left', 'style' => 'margin:0 auto;'],
                                            ]);
                                     } ?>
                                </div>
                            </div>
                        </div>
                    
                    </div>
               
                </div>
          

            </div>
        </div>
        <!-- 弹框部分 -->
        <div class="theme-popover-mask" ></div><!-- 遮罩 -->

        <!-- 交易密码弹框内容 -->
        <div class="pop them1" style="height:250px;width:400px;margin-left:-200px;top:30%;">
            <div class="pop_title pr">交易密码<span class="close "></span></div>
           
            <div class="pop_all" style="padding-top:50px;">
               <div class="form-group">
                    
                    <input type="password" placeholder="请输入密码" class="form-control">
                </div>
                <input type="button" class="h_pay confirm_a" value="确认">
                   
            </div>
        </div>
   
    
    <!-- 交易密码弹框内容 -->
        <!-- 提现弹框内容 -->
        <div class="pop them2"  style="top:30%;">
            <div class="pop_title pr">提现<span class="close "></span></div>
            <div class="pop_all" style="padding-top:50px;">
                <p class="tishi">确定提现吗？</p>
                <div class="buttons">
                    <button type="button" class="btn btn-w-m btn-default gb">取消</button>
                   <button type="button" class="btn btn-w-m btn-primary confirm">确认</button>
                </div>
                   
               
            </div>
        </div>
    <!--  提现弹框内容 -->

    <!-- 密码输入框 开始 -->
    <!-- <div class="mima_hei"></div>
    <div id="smima">
        <h3>输入交易密码<span class="mima_guan">关闭</span></h3>
        <div class="mima_box">
            <input class="pass" type="password"  maxlength="20";>
            <input class="btn" type="button"  maxlength="20"; style="font-size:18px;" value="确认支付">
        </div>
    </div> -->
<!-- 密码输入框 结束 -->

 

    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/mima.js"></script>
    <script src="js/tan.js"></script>
    <script>
    $("body").on('click', '.tan1', function(event) {
         pop_Up1();
    });

    $('.mima').click(function(){
        var pid = $(this).attr('pid');
        $('.confirm_a').unbind().click(function(){
        var pwd = $('.form-control').val();
        $.get('<?=Url::toRoute("user/validation")?>',{pwd:pwd},function(msg){
                if(msg.status ==1){
                    $('.theme-popover-mask').show();
                    $('.them2').slideDown(200);
                    $('.them1').slideUp(200);
                     //提现
                        $('.confirm').one('click',function(){
                            $('.theme-popover-mask').hide();
                            $('.pop').hide(200);
                            $.get('<?=Url::toRoute("orders/tixian")?>',{pid:pid},function(msg){
                                    alert(msg.message);
                                    if(msg.status==1){
                                         location.reload();
                                    }
                            },'json')
                        })
                }else{
                    alert(msg.message);
                }
        },'json')
    })
})
    </script>
