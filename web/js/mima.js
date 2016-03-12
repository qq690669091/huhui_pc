$(document).ready(
	function() {
		$(".tanmima").click(
			function(){
				$(".mima_hei").show();
				$("#smima").animate({"bottom": "10rem"}, 100);
			}
		);
		$(".mima_guan").click(
			function() {
				$(".mima_hei").hide();
				$("#smima").animate({"bottom": "-14rem"}, 100);
			}
		);	
	}
);