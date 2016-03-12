<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimal-ui">
	<title>我的推广链接</title>
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/mine.css">
	<style type="text/css">
		.input_all{border: none; height: none;}
		.input_all h3{color:#666666; margin-bottom: 1.2rem;}
		.main {padding: 1.5rem 1rem ; height: 35rem; }
		.lianjie{ height: 2rem; color:#333;}		
		.mt10{height: 2.5rem; width: 100%;}
		.input_all .ewm{width: 14rem; height: 14rem;}
		.ewm_box{width: 100%; text-align: center;}
		.ewm_span{padding: 0.5rem; display:inline-block; border: 1px solid #ccc; border-radius: 3px;}
	</style>
</head>
<body>
<div class="h_header pr">
	<a href="<?=Url::toRoute("user/info")?>" class="go_back fl">取消</a>
	<span class="dk title po">我的推广链接</span>

</div>
<div class="main">

	<div class="input_all input_all2" >
		
		<div>
			<h3>推广地址:</h3>			
			<span  class="lianjie" ><?=$url_path?></span>
			<div class="mt10"></div>
			<h3 clacc="tgewm">推广二维码:</h3>	
			<div class="ewm_box">
				<span class="ewm_span">
					<img src="<?=Url::to(['site/user_qrcode_img'])?>" alt="" class="ewm">
				</span>	
			</div>					
		</div>

		<div class="fail_main" style="margin-top:12px">


		</div>

	</div>
</div>
</body>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/wenzi.js"></script>
</html>