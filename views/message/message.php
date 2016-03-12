<?php 
use yii\helpers\Url;
 ?>
	<div class="kong"></div><!-- 只是用来撑开距离的 -->
	
	<div class="all_notes">
		<div class="notes_link none">来自<b class="lan"><?=$model->target_id==0?"管理员":$model->user->account;?></b>的留言 <b class="time fr"><?=time_tran($model->create_time)?></b></div>
	</div>
	<?php if($model->content !==''){ ?>
	<p class="inform_text">
			<?=$model->content?>
	</p>
	<?php }?>
	<?php if(!empty($model->img)){ ?>
	<p class="inform_text">
		<img  style="width:250px;height:250px;" src="<?=$model->img?>" alt="">
	</p>
	<?php }?>
	<form action="<?=Url::toRoute("message/message")?>" method="post" enctype="multipart/form-data">
		
	<div class="all_notes" style="padding-bottom:1rem;border-bottom: 1px solid #cccccc;">
		<textarea class="leave_words" name="content" placeholder="请输入留言"></textarea>

		<div class="all_pics">
			<div class="chuan_input pr fl">
				<input type="file"  name="url"  class="add_img po">
				<input type="hidden" class="inputs " name="_csrf" value="<?= Yii::$app->request->csrfToken ?>" placeholder="">
				<input type="hidden" class="inputs " name="target_id" value="<?=$model->target_id?>" placeholder="">
			</div>
		</div>
	</div>

	<div class="help_btn" style="margin-top:1rem;">
		<a href="javascript:history.go(-1);" class="come_back fl dk" style="background:#cccccc;">取消</a>
		<input type="submit" value="确认" style="width:48%;border-radius:6px;background:#cccccc;" class="give_help fl dk confirm">
	</div>
	</form>
	
<script src="js/jquery-1.11.1.min.js"></script>
<script>
	
	// 图片上传
	$(function(){
		var formdata = new FormData();
		$(".add_img").on("change", function(){
		    var files = !!this.files ? this.files : [];
		    if (!files.length || !window.FileReader) return;
		    for(var i=0;i<files.length;i++){
		        if (/^image/.test( files[i].type)){
		            var reader = new FileReader();
		            reader.readAsDataURL(files[i]);
		            formdata.append("img[]", files[i]);
		            reader.onloadend = function(){

		               $('.chuan_input').before("<div class='h_wai fl pr'><img src='" + this.result + "'><span class='close1 po dk'></span></div>");

		            }
		        }
		    }
		});


	});	
	// 图片上传

	// 删除图片
	$("body").on('click', '.close1', function(event) {
		$(this).parent().remove();
	});
	// 删除图片

	// $('.confirm').click(function(){
	// 	var content = $('.leave_words').val();
	// 	$.post('<?=Url::toRoute("message/message")?>',{content:content},function(msg){
	// 		if(msg.status ==1){
	// 			alert('留言成功');
	// 			window.location='<?=Url::toRoute("message/index")?>';
	// 		}else{
	// 			alert('留言失败');return;
	// 		}
	// 	},'json')
	// })

</script>
