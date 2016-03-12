<?php 
namespace app\common\ip;
/**
 * @desc   获取IP地址对应的位置
 * @author RZLIAO
 * @date   2016-1-25 
 */
class ipLocation{
	const key = 'b342f822bceb25cd66f9f812b6f57ec7';
	const url = 'http://apis.baidu.com/apistore/iplookupservice/iplookup?ip=';

	/**
	 * @param  string $ip  ip地址 
	 * @author RZLIAO
	 * @return string 
	 */
    public static function getIpName( $ip ){
		$ch = curl_init();
   		curl_setopt($ch, CURLOPT_HTTPHEADER  , ['apikey: '. self::key]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch , CURLOPT_URL , self::url.$ip);
		$res = json_decode(curl_exec($ch));
		if($res->errMsg === 'success'){
			return $res->retData->province.' '.$res->retData->city.' '.$res->retData->district;
		}else{
			return '未知地址';
		}
    }
}