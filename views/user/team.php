<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\UserRelation;
?>
       

        <div id="page-wrapper" class="gray-bg dashbard-1">
            
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>团队</h2>
                    
                </div>
                
            </div>
            <div class="wrapper wrapper-content animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <p style="overflow:hidden;">
                                <div class="input-group h_search">
                                    <input type="text" placeholder="输入用户ID、姓名或用户名" class="input-sm form-control team_search_data"> <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary langse" id="team_search"> 搜索</button> </span>
                                </div>
                                <b>级别：</b>                                                  
                                <select class="input-sm form-control input-s-sm inline h_slect level_data" >
                                    <option value="0">全部</option>
                                    <?php if($level_list) foreach($level_list as $k=>$v):?> 
                                    <option value="<?=$v['level_id']?>"><?=$v['name']?></option>
                                    <?php endforeach;?>
                                </select>
                            </p>  
                            <div class="ibox-content">

                                <mydata id = "team_data">
                                    <div class="table-responsive" style="border:1px solid #ddd;">
                                        <table class="table table-striped he_table">
                                            <thead>
                                                <tr>

                                                    <th>用户ID</th>
                                                    <th>姓名</th>
                                                    <th>用户名</th>
                                                    <th>级别</th>
                                                    <th>团队人数</th> 
                                                    <th>状态</th>                   
                                                    <th>加入时间</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if($user_list) foreach($user_list->models as $models):?>
                                                
                                                <tr >
                                                    <td><?=$models->user_id?></td>
                                                    <td><?=$models->usert->nickname?></td>
                                                    <td><?=$models->usert->account?></td>
                                                    <td><?=$models->usert->level->name?></td>
                                                    <td><?=count((new UserRelation())->getChilds($models->user_id)->asArray()->all())+1?></td>
                                                    <td><?=$models->usert->is_active == 1 ? '已激活' : '未激活'?></td>
                                                    <td><?=date('Y-m-d H:s',$models->usert->create_time)?></td>                                                          
                                                </tr>
                                            <?php endforeach ?>
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
                                    </mydata>
                            </div>
                        </div>
                    
                    </div>
               
                </div>
          

            </div>
        </div>

    </div>
    <!-- 弹窗 -->
    <div class="theme-popover-mask" ></div><!-- 遮罩 -->

    <!-- 交易成功弹框内容 -->
    <div class="pop them1" style="height:auto;width:600px;margin-left:-300px;top:30%">
        <div class="pop_title pr">交易明细<span class="close "></span></div>
       
        <div class="pop_all">
            <h1 style="margin-top:0;text-align:center;">订单状态：完成/匹配中/未完成</h1>
            <div class="mail-tools tooltip-demo m-t-md he_jiao">
                <h3>
                    <span class="font-noraml">编号：</span>28
                </h3>
                 <h3>
                    <span class="font-noraml">金额（元）： </span>300（元）
                </h3>
                <h3>
                    <span class="font-noraml">下单天数： </span>2
                </h3>
                <h3>
                    <span class="font-noraml">下单时间：</span>2016-01-05 14:58:26
                </h3>
                <h3>
                    <span class="font-noraml">推荐人：</span>是对方个地方
                </h3>
                <h3>
                    <span class="font-noraml">手机号: </span>1258566995
                </h3>
                <h3>
                    <span class="font-noraml">用户： </span>是对方换个地方
                </h3>
                <h3>
                    <span class="font-noraml">手机号: </span>1258566995
                </h3>
                 <h3>
                    <span class="font-noraml">交易状态： </span>已确认
                </h3>
                <h3>
                    <span class="font-noraml">状态: </span>已激活
                </h3>
               
            </div>
           
          
            <p class="h_btns">                                       
                <button type="button" class="btn btn-w-m btn-primary" style="margin-right:160px;">确认</button>                           
            </p>
        </div>
    </div>
    
    <!-- 交易成功弹框内容 -->

               
    <!-- 弹窗 -->

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script>
    /**
     * 团队筛选
     */
    
    $('body').on('change','.level_data',function(){
        var url = "<?=Url::toRoute('user/team')?>";
        var data  = {
            level    :   $(this).val(),
        };
        $.get(url,data,function(msg){
            $("#team_data").html(msg);
        });
    });

        /**
     * 搜索
     */
    $("body").on('click',"#team_search",function(){
        var url = "<?=Url::toRoute('user/team')?>";
        var data  = {
            search      :   $(".team_search_data").val(),
        };

        $.get(url,data,function(msg){
            $("#team_data").html(msg);
        })
    });
    //分页
      $('body').on('click','.pagination a', function(){
        var data  = {
            page : $(this).data('page') + 1
        }
        $.get('?r=user/team', data, function(msg){
            $('#team_data').html(msg);
        })
        return false;
    })
    </script>
