<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\User;
use app\models\MoneyLog;
use app\models\Payhelp;
use app\models\PayhelpRule;
use app\models\Gethelp;
use app\models\BonusType;
use app\models\UserRelation;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends CommonController
{
    
    public $layout = 'main';
    public $title;
    public $class3;
    public function init() {
        parent::init();
        $this->title = '财务';
        $this->class3 ='finance_l';
        //视图中使用 ·· $this->context->title;
    }

    //财务
    public function actionIndex()
    {
        $prule    =   PayhelpRule::findOne(1);
        $tixian    =   Payhelp::find()->where(['user_id'=>Yii::$app->session['user_id']]);
        $user     =   User::findOne(Yii::$app->session['user_id']);
        $moneylog =   MoneyLog::find()->where(['user_id'=>Yii::$app->session['user_id']]);
        //个人钱包
        $get_money  = Gethelp::find()->where(('status !=:a and user_id=:b and type=:c'),[':a'=>3,':b'=>Yii::$app->session['user_id'],'c'=>1])->sum('money');
        $data['money'] = $user->flow_money  - $get_money;
        //推荐奖金
        $get_money  = Gethelp::find()->where(('status !=:a and user_id=:b and type=:c'),[':a'=>3,':b'=>Yii::$app->session['user_id'],'c'=>2])->sum('money');
        $data['rc_money']  = $user->flow_money_rec -$get_money;
        
        //经理奖金
        $get_money  = Gethelp::find()->where(('status !=:a and user_id=:b and type=:c'),[':a'=>3,':b'=>Yii::$app->session['user_id'],'c'=>3])->sum('money');
        $data['manager_money']  = $user->flow_money_manager -$get_money;
        if(isset($moneylog)){
            $data['moneylog'] = new ActiveDataProvider([
                'query' => $moneylog,
                'pagination' => [
                    'pageSize' => 7,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'create_time' => SORT_DESC,
                    ]
                ],
            ]); 
        }

         if(isset($tixian)){
            $data['tixian'] = new ActiveDataProvider([
                'query' => $tixian,
                'pagination' => [
                    'pageSize' => 7,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'create_time' => SORT_DESC,
                    ]
                ],
            ]); 
        }
        //当未提现时,进行系统添加利息
        if(isset($data['tixian']->models)){
            foreach ($data['tixian']->models as  $payhelp) {
            //当未提现时,进行系统添加利息
                if($payhelp->is_tx ==0){
                     $days = floor(intval(time()-$payhelp->create_time)/86400);
                    if($days >= $prule->interest_days){
                       $days  = $prule->interest_days;
                       $payhelp->is_tx =   1;
                       $accrual = $payhelp->money*($prule->rate)/100*$days;
                       $user->flow_money  = $user->flow_money + $payhelp->money + $accrual;
                       $user->save();
                    }
                    //利息
                    $accrual = $payhelp->money*($prule->rate)/100*$days;
                    $payhelp->accrual =   $accrual;
                    $payhelp->save();
                }
            }
             $data['model']  =$data['tixian']->models ;
        }
        $data['prule']  = $prule ;
        $data['user']  = $user ;
        return $this->render('index', $data);
    }


    //提现金钱到个人流动钱包
    public function actionTixian()
    {
        $request = Yii::$app->request;
        if($request->isGet){
          $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();  //开启事务
            try {
                $id=  $request->get('pid');
                $payhelp  = Payhelp::findOne($id);
                //1为已经提现
                $payhelp->is_tx = 1;
                if($payhelp->save()){
                     $user   =  User::findOne(Yii::$app->session['user_id']);
                      //产生钱包记录   
                    $moneylog  = new MoneyLog();
                    $moneylog->user_id   = Yii::$app->session['user_id'];
                    $moneylog->desc      = '提现操作';
                    $moneylog->old_money =  $user->flow_money;
                    $moneylog->new_money  = $user->flow_money +$payhelp->money+$payhelp->accrual;
                    $moneylog->handle    =  '+'.($payhelp->accrual+$payhelp->money);
                    $moneylog->create_time      =  time();
                    if($moneylog->save()){
                        //流动钱包 与待定钱包的 金额增减
                        $user->flow_money     =  $user->flow_money +$payhelp->money+$payhelp->accrual;
                        $user->fixation_money =  $user->fixation_money - $payhelp->money;
                        if($user->save()){
                            $result['status'] = 1;
                            $result['message'] ='提现成功';
                        }
                        
                    }
                }else{
                    $result['status'] =0;
                    $result['message'] ='提现失败';
                }
                 $transaction->commit();
            } catch (Exception $e) {
                $result['status']  = 0;
                $result['message'] = '程序发生错误，请联系网站管理员';
                $transaction->rollBack();
            }
           echo json_encode($result);
        }
    }
        //推荐or经理奖金 接受帮助
       public function actionGethelp()
    {
        $this->title="接受帮助";
        $request = Yii::$app->request;
        $user = User::findOne(Yii::$app->session['user_id']);
        if($request->isGet){
            Yii::$app->session['is_tra'] = 0;
            $id =$request->get('id');
            //推荐奖金页面
            $type =$id ==1?2:3;
            $bonus = BonusType::findOne($id);
            //提现订单还在交易中的金额
            $money  = Gethelp::find()->where('create_time >= :a and create_time<=:b and type=:c and status !=:d and user_id =:e',[':a'=> monthstar(),':b'=>monthend(),':c'=>$type,':d'=>3,':e'=>Yii::$app->session['user_id']])->sum('money');

            return $this->render('gethelp',['user'=>$user,'bonus'=>$bonus,'money'=>$money]);
        //接受帮助 传递金额
        }else if($request->isPost){
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();  //开启事务
            try {
                $post =   $request->post();
                $bonus = BonusType::findOne($post['type']);
                //当$type=2 时 为推荐奖金流动钱包，3为经理流动钱包
                if($bonus->bonus_type_id ==1){
                  $type=2;
                  $user_money = $user->flow_money_rec;
                }else{
                  $type=3;
                  $user_money = $user->flow_money_manager;
                }
                $order    = New Orders();
                $gethelp  = New Gethelp();
                $gethelp->user_id       = Yii::$app->session['user_id'];
                $gethelp->money         = $post['money'];
                $gethelp->create_time   = time();
                $gethelp->pay_type      = $pay_type  =  implode(',', $post['pay_type']);
                $gethelp->type          = $type;
                //当月 接受帮助次数
                $month_money  = Gethelp::find()->where('create_time >= :a and create_time<=:b and type=:c and user_id =:d',[':a'=> monthstar(),':b'=>monthend(),':c'=>$type,':d'=>Yii::$app->session['user_id']])->count();
                //当月交易的金额
                $all_money  = Gethelp::find()->where('create_time >= :a and create_time<=:b and type=:c and user_id =:d',[':a'=> monthstar(),':b'=>monthend(),':c'=>$type,':d'=>Yii::$app->session['user_id']])->sum('money');

                //当月提供帮助的总金额
                $all_paymoney  = Payhelp::find()->where('create_time >= :a and create_time<=:b and user_id =:c',[':a'=> monthstar(),':b'=>monthend(),':c'=>Yii::$app->session['user_id']])->sum('money');

                //获取该用户提交帮助交易成功的最新时间
                $new_time  = Payhelp::find()->where(['user_id'=>Yii::$app->session['user_id'],'status'=>3])->max('create_time');
                //获取该条数据
                $new_payhelp  = Payhelp::find()->where(['user_id'=>Yii::$app->session['user_id'],'status'=>3,'create_time'=>$new_time])->one();
                //判断提现金额是否满足
                if($user_money >= $all_money +$post['money']){
                    if($all_paymoney >= $all_money + $post['money']){
                        if(isset($new_payhelp)){
                        //判断每轮投资额度超过规则金额,则不限制提现次数
                            if($new_payhelp->money >= $bonus->exceed_money ){
                                if($gethelp->save()){
                                    $order->get_id       = $gethelp->get_id;
                                    $order->money        = $gethelp->money;
                                    $order->create_time  = time();
                                    if($order->save()){
                                        $result['status'] = 1;
                                        $result['message'] = '接受帮助成功';
                                    }else{
                                        $result['status'] = 0;
                                        $result['message'] = '接受帮助失败';
                                    }
                                }
                            }else{
                                 //判断提现次数是否有超过规则规定
                                if($bonus->tx_days> $month_money ){
                                     if($gethelp->save()){
                                        $order->get_id       = $gethelp->get_id;
                                        $order->money        = $gethelp->money;
                                        $order->create_time  = time();
                                        if($order->save()){
                                              $result['status'] = 1;
                                              $result['message'] = '接受帮助成功';
                                        }else{
                                            $result['status'] = 0;
                                            $result['message'] = '接受帮助失败';
                                        }
                                    }
                                }else{
                                     $result['status'] = 0;
                                     $result['message'] = '你已经超出每月提现次数'.$bonus->tx_days.'次';
                                }
                           }
                        }else{
                            if($gethelp->save()){
                            $order->get_id       = $gethelp->get_id;
                            $order->money        = $gethelp->money;
                            $order->create_time  = time();
                            if($order->save()){
                                    $result['status'] = 1;
                                    $result['message'] = '接受帮助成功';
                                }else{
                                    $result['status'] = 0;
                                    $result['message'] = '接受帮助失败';
                                }   
                            }
                        }
                    }else{
                      $result['status'] = 0;
                      $result['message'] = '提现失败,当月提现金额超过当月的投资金额';  
                    }
                }else{
                    $result['status'] = 0;
                    $result['message'] = '还可提现的金额不足';
                }
                $transaction->commit();
            } catch (Exception $e) {
                $result['status']  = 0;
                $result['message'] = '程序发生错误，请联系网站管理员';
                $transaction->rollBack();
            }
            echo json_encode($result);
        }
    }
}
