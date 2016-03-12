<?php
		header("Content-type: text/html; charset=utf-8");

function dump(){
	echo "<pre style='font-size:18px;'>";
	$exit = true;
	$args = func_get_args();
	$num  = func_num_args();
	if($num){
		if($args[$num-1] === 'n'){
			$exit = false;
			array_pop($args);
			$num--;
		}
		for($i = 0;$i < $num;$i++){
			if(is_bool($args[$i]) || !$args[$i]){
				var_dump($args[$i]);
			}else{
				print_r($args[$i]);
			}
			echo '<hr/>';
		}
		if($exit) exit;
	}
	echo '</pre>';
}

if (!function_exists('js_location')) {
	function js_location($url, $alert = '') {
		if($alert){
			echo "<script>alert('{$alert}');</script>";
		}
		echo "<script>window.location='$url';</script>";
		exit;
	}
}

if (!function_exists('go_back')) {
	function go_back($alert = ''){
		$alert && js_alert($alert);
		exit("<script>window.history.go(-1)</script>");
	}
}

if (!function_exists('alert')) {
	function alert($alert = ''){
		$alert && js_alert($alert);
	}
}


if (!function_exists('js_alert')) {
	function js_alert($msg) {
		echo "<script>alert('$msg');</script>";
	}
}


if (!function_exists('time_tran')) {
	function time_tran($the_time){
		$now_time = time();
	    $show_time = $the_time;
	    $dur = $now_time - $show_time;
	    if($dur < 0){
	        return $the_time;
	    }elseif($dur < 60){
	        return $dur.'秒前';
	    }elseif($dur < 3600){
	        return floor($dur/60).'分钟前';
	    }elseif($dur < 86400){
	        return floor($dur/3600).'小时前';
	    }elseif($dur < 604800){//7天内
	        return floor($dur/86400).'天前';
	    }elseif($dur < 2592000){//一个月内
	        return floor($dur/604800).'个星期前';
	    }elseif($dur < 31536000){//3天内
	        return floor($dur/2592000).'个月前';
	    }else{
	        return '一年以前';
	    }
	}
}


//月初
if (!function_exists('monthstar')) {
	function monthstar(){
		return mktime(0,0,0,date('m'),1,date('Y'));
	}
}

//月尾
if (!function_exists('monthend')) {
	function monthend(){
		return mktime(23,59,59,date('m'),date('t'),date('Y'));
	}
}

//上个月月初
if (!function_exists('pre_monthstar')) {
	function pre_monthstar(){
		return  mktime(0,0,0,date('m')-1,1,date('Y'));
	}
}

//上个月月尾
if (!function_exists('pre_monthend')) {
	function pre_monthend(){
		return mktime(23,59,59,date("m") ,0,date("Y"));
	}
}

 /**
  * function      上传文件处理函数
  * param    string     $name      表单的上传文件框的name名称
  * param    array      $type      限制上传文件的类型
  * param    int        $size      限制上传文件的大小[君子协定] 单位: 字节
  * param    string     $path      指定上传文件的保存路径
  * return   array                 上传成功返回2个成员，失败返回一个成员
  */
    function uploads($name,$type=array('jpg','png','gif','jpeg'),$size=1048576,$path='/huhui_weixin/web/upload'){
        $file = $_FILES[$name];
        # 1. 判断当前文件是否是post过来的文件  is_uploaded_file();
        if(!is_uploaded_file($file['tmp_name'])){
           return go_back('上传图片大小不能超过1mb大小!');die;
        }
        # 2. 上传文件的错误状态判断 只有 error为0 的时候我们才会做文件上传处理
        if($file['error'] == 1 ){
           return go_back('上传文件太大!');die;
        }else if($file['error'] == 2 ){
           return go_back('上传文件太大!');die;
        }else if($file['error'] == 3 ){
           return go_back('上传文件不完整!');die;
        }else if($file['error'] == 4 ){
           return go_back('没有找到上传文件');die;
        }else if($file['error'] >4 ){
           return go_back('上传文件发生了未知错误,请联系网站工作人员!');
        }

        # 上传文件的类型判断

        #获取文件后缀
        $pre = pathinfo($file['name'],PATHINFO_EXTENSION);

        if(!in_array( strtolower($pre),$type) ){
			return go_back('上传文件的类型不正确!');die;
        }

        # 对上传文件大小进行判断
        if ($file['size'] > $size ){
           return go_back('上传不能超过1mb大小!');die;
        }

        # 移动上传文件到我们的目录里面去
        # move_uploaded_file();
        # 为了防止上传文件的重命名，建议使用 微秒时间戳加上 随机数
        $newname = date('YmdHis',time()).mt_rand(10000,99999);
        $res = move_uploaded_file($file['tmp_name'],'../..'.$path.'/'.$newname.'.'.$pre);
        if($res){
           return $res =$path.'/'.$newname.'.'.$pre ;
        }else{
			return go_back('上传文件失败');die;
        }
    }


/**
 * @desc 数据转换成json格式
 * @param mixed $data 数据
 * @param string $encode 是否json_encode
 * @author RZLIAO
 * @date 2015-11-19
 * @return void|boolean
 */
if (!function_exists('renderjson')) {
	function renderjson($data, $encode = TRUE)
    {
        if (empty($data)) {
            return false;
        }
        header('Content-type: application/json');
		echo $encode ?json_encode($data):$data;
        exit;
    }
}





//倒计时
function showtime($showtime){

		$time   = explode(".",$showtime);
		$hour   = $time[0];
 		$minute =  ($showtime-$hour)*60;
		$minute = floor($minute);
		if($showtime >=0){
			if($minute <10){
				return $hour.':0'.$minute;
			}else if($minute == 0){
				return $hour.':00';
			}else if($minute >=10){
				return $hour.':'.$minute;
			}
		}else{
			return 0 ;
		}
}

//$img 为base64位编码的 图片
//$path 为要存放的路径
function uploadImg($img,$path){
	if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img, $result)){
        $name = date('Ymd').mt_rand().'.'.$result[2];
        file_put_contents($path.$name ,base64_decode(str_replace($result[1], '', $img)));
        return $name;
    }
}
