<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/2/20
 * Time: 13:55
 */


namespace app\models;

use Yii;
use yii\base\Model;

class Manager extends Model{

	public static function get_child_user_order($user_id = 0,$option = []){
		/**
		 * 1:get_help  ;  2:pay_help
		 */
		//获取下线用户订单信息
		$get_helps_query = (new \Yii\db\Query())
			->select('*')
			->from('child_gethelps')
			->andWhere(['parent_id'=>$user_id]);

		$pay_helps_query = (new \Yii\db\Query())
			->select('*')
			->from('child_payhelps')
			->andWhere(['parent_id'=>$user_id]);
		/**
		 * 条件筛选
		 */
		if($option){
			//搜索
			if(isset($option["search"])){
				$search = $option["search"];
				$search_num = (int) $search;
				$get_helps_query->andWhere("help_id = $search_num OR nickname LIKE '%$search%'");
				$pay_helps_query->andWhere("help_id = $search_num OR nickname LIKE '%$search%'");
			}

			//取一个详情
			if(isset($option["help_id"])){
				$help_id = $option["help_id"];
				$help_id = (int) $help_id;
				$get_helps_query->andWhere(["help_id"=>$help_id]);
				$pay_helps_query->andWhere(["help_id"=>$help_id]);
			}
		}
		/**
		 * 筛选提供/接受帮助订单
		 */
		if(isset($option["help_type"])){
			if($option["help_type"] == 1 ){
				$get_helps = $get_helps_query->all();
				$pay_helps = [];
			}else if($option["help_type"] == 2){
				$get_helps = [];
				$pay_helps = $pay_helps_query->all();
			}else{
				$get_helps = $get_helps_query->all();
				$pay_helps = $pay_helps_query->all();
			}
		}else{
			$get_helps = $get_helps_query->all();
			$pay_helps = $pay_helps_query->all();
		}



		if($get_helps) foreach($get_helps as $k=>$v){
			$get_helps[$k]['help_type'] = '接受帮助';
		}
		if($pay_helps) foreach($pay_helps as $k=>$v){
			$pay_helps[$k]['help_type'] = '提供帮助';
		}

		$user_help_list = array_merge($get_helps,$pay_helps);
		if($user_help_list) foreach($user_help_list as $k=>$v){
			$user_help_list[$k]["order_status"] = Manager::get_status($v["order_status"]);
		}


		return $user_help_list;
	}

	public static function get_status($order_status){
		//(1.匹配中,2待打款/待收款,3已打款/等待收款确认,
		//4.虚假打款/(未收到款)异常,5.为48小时未打款 （异常）,6.为36小时未确认收款 （异常），7.交易成功
		switch($order_status){
			case 1:
				$order_status = "匹配中";
				break;
			case 2:
				$order_status = "待打款/待收款";
				break;
			case 3:
				$order_status = "已打款/等待收款确认";
				break;
			case 4:
				$order_status = "虚假打款/(未收到款)异常";
				break;
			case 5:
				$order_status = "为48小时未打款 （异常）";
				break;
			case 6:
				$order_status = "为36小时未确认收款 （异常）";
				break;
			case 7:
				$order_status = "交易成功";
				break;
			default:
				$order_status = "异常";
		}
		return $order_status;
	}
}