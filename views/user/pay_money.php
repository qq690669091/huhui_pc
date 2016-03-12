<?php
use yii\helpers\Url;
?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>确认付款</h2>
                    
                </div>
                
            </div>
            <div class="wrapper wrapper-content animated fadeIn" >
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            
                            <div class="ibox-content">
                               
                                <div class="wrapper wrapper-content h_wrapper">
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
                                            <button type="button" onclick="window.location='<?=Url::toRoute('user/index')?>'" class="btn btn-w-m btn-default cancle">返回首页</button>                        
                                            <button type="button" class="btn btn-w-m btn-primary tan3">确认付款</button>                           
                                        </p>
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


    <!-- 确认付款理由弹框内容 -->
    <div class="pop them3" style="top:30%;padding-bottom:3rem;width:20%;margin-left:-10%;height:auto;">
    <form action="<?=Url::toRoute("user/paymoney")?>" method="post" enctype="multipart/form-data">
        <div class="pop_title pr">确认付款<span class="close "></span></div>
       
        <div class="pop_all">
             <div class="checkbox i-checks h_checks">
                <label>
                    <input type="checkbox" class="is_check" value=""> <i></i> 我已完成付款
                    <input type="hidden" class="inputs " name="_csrf" value="<?= Yii::$app->request->csrfToken ?>" placeholder="">
                    <input type="hidden" class="inputs " name="id" value="<?=$model->mate_id?>" placeholder="">
                    <input type="hidden" name="img"  class="add_img po">
                </label>
            </div> 
            <textarea style="border:1px solid #cccccc; height:100px; width:100%;resize:none;" name="content" placeholder="请输入留言..."></textarea>
            <div class="all_pics">
                <div class="chuan_input pr fl">
                    <input type="file"  id="uploadform" class="add_img po">
                </div>
            </div>      
            <p class="h_btns" >
                <button type="button" class="btn btn-w-m btn-default cancle">取消</button>                        
                <button type="submit" class="btn btn-w-m btn-primary confirm">确认付款</button>                           
            </p>
        </div>
        </form>
    </div>
    
    <!-- 确认付款理由弹框内容 -->

               
    <!-- 弹窗 -->

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/tan.js"></script>
    <script src="js/megapix-image.js"></script>
    <script src="js/exif.js"></script>

    <!-- Custom and plugin javascript -->
    <script>
        $("body").on('click', '.tan3', function(event) {
            pop_Up3();
        });
    </script>
    <script>
$(function(){
    //需要引入jQuery
    //参数为上传图片控件的ID名 比如<input type="file" id="img">
    compressImage('uploadform');

    function compressImage(fileOfId){

        var canvas = document.createElement("canvas");
        var canvasIdName = 'xiefu' + Math.random();
        canvas.setAttribute('id',canvasIdName);
        $('#' + canvasIdName).hide();
        $('body').append(canvas);
        var newImage = null;
        $('#'+fileOfId).on('change',function(){

            var file = this.files[0];
            //EXIF获取图片旋转信息
            var Orientation = null;
            EXIF.getData(file,function(){

                EXIF.getAllTags(this);
                Orientation = EXIF.getTag(this, 'Orientation');

                var mpImg = new MegaPixImage(file);

                // Render resized image into canvas element.

                var resCanvas1 = document.getElementById(canvasIdName);

                mpImg.render(resCanvas1, { maxWidth: 800, maxHeight: 800, orientation: Orientation}, function(imgData){
                    //--------------------------imgData: 处理后最终的base64编码图片-----------------------------
                    $('.chuan_input').before("<div class='h_wai fl pr'><img src='" + imgData + "'><span class='close1 po dk'></span></div>");
                    var a  = $("input[name='img']").val(imgData);
                });
            });
        })
    }
})

    // 删除图片
    $("body").on('click', '.close1', function(event) {
        $(this).parent().remove();
    });
    // 删除图片

    </script>
    <script>
      $('.confirm').click(function(){
            var img = $('.add_img').val();
            if(! $('.is_check').is(":checked")){
                alert('请勾选完成付款按钮');return false;
            }
            if(img  == ''){
                alert('为保证安全 请上传图片');return false;
            }
     })
    </script>
