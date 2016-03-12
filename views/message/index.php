<?php
use yii\helpers\Url;
?>

	<div class="kong"></div><!-- 只是用来撑开距离的 -->

	<div class="all_notes">
	<?php foreach ($model as $mess): ?>
		
		<a href="<?=Url::toRoute(['message/message','mess_id'=>$mess->mess_id])?>" class="notes_link dk ">来自<b class="lan"><?=$mess->target_id==0?"管理员":$mess->user->account;?></b>的留言 <b class="time fr"><?=time_tran($mess->create_time)?></b><?=$mess->status!=3?'<b style="color:red;">......</b>':'';?></a>
	<?php endforeach ?>
	</div>
<script src="js/jquery-1.11.1.min.js"></script>
