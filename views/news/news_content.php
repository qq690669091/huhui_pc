<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimal-ui">
	<title>财务</title>
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/style.css">
<style>
	.aa{
		overflow:hidden; 
		white-space:nowrap; 
		text-overflow:ellipsis; /* for IE */ 
		-o-text-overflow: ellipsis; /* for Opera */ 
		-icab-text-overflow: ellipsis; /* for iCab */ 
		-khtml-text-overflow: ellipsis; /* for Konqueror Safari */ 
		-moz-text-overflow: ellipsis; /* for Firefox,mozilla */ 
		-webkit-text-overflow: ellipsis; /* for Safari,Swift*/ 
	}

</style>
</head>
<body >
	<div class="header pr">
		<a href="javascript:history.go(-1);" class="go_back dk po"></a>
		<span class="header_title po dk">详情</span>
	</div>
	<div class="kong"></div><!-- 只是用来撑开距离的 -->

	<div class="information_all" style="padding:1rem;background:#fff;">
			<div class="information_user information_mian">
				<img src="<?=$model->cover?>" alt="" class="information_img fl dk">
				<b class="time fl"><?=$model->title?></b>
				<b class="time fr aa"><?=date('m-d',$news->create_time)?></b>
			</div>
			<div class="information_body">
				<?=$model->content?>
			</div>
	
	</div>
</body>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/wenzi.js"></script>

</html>