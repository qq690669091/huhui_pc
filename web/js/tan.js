
function pop_Up1(){
	$('.theme-popover-mask').show();
	$('.them1').slideDown(200);
}
function pop_Up2(){
	$('.theme-popover-mask').show();
	$('.them2').slideDown(200);
}
function pop_Up3(){
	$('.theme-popover-mask').show();
	$('.them3').slideDown(200);
}

$("body").on('click', '.close,.cancle,.confirm,.btn-primary,.gb', function(event) {
	$('.theme-popover-mask').hide();
	$('.pop').slideUp(200);
});
$("body").on('click', '.tan2', function(event) {
	$('.theme-popover-mask').show();
	$('.them2').slideDown(200);
});
function get_base64img_suffix(dataURI){
    var pre = dataURI.split(',')[0];
    pre = pre.split('/')[1];
    pre = pre.split(';')[0];
    return pre;
 }