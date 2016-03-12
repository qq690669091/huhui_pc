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
			

						<div class="table-responsive" style="border:1px solid #ddd;">
							<div id="tree" style="width: 40%"></div>

						</div>

			</div>

		</div>


	</div>
</div>


<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.min.js"></script>
<script src="js/bootstrap-treeview.js"></script>
<script>


	var tree_data = <?=$tree?>;
	console.log(tree_data);
	$('#tree').treeview({data: tree_data});
</script>
