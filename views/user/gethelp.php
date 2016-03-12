<?php
use yii\helpers\Url;
?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>接受帮助</h2>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeIn">
                <div class="remaining_sum">
                    <p>可出售余额（元）<b class="fr"><?=$money?></b></p>
                    <p>最低出售余额（元）<b class="fr"><?=$grule->min_money?></b></p>
                </div>
                <div class="pay_way">
                    <div class="way_title">支付方式：</div>
                    <div class="pay_way_show">
                        <div class="pay_alipay pr" var1="1" > <span class="icons dk po"></span>支付宝支付</div>
                        <div class="pay_wechat pr" var1="2" ><span class="icons dk po"></span>微信支付</div>
                        <div class="pay_yin pr" var1="3" ><span class="icons dk po"></span>银行支付</div>
                    </div>
                </div>

                <div class="pay_way pay_mon">
                    <div class="way_title">接受帮助金额（元）:</div>
                    <input type="text" class="form-control input_mon" placeholder="输入金额,<?=$grule->min_money?>~<?=$grule->max_money?>" onChange= "CheckNumber(this)">
                    
                    <p class="help_reminder">
                        <label>
                            <input type="checkbox" value="" class="i_konw">
                        </label>
                        我已完全了解所有风险。我决定参与互惠金融，尊重互惠金融文化与传统。
                    </p>

                     <div class="help_btn">
                        <a href="javascript:history.go(-1);" class="come_back fl dk">返回</a>
                        <a href="javascript:;" class="give_help fl dk">接受帮助</a>
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
                    
                    <input type="password" placeholder="请输入密码" class="form-control pwd">
                </div>
                <input type="button" class="h_pay confirm1" value="确认">
                   
            </div>
        </div>
        <!-- 密码输入框 开始 -->

    <!-- Mainly scripts -->
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
		alert('请输入倍数为<?=$grule->mlutiple?>的金额'); 
		obj.select(); 
		obj.focus(); 
		return false; 
	}
	if(obj.value < <?=$grule->min_money?> || obj.value ><?=$grule->max_money?>){
		alert('请输入<?=$grule->min_money?>~~<?=$grule->max_money?>的金额'); 
		obj.select(); 
		obj.focus(); 
		return false; 
	}
} 

	$('.give_help').click(function(){
		var money = $('.input_mon').val();
		var aa = 1;
		var  pay_type = [];
		$('.pr').each(function(a,b){
			if($(b).hasClass('choose')){
				aa = 2;
			 pay_type.push($(b).attr('var1'));
			}
		})
		if(aa==1){
			alert('请至少选择一种支付方式');return false;
		}
		if(!$('.i_konw').is(":checked")){
				alert('请勾选我已完全了解所有风险按钮');return false;		
		}	
		if(money==''){
			alert('金额不能为空');return false;
		}
	    if(money % 100 !== 0){
			alert('请输入倍数为<?=$grule->mlutiple?>的金额'); 
			return false; 
		}
		if(money < <?=$grule->min_money?> || money ><?=$grule->max_money?>){
			alert('请输入<?=$grule->min_money?>~~<?=$grule->max_money?>的金额');
			return false; 
		}
        $('.theme-popover-mask').show();
        $('.them2').slideDown(200);
        $('.confirm1').unbind().on('click',function(){
            var pwd = $('.pwd').val();
            $.get('<?=Url::toRoute("user/validation")?>',{pwd:pwd},function(msg){
                    if(msg.status ==1){
                       $('.confirm1').unbind();
                        $.post('<?=Url::toRoute("user/gethelp")?>',{money:money,pay_type:pay_type},function(msg){
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
