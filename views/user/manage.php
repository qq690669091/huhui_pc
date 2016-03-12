<?php
use yii\helpers\Url;

?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>管理</h2>
                    
                </div>
                
            </div>
            <div class="wrapper wrapper-content animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <p style="overflow:hidden;">
                                <div class="input-group h_search">
                                    <input type="text" placeholder="搜索单号/用户" class="input-sm form-control search_data"> <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary search_click langse" > 搜索</button> </span>
                                </div>
                                <b>状态：</b>
                                <select class="input-sm form-control input-s-sm inline h_slect help_type_click" >
                                    <option value="0">提供帮助</option>
                                    <option value="1">接受帮助</option>
                                </select>
                            </p>
                            <div class="ibox-content">

                                    <div class="table-responsive" style="border:1px solid #ddd;">
                                        <table class="table table-striped he_table">
                                            <thead>
                                                <tr>

                                                    <th>单号</th>
                                                    <th>用户</th>
                                                    <th>金额（元）</th>
                                                    <th>状态</th>
                                                    <th>明细</th>                                                                                                    
                                                </tr>
                                            </thead>

                                            <div id="container_data">
                                                <tbody>
                                                    <?php if($user_help_list) foreach($user_help_list as $k=>$l):?>
                                                    <tr >
                                                        <td><?=$l["help_id"]?></td>
                                                        <td><?=$l["nickname"]?></td>
                                                        <td><?=$l["money"]?></td>
                                                        <td><?=$l["help_type"]?></td>

                                                        <td>
                                                            <button type="button" class="btn btn-outline btn-primary detail_click" help_id="<?=$l["help_id"]?>"><?=$l["order_status"]?></button>

                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                    <!--btn-primary btn-info btn-warning-->
                                                </tbody>
                                            </div>
                                        </table>

<!--                                        <div class="pages" style="width:80%;margin:0 auto;text-align: center;">-->
<!--                                            <div class="btn-group" style="margin:10px auto;">-->
<!--                                                <a href="#" class="btn btn-white"><<i class="fa fa-chevron-left"></i>-->
<!--                                                </a>-->
<!--                                                <a href="#"class="btn btn-white">1</a>-->
<!--                                                <a href="#"class="btn btn-white  active">2</a>-->
<!--                                                <a href="#"class="btn btn-white">3</a>-->
<!--                                                <a href="#"class="btn btn-white">4</a>-->
<!--                                                <a href="#" class="btn btn-white">><i class="fa fa-chevron-right"></i>-->
<!--                                                </a>-->
<!--                                            </div>-->
<!--                                        </div>-->
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


    <!-- 交易成功弹框内容 -->
    <div class="pop them1" style="height:auto;width:600px;margin-left:-300px;top:30%">
        <div class="pop_title pr">交易明细<span class="close "></span></div>

        <div class="pop_all" id="order_detail_data">

        </div>
    </div>

    <!-- 交易成功弹框内容 -->

               
    <!-- 弹窗 -->

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.min.js"></script>

    <script src="js/tan.js"></script>
    <script>
        $("body").on('click', '.detail_click', function(event) {
            var help_id  = $(this).attr("help_id");
            var url = "<?=Url::toRoute("user/manager_order_detail")?>";
            var data = {
                help_id : help_id
            }
            $.get(url,data,function(msg){
                $("#order_detail_data").html(msg);
                pop_Up1();
            })

        });
        $("body").on('click', '.search_click', function(event) {
            var search = $(".search_data").val();
            var url = "<?=Url::toRoute("user/manager_ajax")?>";
            var data = {
                search : search
            }
            $.get(url,data,function(msg){
                $("tbody").empty();
                $("tbody").html(msg);
            })
        });
        $("body").on('click', '.help_type_click', function(event) {
            var help_type_data = $(this).val();
            var url = "<?=Url::toRoute("user/manager_ajax")?>";
            var data = {
                help_type : help_type_data
            }
            $.get(url,data,function(msg){
                $("tbody").empty();
                $("tbody").html(msg);
            })
        });

    </script>

