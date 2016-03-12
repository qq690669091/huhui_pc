<?php
use yii\helpers\Url;
?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>新闻公告</h2>
                    
                </div>
                
            </div>
            <div class="wrapper wrapper-content animated fadeIn">
                
             
                <div class="row">
                    <div class="col-lg-12">
                         <div class="ibox float-e-margins">
                           
                            <div class="ibox-content">

                                    <div class="feed-activity-list" id="content" count="<?=ceil($count/6)?>" data-url="<?=Url::toRoute('news/index')?>" >
                                        <?php if(isset($provider)) foreach ($provider->models as  $news){?>
                                         <div class="feed-element tan1" var1="<?=$news->news_id?>">
                                            <a href="profile.html#" class="pull-left">
                                                <img alt="image" class="img-circle" src="<?=$news->cover?>">
                                            </a>
                                            <div class="media-body h_media">
                                               
                                                <strong style="font-size:20px;"><?=$news->title?></strong> 
                                                <span style="font-size:9px; float:right;"><?=date('m-d',$news->create_time)?></span> 
                                                <br>
                                               
                                                <div class="well">
                                                    <?php
                                                        $newstr = strip_tags($news->content);
                                                        $newstr = mb_substr($newstr,0,250,'utf-8');
                                                        echo $newstr.'...';
                                                    ?>
                                                </div>
                                               
                                            </div>
                                        </div>
                                        <?php } ?>
                                </div>

                        </div>
                    
                    </div>
               
                </div>
          

            </div>
        </div>

    </div>
    <!-- 弹窗 -->
    <div class="theme-popover-mask" ></div><!-- 遮罩 -->

    <!-- 文章详细弹框内容 -->
        <div class="pop them1" style="height:800px;width:900px;margin-left:-400px;top:10%;position:absolute;">
            <div class="pop_title pr">文章详细<span class="close "></span></div>
           
            <div class="pop_all" style="overflow-y:auto;height:90%;">
                <div class="ibox float-e-margins">
                           
                    <div class="ibox-content" style="border-color:#fff;">

                        <div>
                            <div class="feed-activity-list content">
                              
                            </div>
                       
                        </div>

                    </div>

                </div>
                   
            </div>
        </div>
   
    
    <!-- 文章详细弹框内容 -->

               
    <!-- 弹窗 -->

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.min.js"></script>

    <script src="js/tan.js"></script>
    <script>
    /*******************获取参数*********************/
    function GetParams(name){
         var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
         var r = window.location.search.substr(1).match(reg);
         if(r!=null) return  unescape(r[2]); return null;
    }
    
    var hasParam2 = GetParams("id");
    if(hasParam2 != null && hasParam2.length>0){
        showtank(hasParam2);
    }
    //查看详情弹窗
    function showtank(id){
            $.get("<?=Url::toRoute('news/content')?>",{id:id},function(msg){
                var content ='<div class="feed-element"> <a href="profile.html#" class="pull-left"> <img alt="image" class="img-circle" src="' +msg.cover+'"> </a> <div class="media-body h_media" > <div class="media-body h_media"> <strong style="font-size:20px;">'+msg.title+'</strong> <span style="font-size:9px; float:right;">'+msg.create_time+'</span> <br> <div class="well"> '+msg.content+'</div> </div> </div> </div>'; 
                $('.content').html(content);
                pop_Up1();
                },'json')
    };

         $('.col-lg-12').on('click','.tan1',function(){
            var id = $(this).attr('var1');
            $.get("<?=Url::toRoute('news/content')?>",{id:id},function(msg){
                var content ='<div class="feed-element"> <a href="profile.html#" class="pull-left"> <img alt="image" class="img-circle" src="' +msg.cover+'"> </a> <div class="media-body h_media" > <div class="media-body h_media"> <strong style="font-size:20px;">'+msg.title+'</strong> <span style="font-size:9px; float:right;">'+msg.create_time+'</span> <br> <div class="well"> '+msg.content+'</div> </div> </div> </div>'; 
                $('.content').html(content);
                pop_Up1();
                },'json')
         })
    </script>

    <script>
        var per_page = 1;
            $(window).on("scroll", function() {
                //判断到达底部时，自动加载
                var sct = ($(document).height() - $(window).height()),
                    sct2 = $(document).scrollTop()+10;
                    pages    = $('#content').attr('count'),
                    url   =  $('#content').attr('data-url');
                if (sct2 >= sct) {
                    ++per_page;
                    if(per_page <=pages){
                        $.get(url,{page:per_page}, function(msg){
                            $("#content").append(msg);
                        });
                    }
                }
            });
    </script>
