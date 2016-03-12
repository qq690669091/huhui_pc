<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\User;
use app\models\Level;
use app\models\Message;
use app\models\UserRelation;
use app\models\PayhelpRule;
use app\models\GethelpRule;
use app\models\JihuoPrompt;
use app\models\Orders;
use app\models\Payhelp;
use app\models\Gethelp;
use app\models\MoneyLog;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
/**
 * @desc   公共控制器，需要权限验证的都继承此控制器
 * @author RZLIAO
 * @date   2016-1-12 
 */
class CommonController extends Controller {

    public  $safeCode ;

    public function init(){
        //用户等级变化
        $get_money  = Gethelp::find()->where(('status !=:a and user_id=:b and type=:c'),[':a'=>3,':b'=>Yii::$app->session['user_id'],'c'=>1])->sum('money');
        $prule    =   PayhelpRule::findOne(1);
        $user   =  User::findOne(Yii::$app->session['user_id']);
        $son_number =  UserRelation::find()->where(['parent_id'=>Yii::$app->session['user_id']])->count();
        $maxtime    =  Payhelp::find()->where(['user_id'=>Yii::$app->session['user_id'],'status'=>3])->max('create_time');
        $payhelp    =  Payhelp::find()->where(['user_id'=>Yii::$app->session['user_id'],'status'=>3,'create_time'=>$maxtime])->one();
        if($payhelp){
            $level_id      =  Level::find()->where('tz_money<= :a  and recommend <=:b',[':a'=>$payhelp->money,':b'=>$son_number])->max('level_id');
            if($level_id){
              $user->level_id = $level_id ;
              $user->save();
            }
        }
        $model    =   Payhelp::find()->where(['user_id'=>Yii::$app->session['user_id']])->all();
        if($model){
            foreach ($model as  $payhelp) {
            //当未提现时,进行系统添加利息
                if($payhelp->is_tx ==0){
                     $days = floor(intval(time()-$payhelp->create_time)/86400);
                     //当该帮助订单的天数大于或等于 规则限定的最大利息天数时,本金和利息自动转回钱包
                     if($days >= $prule->interest_days){
                       $days  = $prule->interest_days;
                       $payhelp->is_tx =   1;
                       $accrual = $payhelp->money*($prule->rate)/100*$days;
                       $user->flow_money  = $user->flow_money + $payhelp->money + $accrual;
                       $user->save();
                       Yii::$app->session['flow_money']  = $user->flow_money - $get_money;
                    }
                    //利息
                    $accrual = $payhelp->money*($prule->rate)/100*$days;
                    $payhelp->accrual =   $accrual;
                    $payhelp->save();
                }
            }
        }
    }
    public function beforeAction($action) {
      if(!isset( Yii::$app->session['user_id'])){
            return $this->redirect(Url::toRoute('site/index'));
      }
      // 判断用户名是否为空
      if(Yii::$app->session['nickname'] ==''){
            return $this->redirect(Url::toRoute('site/complete_info'));
      }else{
           return true;
      }
        
    }

    
    public function renderJson($params = array()) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $params;
    }

    //发送手机验证码，并保存
    public function safetyVerification () {
        //在此处做权限判断
        //$this->safeCode 
    }

    public function actions(){
        return [
         'upload'=>[
                'class' => 'app\common\widgets\file_upload\UploadAction',     
                'config' => [
                    'imagePathFormat' => "/huhui_weixin/web/upload/{yyyy}{mm}{dd}{rand:6}",
                ]
            ],
           
        ];
    }
}
