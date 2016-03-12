<?php
use yii\helpers\Url;
?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>联系我们</h2>
                    
                </div>
                
            </div>
            <div class="wrapper wrapper-content animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox-content">
                           
                                <div class="row h_ziliao">
                                    <form action="<?=Url::toRoute('user/contact')?>" method="post" enctype="multipart/form-data">
                                    <div class="col-lg-6"> 
                                        <dl class="dl-horizontal pr">
                                            <!-- <dt>问题：</dt> 
                                            <dd class="he_que">
                                             <select name="select" class="my_select errors" style="width:100%;border:1px solid #ddd;border-radius: 4px;">
                                                 <option value="系统错误">系统错误</option>
                                                 <option value="参与者拒绝汇款">参与者拒绝汇款</option>
                                                 <option value="经理操作不合理">经理操作不合理</option>
                                                 <option value="接款者不愿确认">接款者不愿确认</option>
                                                 <option value="汇款时，对方的银行资料与系统提供的有差别">汇款时，对方的银行资料与系统提供的有差别</option>
                                                 <option value="参与者账号被封锁">参与者账号被封锁</option>
                                                 <option value="未确认收款">未确认收款</option>
                                                 <option value="错误的操作">错误的操作</option>
                                                 <option value="无法接收手机短信">无法接收手机短信</option>
                                                 <option value="无法提交提供帮助">无法提交提供帮助</option>
                                                 <option value="无法提交接收帮助">无法提交接收帮助</option>
                                                 <option value="系统显示的金额有误">系统显示的金额有误</option>
                                                 <option value="更改邮箱">更改邮箱</option>
                                                 <option value="更换手机号码">更换手机号码</option>
                                                 <option value="举报诈骗行为">举报诈骗行为</option>
                                                 <option value="无法更新汇款状态">无法更新汇款状态</option>
                                                 <option value="无法更新接款状态">无法更新接款状态</option>
                                                 <option value="未获得款项">未获得款项</option>
                                                 <option value="我需要更换我的经理">我需要更换我的经理</option>
                                                 <option value="其他">其他</option>
                                              </select>
                                               <input type="hidden" value="" class="my_select type" name="other" style="width:100%;border:1px solid #ddd;border-radius: 4px; margin:20px 0px;">
                                              <input type="hidden" class="inputs " name="_csrf" value="" placeholder="">
                                            </dd>                                           -->
                                            <dt>标题：</dt> 
                                            <dd>
                                            <input type="text" name="title" class="h_yin block"> 
                                            <input type="hidden" name="img" class="h_yin block"> 
                                            </dd>
                                            <dt>内容：</dt> 
                                            <dd><textarea name="content" class="h_chai"></textarea></dd>
                                            <dt></dt> 
                                            <dd>
                                                <div class="all_pics">
                                                    <div class="chuan_input pr fl">
                                                         <input id="uploadform" type="file"  class="add_img po">
                                                    </div>
                                                </div>
                                            </dd>
                                            <dt></dt>
                                            <dd><input type="submit" class="tijiao" style="width:50%;"> </dd>
                                        </dl>
                                    </div>
                                </form>  
                                </div>
                           
                        </div>
                    
                    </div>
               
                </div>
          

            </div>
        </div>

    </div>
  

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

    // 问题栏js
    $(".he_xuan ul").hover(function() {
       $(this).parent().show();
    }, function() {
       $(this).parent().hide();
    });
    $(".question").hover(function() {
         $(this).next().show();
    }, function() {
        $(this).next().hide();
    });
    
    $("body").on('click', '.he_xuan ul li', function(event) {
       $(".question").val($(this).html());
       $(this).parent().parent().hide();
    });
    // 问题栏js
    </script>

    <script>
     $('.errors').change(function(){
         if($(this).val() =='其他'){
            $(".type").attr('type','text');
        }else{
            $(".type").attr('type','hidden');

        }
    })
    $('.tijiao').click(function(){
        var name = $('.errors').val();
        var title = $('.head').val();
        var content = $('.content').val();
        if(name =='其他'){
            $(".type").attr('type','text');
        }else{
            $(".type").attr('type','hidden');
            $(".type").val('');
        }
        var type = $('.type').val();
        if( type==''){
            type = name;
        }
    })
    </script>
</body>

</html>
