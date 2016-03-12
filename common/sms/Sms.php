<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 16/1/20
 * Time: 19:39
 */

namespace app\common\sms;
use yii;

class Sms

{   private  $_url     = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
	private  $_account = "cf_2118125709";
	private  $_password = "hjjmjqab";

	/**
	 * 功能:  传入手机号,成功则反悔验证码.
	 *
	 * @param int $phone  电话号码,不能为空
	 * @param int $code   验证码;可选
	 * @return int 0:$code  成功则返回验证码,失败反悔 0;
	 */
	public function send_code($phone,$code = 0){

		if(!$phone){
			//电话号码不能为空
			return 0;
		}

		//若没有填写验证码,则自动生成5位数验证码.
		if(!$code){
			$mobile_code = rand(10000,99999);
		}else{
			$mobile_code = $code;
		}



		$post_data = [
			'account'   =>  $this->_account,
			'password'  =>  md5($this->_password),
			'mobile'    =>  $phone,
			'content'   =>  rawurlencode("您的验证码是：".$mobile_code."。请不要把验证码泄露给其他人。")
		];
		$post_data = $this->arrayToString($post_data);

		$res = $this->Post($post_data,$this->_url);
		$ok = strrpos($res,'成功');
		if($ok){
			return $mobile_code;
		}else{
			return 0;
		}
	}


	/**
	 * @param $curlPost
	 * @param $url
	 * @return mixed
	 */
	public function Post($curlPost,$url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
		$return_str = curl_exec($curl);
		curl_close($curl);
		return $return_str;
	}


	/**
	 * 功能: 将关联数组拆成path info字符串
	 *
	 * @param array $source 关联数组
	 * @return bool|string  成功则返回字符串
	 */
	public function arrayToString($source = []){
		if(!is_array($source) || !$source){
			return false;
		}

		$res = "";
		foreach($source as $k=>$v){
			if($res){
				$res = $res . '&' .  $k . '=' . $v;
			}else{
				$res = $res . $k . '=' . $v;
			}

		}
		return $res;
	}
}