
<h1 style="margin-top:0;text-align:center;">订单状态：<?=$order_data["order_status"]?></h1>
<div class="mail-tools tooltip-demo m-t-md he_jiao">
	<h3>
		<span class="font-noraml">编号：</span><?=$order_data["help_id"]?>
	</h3>
	<h3>
		<span class="font-noraml">金额（元）： </span><?=$order_data["money"]?>（元）
	</h3>
	<h3>
		<span class="font-noraml">下单天数： </span>2
	</h3>
	<h3>
		<span class="font-noraml">下单时间：</span><?=date("Y-m-d H:m:s",$order_data["create_time"])?>
	</h3>
	<h3>
		<span class="font-noraml">推荐人：</span><?=$order_data["parent_nickname"]?>
	</h3>
	<h3>
		<span class="font-noraml">手机号: </span><?=$order_data["parent_phone"]?>
	</h3>
	<h3>
		<span class="font-noraml">用户： </span><?=$order_data["nickname"]?>
	</h3>
	<h3>
		<span class="font-noraml">手机号: </span><?=$order_data["phone"]?>
	</h3>
<!--	<h3>-->
<!--		<span class="font-noraml">交易状态： </span>已确认-->
<!--	</h3>-->
<!--	<h3>-->
<!--		<span class="font-noraml">状态: </span>已激活-->
<!--	</h3>-->

</div>


<p class="h_btns">
	<button type="button" class="btn btn-w-m btn-primary" style="margin-right:160px;">确认</button>
</p>
