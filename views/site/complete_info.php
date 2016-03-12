<?php
use yii\helpers\Url;
?>
    <style>
        .dl-horizontal dt{width:300px;}
        .add_card{margin-left: 170px;}
    </style>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>个人中心</h2>
                    
                </div>
                
            </div>
            <div class="wrapper wrapper-content animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox-content">
                                
                                  <div class="row h_ziliao">
                                <form action="<?=Url::toRoute('site/complete_info')?>" method="post">
                                    <div class="col-lg-8">
                                        <dl class="dl-horizontal">
                                            <!-- h_yin输入框默认状态为隐藏，若想要其出现加上类block即可。 -->
                                            <dt>姓名：</dt> 
                                            <dd><input type="text" class="h_yin block" style="width:50%;" name="nickname"  placeholder="必填"   required > </dd>
                                            <dt>微信号：</dt> 
                                            <dd><input type="text" class="h_yin block" style="width:50%;" name="weixin" placeholder="必填"  required > </dd>
                                            <dt>支付宝：</dt> 
                                            <dd><input type="text" class="h_yin block" style="width:50%;" name="alipay" placeholder="必填"  required > </dd>
                                            <dd><input type="hidden" class="h_yin block" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">   </dd>
                                        </dl>
                                    </div>
                                     <div class="col-lg-8 bank">
                                        <dl class="dl-horizontal ">
                                           
                                            <dt>银行名称：</dt> 
                                            <dd><input type="text" class="h_yin block" style="width:50%;" name="bk_name1" placeholder="必填" required ></dd>
                                            <dt>银行支行名称：</dt> 
                                            <dd><input type="text" class="h_yin block" style="width:50%;" name="bk_zh1" placeholder="必填" required ></dd>
                                            <dt>银行卡号：</dt> 
                                            <dd><input type="text" class="h_yin block" style="width:50%;"  minlength="19" maxlength="19"  name="bk_ca1" placeholder="必填"  required ></dd>
                                            <dt>银行账户持有人开户名：</dt>
                                            <dd><input type="text" class="h_yin block" style="width:50%;" name="name1" placeholder="必填" required></dd>
                                            
                                        </dl>
                                        
                                    </div>
                                   
                                    <div class="col-lg-8 bank">
                                        <dl class="dl-horizontal">
                                            <dt>银行名称2：</dt> 
                                            <dd><input type="text" class="h_yin block" style="width:50%;" name="bk_name2" placeholder="可填"></dd>
                                            <dt>银行支行名称2：</dt> 
                                            <dd><input type="text" class="h_yin block" style="width:50%;" name="bk_zh2" placeholder="可填"></dd>
                                            <dt>银行卡号2：：</dt> 
                                            <dd><input type="text" class="h_yin block" minlength="19" maxlength="19" style="width:50%;" name="bk_ca2" placeholder="可填" ></dd>
                                            <dt>银行账户持有人开户名2：</dt>
                                            <dd><input type="text" class="h_yin block" style="width:50%;" name="name2" placeholder="可填"></dd>
                                            
                                        </dl>
                                    </div>
                                    <div class="col-lg-8 bank"><input type="submit" class="dk tijaio " value="确认" style="margin-left:300px;width:30%;"></div>
                                    </form>
                                    <p class="col-lg-8 bank" style="color:red; margin-left:50px; margin-top:20px;">注：确认后资料将不可修改,请谨慎填写！</p>
                                </div>
                           
                        </div>
                    
                    </div>
               
                </div>
          

            </div>
        </div>

    </div>
    <!-- 弹窗 -->
    <div class="theme-popover-mask" ></div><!-- 遮罩 -->

    <!-- 推荐人弹框内容 -->
                <div class="pop them3" style="top:30%;padding-bottom:3rem;width:20%;margin-left:-10%;">
                    <div class="pop_title pr">推荐人信息<span class="close "></span></div>
                   
                    <div class="pop_all">
                        <p class="recommend_inf" >
                            <span class="recommend_inf_left fl">姓名：</span>
                            <span class="recommend_inf_right fl">张三</span>
                        </p>
                        <p class="recommend_inf" >
                            <span class="recommend_inf_left fl">电话：</span>
                            <span class="recommend_inf_right fl">1213415597457</span>
                        </p>

                        <p class="recommend_inf" >
                            <span class="recommend_inf_left fl">微信号：</span>
                            <span class="recommend_inf_right fl">1213415597457</span>
                        </p>
                        <p class="recommend_inf" >
                            <span class="recommend_inf_left fl">等级：</span>
                            <span class="recommend_inf_right fl">2级</span>
                        </p>      
                        <p class="h_btns" style="margin-top:30px;width:130px;">                        
                            <button type="button" class="btn btn-w-m btn-primary">确定</button>                           
                        </p>
                    </div>
                </div>
                
                <!-- 推荐人弹框内容 -->

               
    <!-- 弹窗 -->

    <script src="js/jquery-2.1.1.min.js"></script>
    <script>
        $("body").on('click', '.tan3', function(event) {
            pop_Up3();
        });
        
         
    </script>
    <script>
        $("body").on('click', '.add_card', function(event) {
        var nei = $(".bank").html();
        $(this).before(nei);
    });
    </script>

    <script>
    $('.tijaio').click(function(){
        var nickname  = $("input[name='nickname']").val();     
        var bk_zh2  = $("input[name='bk_zh2']").val();     
        var bk_zh1  = $("input[name='bk_zh1']").val();     
        var weixin  = $("input[name='weixin']").val();     
        var alipay  = $("input[name='alipay']").val();     
        var bk_name1  = $("input[name='bk_name1']").val();     
        var bk_ca1  = $("input[name='bk_ca1']").val();     
        var name1  = $("input[name='name1']").val(); 
        var bk_name2  = $("input[name='bk_name2']").val();     
        var bk_ca2  = $("input[name='bk_ca2']").val();     
        var name2  = $("input[name='name2']").val();
        if(nickname ==''){
            alert('姓名不能为空');return false;
        }else if(weixin ==''){
            alert('微信号不能为空');return false;
        }else if(alipay ==''){
            alert('支付宝号不能为空');return false;
        }else if(bk_name1 ==''){
            alert('银行名称不能为空');return false;
        }else if(bk_zh1 ==''){
            alert('银行支行名称不能为空');return false;
        }else if(bk_ca1 ==''){
            alert('银行卡号不能为空');return false;
        }else if(!/^\d{19}$/.test(bk_ca1)){
                alert('请输入正确的银卡卡号信息');return false;
        }else if(name1 ==''){
            alert('持卡人姓名不能为空');return false;
        } 
        if(nickname != name1){
            alert('持卡人姓名要与用户姓名一致');return false;
        }
        if(bk_name2 =='' || bk_zh2 =='' || bk_ca2 =='' || name2 ==''){
            alert('银行卡2的信息不能为空');return false;
        }
         if(!/^\d{19}$/.test(bk_ca2)){
            alert('请输入正确的银卡卡号2信息');return false;
        }
    })
    </script>

