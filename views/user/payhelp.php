<?php
use yii\helpers\Url;
?>  
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>提供帮助</h2>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeIn">
                <div class="alert alert-success h_alert" style="height:100px;line-height:70px;font-size:20px;">
                   申请成功后，请等待系统匹配
                </div>
                <div class="pay_way">
                    <div class="way_title">支付方式：</div>
                    <div class="pay_way_show">
                        <div class="pay_alipay pr" var1='1'> <span class="icons dk po"></span>支付宝支付</div>
                        <div class="pay_wechat pr" var1='2'><span class="icons dk po"></span>微信支付</div>
                        <div class="pay_yin pr" var1='3'><span class="icons dk po"></span>银行支付</div>
                    </div>
                </div>

                <div class="pay_way pay_mon">
                    <div class="way_title">提供帮助金额（元）:</div>
                    <input type="text" class="form-control input_mon" placeholder="输入金额，<?=$prule->min_money?>~<?=$prule->max_money?>"  onChange= "CheckNumber(this)">
                    
                    <p class="help_reminder">
                        <label>
                            <input type="checkbox" value="" class="i_konw">
                        </label>
                        我已完全了解所有风险。我决定参与互惠金融，尊重互惠金融文化与传统。
                    </p>

                     <div class="help_btn">
                        <a href="javascript:history.go(-1);" class="come_back fl dk">返回</a>
                        <a href="javascript:;" class="give_help fl dk tan2">提供帮助</a>
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
            <?php if(isset($prev)){ ?>
            <div class="pop_title pr" style="border-bottom:none;">上次提供帮助金额：<b style="color:red;"><?=$prev?>元</b></div>
           <?php } ?>
            <div class="pop_all" style="padding-top:20px;">
               <div class="form-group">
                    
                    <input type="password" placeholder="请输入密码" class="form-control pwd">
                </div>
                <input type="button" class="h_pay confirm1" value="确认">
                   
            </div>
        </div>
   
        <!-- 密码输入框 开始 -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/tan.js"></script>
    <script>
        $("body").on('click', '.pay_way_show div', function(event) {
            if(!$(this).hasClass('choose'))
            {
                $(this).addClass('choose');

            }
            else{
                $(this).removeClass('choose');
            }
        });
    </script>
    <script>
        function CheckNumber(obj) 
{ if (Number(obj.value) % 100 !== 0){
        alert('请输入倍数为<?=$prule->mlutiple?>的金额'); 
        obj.select(); 
        obj.focus(); 
        return false; 
    }
    if(obj.value < <?=$prule->min_money?> || obj.value ><?=$prule->max_money?>){
        alert('请输入<?=$prule->min_money?>~~<?=$prule->max_money?>的金额'); 
        obj.select(); 
        obj.focus(); 
        return false; 
    }
} 

    $('.tan2').click(function(){
        var money = $('.input_mon').val();
        var aa = 1;
        var pay_type =[];
        $('.pr').each(function(a,b){
            if($(b).hasClass('choose')){
                aa = 2;
                pay_type.push($(b).attr('var1'))
            }
        })

        if(aa==1){
            alert('请至少选择一种支付方式');return false;
        }
        if(money==''){      
            alert('金额不能为空');return false;
        
        }
        if (money % 100 !== 0){
                alert('请输入倍数为<?=$prule->mlutiple?>的金额'); 
                return false; 
        }
        if(money < <?=$prule->min_money?> || money  ><?=$prule->max_money?>){
            alert('请输入<?=$prule->min_money?>~~<?=$prule->max_money?>的金额'); return false; 
        }
        if(!$('.i_konw').is(":checked")){
                alert('请勾选我已完全了解所有风险按钮');return false;

        }
        $('.confirm1').unbind().on('click',function(){
            var pwd = $('.pwd').val();
            $.get('<?=Url::toRoute("user/validation")?>',{pwd:pwd},function(msg){
                    if(msg.status ==1){
                       $('.confirm1').unbind();
                        $.post('<?=Url::toRoute("user/payhelp")?>',{money:money,pay_type:pay_type},function(msg){
                            alert(msg.message);
                            if(msg.status== 1 ){
                                window.location = "<?=Url::toRoute('user/index')?>";
                            }else{
                                window.location.reload();
                            }
                        },'json')
                    }else{
                        alert(msg.message);
                    }
            },'json')
        })       
    })
    </script>

