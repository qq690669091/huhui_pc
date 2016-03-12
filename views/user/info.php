<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
 ?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>个人资料</h2>
                </div>

            </div>
            <div class="wrapper wrapper-content animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox-content">
                            <div class="row">
                                    <div class="col-lg-12">
                                        <div class="m-b-md">
                                            <div href="#" style="margin-left:67px;" class="touxiang">
                                                <input id="uploadform" type="file"  class="chuang">
                                                <div id="imgHeadicon">
                                                    <?php if($model['headicon'] ==""){ ?>
                                                    <img alt="image" class="img-circle" style="width:222px;height:220px;" src="img/a3.jpg">
                                                    <?php }else{?>
                                                    <img alt="image" class="img-circle" style="width:222px;height:220px;" url="<?=$model['headicon']?>"  src="<?=$model['headicon']?>">
                                                    <?php }?>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="row h_ziliao">
                                    <div class="col-lg-3">
                                        <dl class="dl-horizontal">
                                            <!-- h_yin输入框默认状态为隐藏，若想要其出现加上类block即可。 -->
                                            <dt>用户名：</dt>
                                            <dd><?=$model['nickname']?></dd>
                                            <dt>推荐人：</dt>
                                            <dd><a href="javascript:;" class="tan3"><?=isset($parent)?$parent->nickname:'互惠金融';?></a></dd>
                                            <dt>微信号：</dt>
                                            <dd><?=$model['weixin']?><input type="text" class="h_yin"></dd>
                                            <dt>支付宝：</dt>
                                            <dd><?=$model['alipay']?><input type="text" class="h_yin"></dd>
                                        </dl>
                                    </div>
                                    <div class="col-lg-5" id="cluster_info">
                                        <dl class="dl-horizontal">
                                            <dt>银行名称：</dt>
                                            <dd><?=$model['bank']['bk1']?><input type="text" class="h_yin" style="width:70%;"></dd>
                                            <dt>银行支行名称：</dt>
                                            <dd><?=$model['bank']['bk_zh1']?><input type="text" class="h_yin" style="width:70%;"></dd>
                                            <dt>银行账户号码：</dt>
                                            <dd><?=$model['bank']['bkc1']?><input type="text" class="h_yin" style="width:70%;"></dd>
                                            <dt>银行账户持有人开户名：</dt>
                                            <dd><?=$model['bank']['name1']?><input type="text" class="h_yin" style="width:70%;"></dd>
                                            <?php if(isset($model['bank']['bk2']) && $model['bank']['bk2'] !=='' ){ ?>
                                            <dt>银行名称2：</dt>
                                            <dd><?=$model['bank']['bk2']?><input type="text" class="h_yin" style="width:70%;"></dd>
                                            <dt>银行支行名称2：</dt>
                                            <dd><?=$model['bank']['bk_zh2']?><input type="text" class="h_yin" style="width:70%;"></dd>
                                            <dt>银行账户号码2：</dt>
                                            <dd><?=$model['bank']['bkc2']?><input type="text" class="h_yin" style="width:70%;"></dd>
                                            <dt>银行账户持有人开户名2：</dt>
                                            <dd><?=$model['bank']['name2']?><input type="text" class="h_yin" style="width:70%;"></dd>
                                            <?php 	} ?>
                                            <dt>我的推广链接：</dt>
                                            <dd><?=$url_path ?></dd>
                                            <dt>我的推广二维码：</dt>
                                            <dd>
                                                <div class="photos">
                                                    <a target="_blank" href="#">
                                                        <img alt="image" class="feed-photo" src="<?=Url::to(['site/user_qrcode_img'])?>">
                                                    </a>

                                                </div>
                                            </dd>
                                        </dl>
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

    <!-- 推荐人弹框内容 -->
                <div class="pop them3" style="top:30%;padding-bottom:3rem;width:20%;margin-left:-10%;">
                    <div class="pop_title pr">推荐人信息<span class="close "></span></div>

                    <div class="pop_all">
                        <p class="recommend_inf" >
                            <span class="recommend_inf_left fl">姓名：</span>
                            <span class="recommend_inf_right fl"><?=isset($parent)?$parent->nickname:'互惠金融';?></span>
                        </p>
                        <p class="recommend_inf" >
                            <span class="recommend_inf_left fl">电话：</span>
                            <span class="recommend_inf_right fl"><?=isset($parent)?$parent->phone:'无';?></span>
                        </p>

                        <p class="recommend_inf" >
                            <span class="recommend_inf_left fl">微信号：</span>
                            <span class="recommend_inf_right fl"><?=isset($parent)?$parent->weixin:'无';?></span>
                        </p>
                        <p class="recommend_inf" >
                            <span class="recommend_inf_left fl">等级：</span>
                            <span class="recommend_inf_right fl"><?=isset($parent)?$parent->level->name:'无';?></span>
                        </p>
                        <p class="h_btns" style="margin-top:30px;width:130px;">
                            <button type="button" class="btn btn-w-m btn-primary">确定</button>
                        </p>
                    </div>
                </div>

                <!-- 推荐人弹框内容 -->


    <!-- 弹窗 -->

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.min.js"></script>
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
                    html = '<img alt="image" class="img-circle" style="width:222px;height:220px;" src="'+imgData+'">'
                    $('#imgHeadicon').html(html);
                    var data = {
                        img : imgData,
                    }
                    $.post('?r=user/info',data,function(){
                        alert('上传头像成功');
                        location.reload();
                    })
                });

            });
        })
    }
})
</script>
</body>

</html>
