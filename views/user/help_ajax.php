<?php if($user_help_list) foreach($user_help_list as $k=>$l):?>
	<ol class="l_con_ol">
		<li><?=$l['help_id']?></li>
		<li><?=$l['nickname']?></li>
		<li><?=$l['money']?></li>
		<li><?=$l['help_type']?></li>
		<li><b><?=$l['status'] == 1 ? '完成' : '未完成'?></b></li>
	</ol>
<?php endforeach;?>