<?php
use yii\helpers\Url;
?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2><?=$model->status==7?'交易完成':'交易中';?></h2>
                    
                </div>
                
            </div>
            <div class="wrapper wrapper-content animated fadeIn" >
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            
                            <div class="ibox-content">
                                    <div class="pop_all" >
                                       
                                        <div class="mail-tools tooltip-demo m-t-md he_bottom">
                                            <h3>
                                                <span class="font-noraml">订单号码： </span><?=$model->mate_id?>
                                            </h3>
                                             <h3>
                                                <span class="font-noraml">请求援助金额： </span><?=$model->money?>（元）
                                            </h3>
                                           
                                        </div>
                                        <h2>完整的受益人资料如下：</h2>
                                        <div class="mail-tools tooltip-demo m-t-md he_bottom">
                                             <h3>
                                                <span class="font-noraml">受益人姓名： </span><?=$model->gethelp->user->nickname?>
                                            </h3>
                                            <h3>
                                                <span class="font-noraml">联系电话：</span><?=$model->gethelp->user->phone?>
                                            </h3>
                                            <?php 
                                                  $type=  explode(',',$model->gethelp->pay_type);
                                                        foreach ($type as  $v) {
                                                            if($v ==3){
                                             ?>         
                                            <h3>
                                                <span class="font-noraml">开户银行：</span><?=$get_bank['bk1'] ?>
                                            </h3>
                                            <h3>
                                                <span class="font-noraml">开户银行支行：</span><?=$get_bank['bk_zh1'] ?>
                                            </h3>
                                            <h3>
                                                <span class="font-noraml">银行账号：</span><?=$get_bank['bkc1'] ?>
                                            </h3>
                                            <?php }else if($v ==1){ ?>
                                            <h3>
                                                <span class="font-noraml">受益人支付宝： </span><?=$model->gethelp->user->alipay?>
                                            </h3>
                                            <?php }else if($v ==2){ ?>
                                            <h3>
                                                <span class="font-noraml">受益人微信号： </span><?=$model->gethelp->user->weixin?>
                                            </h3>
                                            <?php  } } ?>
                                            <?php if(isset($model->gethelp->user->parent->user->nickname)){ ?>
                                             <h3>
                                                <span class="font-noraml">受益人经理名称： </span><?=$model->gethelp->user->parent->user->nickname?>
                                            </h3>
                                            <h3>
                                                <span class="font-noraml">受益人经理电话号码： </span><?=$model->gethelp->user->parent->user->phone?>
                                            </h3>
                                            <?php }else { ?>
                                                  <h3>
                                                <span class="font-noraml">受益人经理名称： </span>互惠金融
                                            </h3>
                                            <h3>
                                                <span class="font-noraml">受益人经理电话号码： </span>无
                                            </h3>
                                            <?php } ?>
                                            <p class="red" style="margin-top:10px;">*提供者的附加信息：为了更快速的确认，请在转账后发送</p>
                                             <p class="red"> *在收到资金之前不要确认支付，因为确认了就不能撤销了，系统会默认你已经收到钱了！</p>
                                        </div>
                                       
                                        <h2>完整的提供者资料如下：</h2>
                                        <div class="mail-tools tooltip-demo m-t-md he_bottom">
                                             <h3>
                                                <span class="font-noraml">提供者姓名： </span><?=$model->payhelp->user->nickname?>
                                            </h3>
                                            <h3>
                                                <span class="font-noraml">联系电话：</span><?=$model->payhelp->user->phone?>
                                            </h3>
                                            <?php 
                                                  $type=  explode(',',$model->payhelp->pay_type);
                                                        foreach ($type as  $v) {
                                                            if($v ==3){
                                             ?>         
                                            <h3>
                                                <span class="font-noraml">开户银行：</span><?=$pay_bank['bk1'] ?>
                                            </h3>
                                            <h3>
                                                <span class="font-noraml">开户银行支行：</span><?=$pay_bank['bk_zh1'] ?>
                                            </h3>
                                            <h3>
                                                <span class="font-noraml">银行账号：</span><?=$pay_bank['bkc1'] ?>
                                            </h3>
                                            <?php }else if($v ==1){ ?>
                                            <h3>
                                                <span class="font-noraml">提供者支付宝： </span><?=$model->payhelp->user->alipay?>
                                            </h3>
                                            <?php }else if($v ==2){ ?>
                                            <h3>
                                                <span class="font-noraml">提供者微信号： </span><?=$model->payhelp->user->weixin?>
                                            </h3>
                                            <?php  } } ?>
                                            <?php if(isset($model->payhelp->user->parent->user->nickname)){ ?>
                                             <h3>
                                                <span class="font-noraml">提供者经理名称： </span><?=$model->payhelp->user->parent->user->nickname?>
                                            </h3>
                                            <h3>
                                                <span class="font-noraml">提供者经理电话号码： </span><?=$model->payhelp->user->parent->user->phone?>
                                            </h3>
                                            <?php }else { ?>
                                                  <h3>
                                                <span class="font-noraml">提供者经理名称： </span>互惠金融
                                            </h3>
                                            <h3>
                                                <span class="font-noraml">提供者经理电话号码： </span>无
                                            </h3>
                                            <?php } ?>
                                            <p class="red">*在提供帮助后，请按“我提供的帮助”按钮并附上付款确认文件(支票扫描、收据扫描或网上交易操作屏幕截图)放在一个新窗口上。</p>

                                        </div>
                                        <p class="h_btns" style="width:50%;">
                                             <a href="<?=Url::toRoute('user/index')?>"><button type="button" class="btn btn-w-m btn-primary">返回首页</button>  </a>                             
                                        </p>
                                    </div>
                              
                            </div>
                    </div>
                    
                </div>
               
                
          

            </div>
        </div>

    </div>


