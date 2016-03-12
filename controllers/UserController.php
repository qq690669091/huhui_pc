<?php
namespace app\controllers;
use Yii;
use app\models\User;
use app\models\Level;
use app\models\Message;
use app\models\UserRelation;
use app\models\PayhelpRule;
use app\models\GethelpRule;
use app\models\JihuoPrompt;
use app\models\News;
use app\models\Orders;
use app\models\Payhelp;
use app\models\Gethelp;
use app\models\MoneyLog;
use app\models\Manager;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Url;
use app\common\ip\ipLocation;
use yii\data\ActiveDataProvider;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends CommonController
{
    public $loyout = 'main';
    public $title;
    public function init() {
        parent::init();
        $this->title = '首页';
        //视图中使用 ·· $this->context->title;
    }


    // 个人信息
     public function actionInfo(){

        $request = Yii::$app->request;
        $model   =  User::findOne(Yii::$app->session['user_id']);
        if( $request->getIsAjax() ){
            //E:\wamp\www\huhui_pc
            $img = $request->post('img');
            $old = $model->headicon;
            $name = uploadImg($img, Yii::$app->params['imgUrl']);
            $model->headicon = '/huhui_pc/web/upload/'.$name;
            Yii::$app->session['headicon'] = '/huhui_pc/web/upload/'.$name;
            $model->save();
            if($old){
                @unlink(Yii::getAlias('@app').'\..'.$old);
            }
            die;
        }
        $name = $model->level->name;
        $parent  = User::findOne(Yii::$app->session['parent_id']);
        if($parent) $where['parent']  = $parent;
        $model   =  $model->toArray();
        $model['bank']   = json_decode(($model['bank']),true);
        $model['level']   =  $name;
        $where['model']  = $model;
        $url_path = Yii::$app->request->hostInfo . Url::toRoute("site/reginster") . "&parent_id=" . Yii::$app->session['user_id'];
        $where['url_path'] = $url_path;
        return $this->render('info',$where);
    }


    //管理模块
    public function actionManage(){
        $session = Yii::$app->session;
        $user_id = $session->get('user_id');

        $data['user_help_list'] = ( Manager::get_child_user_order($user_id));

        return $this->render('manage',$data);
    }
    //管理模块ajax请求（筛选与搜索）
    public function actionManager_ajax(){
        $session = Yii::$app->session;
        $user_id = $session->get('user_id');


        $request = Yii::$app->request;
        $help_type = $request->get('help_type');
        $search = $request->get('search');

        $option = [];
        if($help_type){
            $option["help_type"] = $help_type;
        }
        if($search){
            $option["search"] = $search;
        }

        $data['user_help_list'] = ( Manager::get_child_user_order($user_id,$option));

        return  $this->renderPartial('manage_ajax',$data);
    }


    public function actionManager_order_detail(){
        $session = Yii::$app->session;
        $user_id = $session->get('user_id');

        $request = Yii::$app->request;
        $help_id = $request->get('help_id');
        $option["help_id"] = $help_id;


        $list = ( Manager::get_child_user_order($user_id,$option));
        if($list){
            $data["order_data"] = array_shift($list);
        }

        return  $this->renderPartial('manager_order_detail',$data);
    }
    /**
     * 团队板块
     * @return [type] [description]
     */
    public function actionTeam( $page = 1 ){
        $user_id  =Yii::$app->session['user_id'];
        //获取下线用户列表
        // $data['user_list'] = (new UserRelation())->getChilds($user_id);
        $query = UserRelation::find()->where(['parent_id'=>$user_id]);

        if(Yii::$app->request->get('level') ){
            $query->leftjoin('hl_user','hl_user.user_id = hl_user_relation.user_id')->andFilterWhere(['hl_user.level_id' => Yii::$app->request->get('level')]);
        }else if (Yii::$app->request->get('search')) {
            $search  = Yii::$app->request->get('search');
            $search_num  =(int)$search;
            $query->leftjoin('hl_user','hl_user.user_id = hl_user_relation.user_id')->andWhere("hl_user.user_id = $search_num OR hl_user.account LIKE '%$search%' OR hl_user.nickname LIKE '%$search%'");
        }
        if(isset($query)){
            $data['user_list'] = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 8,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'user_id' => SORT_ASC,
                    ]
                ],
            ]);
        //获取用户等级列表
        $data['level_list'] = [];
        $levels = (new Level())->getLevels();
        $data['level_list'] = $levels;
        //获取团队数
        $data['user_list_count']= $query->count();
        }
        if(Yii::$app->request->isAjax){
            // dump(Yii::$app->request->get('level'));
                return $this->renderPartial('team_ajax',$data);
         }else{
             return $this->render('team',$data);
        }
    }


    public function actionHelp_ajax(){
        $this->loyout = false;
        $session = Yii::$app->session;
        $user_id = $session->get('user_id');

        $request = Yii::$app->request;
        $help_type = $request->get('help_type');
        $search = $request->get('search');

        $get_helps = [];
        $pay_helps = [];
        if(!$help_type || $help_type == 1){
            //基础查询
            $get_helps = (new \Yii\db\Query())
                ->select('*')
                ->from('child_gethelps')
                ->where(['parent_id'=>$user_id]);

            if($search){
                $search_num = (int) $search;
                $get_helps->andWhere("help_id = $search_num OR nickname LIKE '%$search%'");

            }
            $url = $get_helps->createCommand();
            $url = $url->getRawSql();

            $get_helps = $get_helps->all();
            if($get_helps) foreach($get_helps as $k=>$v){
                $get_helps[$k]['help_type'] = '接受帮助';
            }
        }

        if(!$help_type || $help_type == 2){
            //基础查询
            $pay_helps = (new \Yii\db\Query())
                ->select('*')
                ->from('child_payhelps')
                ->where(['parent_id'=>$user_id]);
            //搜索
            if($search){
                $search_num = (int) $search;
                $pay_helps->andWhere("help_id = $search_num OR nickname LIKE '%$search%'");
            }

            $pay_helps = $pay_helps->all();

            if($pay_helps) foreach($pay_helps as $k=>$v){
                $pay_helps[$k]['help_type'] = '提供帮助';
            }
        }

        $data['user_help_list'] = array_merge($get_helps,$pay_helps);


        return  $this->renderPartial('help_ajax',$data);
    }

    //管理模块->团队树
     public function actionTree(){
         $session = Yii::$app->session;
         $user_id = $session->get('user_id');
         if($user_id){
            $tree = (new UserRelation())->getTreeData($user_id);
        }else{
            $tree = "";
        }

         $data['tree'] = json_encode($tree);

         return $this->render('teamTree',$data);
    }


    //我的->联系我们
    public function actionContact(){
        $request = Yii::$app->request;
        if($request->isPost){
            $post = $request->post();
            $message =New Message();
            // if($post['select']=='其他'){
            //     $message->error_type  =$post['other'];
            // }else{
            //     $message->error_type  =$post['select'];
            // }
            if($post['img']){
                $name = uploadImg($post['img'], Yii::$app->params['imgUrl']);
                $message->img = '/huhui_pc/web/upload/'.$name;
            }
            $message->content  =$post['content'];
            $message->title    =$post['title'];
            $message->create_time    =time();
            $message->user_id  =Yii::$app->session['user_id'];
            if(isset($data)) $message->img = $data['url'];
            if($message->save()){
                go_back('留言成功');
            }else{
                alert('留言失败');
            }
         }else{
            return $this->render('contact');
         }
    }

      //首页
    public function actionIndex(){
        $payhelp          =  Payhelp::find()->select(['pay_id'])->where(['user_id'=>Yii::$app->session['user_id']])->asArray()->all();
        $gethelp          =  Gethelp::find()->select(['get_id'])->where(['user_id'=>Yii::$app->session['user_id']])->asArray()-> all();
        //待接受帮助帮助 匹配中的人数
        // $data['getcount'] = Gethelp::find()->where(['status'=>2])->count();
        //待提供帮助 匹配中的人数
        // $data['paycount'] = Payhelp::find()->where(['status'=>2])->count();

        $max_time  = News::find()->where(('news_id !=:a'),[':a'=>1])->max('create_time');
        $data['news']  = News::find()->where(['create_time'=>$max_time])->one();
        if($payhelp){
            foreach ($payhelp as $aa) {
                $bb []  = $aa['pay_id'];
            }
        }
        if($gethelp){
            foreach ($gethelp as $aa) {
                $cc []  = $aa['get_id'];
            }
        }
        if(isset($bb) && !isset($cc)){
           $query= Orders::find()->where(['in', 'pay_id', $bb]);
        }else if(!isset($bb) && isset($cc)){
           $query= Orders::find()->where(['in', 'get_id', $cc]);
        }else if(isset($bb) && isset($cc)){
           $query = Orders::find()->where(['pay_id'=>$bb])->orWhere(['get_id'=>$cc]);
        }
        if(isset($query)){
            $data['provider'] = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 12,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'create_time' => SORT_DESC,
                    ]
                ],
            ]);
        }
        //提供帮助规则
        $data['payhelp_rule'] = PayhelpRule::findOne(1);
        $data['user']     =  User::findOne(Yii::$app->session['user_id']);
        $showtime = JihuoPrompt::findOne(1);
        $data['showtime']  =$showtime;
        return $this->render('index', $data);
    }
    //提供帮助
    public function actionPayhelp(){
        $this->title='提供帮助';
        $request  = Yii::$app->request;
        $prule  =PayhelpRule::findOne(1);
        if($request->isPost){
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();  //开启事务
            try {
                $money  =  $request->post('money');
                $pay_type  =  $request->post('pay_type');
                $pay_type  =  implode(',', $pay_type);
                //当月 提供帮助金额
                $month_money  = Payhelp::find()->where('create_time >= :a and create_time<=:b and user_id=:c',[':a'=> monthstar(),':b'=>monthend(),':c'=>Yii::$app->session['   user_id']])->sum('money');
                //得到匹配的最新时间
                $new_time  = Payhelp::find()->where(['user_id'=>Yii::$app->session['user_id']])->max('create_time');
                //判断第二次帮助的时间 是否大于规则规定的天数
                if(intval(time()-$new_time)/86400  >= $prule->after_pay_days){
                    //判断当月交易金额是否超过 规则月提供总额的上限
                    if( ($month_money + $money) <= $prule->help_money_month){
                        $payhelp  =  New Payhelp();
                        $payhelp->user_id = Yii::$app->session['user_id'];
                        $payhelp->money =  $money;
                        $payhelp->create_time =  time();
                        $payhelp->pay_type =  $pay_type;
                        //添判断是否添加到总提供帮助订单
                        if($payhelp->save()){
                            //给上线的 经理或者推荐 待定钱包价钱
                            (new UserRelation())->getPendingChildrenMoney(Yii::$app->session['user_id']);
                            $orders  = New Orders();
                            $orders->pay_id  =  $payhelp->pay_id;
                            $orders->money  =   $money;
                            $orders->create_time  =  $payhelp->create_time;
                            $orders->save();
                            $user = User::findOne(Yii::$app->session['user_id']);
                            $user->fixation_money  =$money+$user->fixation_money;
                            $user->save();
                            $result['status'] = 1;
                            $result['message'] = '提供帮助成功';
                        }else{
                            $result['status'] = 0;
                            $result['message'] =  '提供帮助失败';
                        }
                    }else{
                         $result['status'] = 0;
                         $result['message'] = '已经超过每月提供帮助总额度'.$prule->help_money_month.'元';
                    }
                }else{
                    $result['status'] = 0;
                    $result['message'] = '每次提供帮助'.$prule->after_pay_days.'天后，才可进行第二次提供帮助';
                }
                $transaction->commit();
            } catch (Exception $e) {
                $result['status']  = 0;
                $result['message'] = '程序发生错误，请联系网站管理员';
                $transaction->rollBack();
            }
            echo json_encode($result);
         }else{
            $prev  = (new UserRelation())->getFinishMoney(Yii::$app->session['user_id']);
            return $this->render('payhelp',['prule'=>$prule,'prev'=>$prev]);
         }
    }
    //接受帮助
    public function actionGethelp(){
        $this->title='接受帮助';
        Yii::$app->session['is_tra'] = 0;
        $grule  =GethelpRule::findOne(1);
        $request  = Yii::$app->request;
        $user = User::findOne(Yii::$app->session['user_id']);
        //接受帮助未完成交易的总金额  type为1 既为 个人钱包订单
        $get_money  = Gethelp::find()->where(('status !=:a and user_id=:b and type=:c'),[':a'=>3,':b'=>Yii::$app->session['user_id'],'c'=>1])->sum('money');
        if($request->isPost){
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();  //开启事务
            try {
                //当月 接受帮助总金额  type为1 既为 个人钱包订单
                $month_money  = Gethelp::find()->where('create_time >= :a and create_time<=:b and type=:c and user_id=:d',[':a'=> monthstar(),':b'=>monthend(),':c'=>1,':d'=>Yii::$app->session['user_id']])->sum('money');
                //前台提交金额
                $money  =  $request->post('money');
                //判断交易中的金额 加上提交的金额是否大于个人流动钱包的金额
                if($user->flow_money>= $money+ $get_money ){
                   $pay_type =  $request->post('pay_type');
                   $pay_type =  implode(',',$pay_type);
                    //得到匹配的最新时间
                    $new_time  = Gethelp::find()->where(['user_id'=>Yii::$app->session['user_id']])->max('create_time');
                    //判断第二次帮助的时间 是否大于规则规定的天数
                    if(intval(time()-$new_time)/86400  >= intval($grule->after_recive_days)){
                        //判断当月交易金额是否超过 规则月提供总额的上限
                        if( ($month_money + $money) <= $grule->help_money_month){
                            //总得订单
                            $gethelp  =  New Gethelp();
                            $gethelp->user_id = Yii::$app->session['user_id'];
                            $gethelp->money =  $money;
                            $gethelp->create_time =  time();
                            $gethelp->pay_type =  $pay_type;
                            //判断是否添加到总得帮助订单
                            if($gethelp->save()){
                                $orders  = New Orders();
                                $orders->get_id  =  $gethelp->get_id;
                                $orders->money   =   $money;
                                $orders->create_time  =  $gethelp->create_time;
                                //判断是否添加数据到交易子订单
                                if($orders->save()){
                                    $result['status'] = 1;
                                    $result['message'] = '接受帮助成功';
                                }
                            }else{
                                $result['status'] = 0;
                                $result['message'] =  '接受帮助失败';
                            }
                        }else{
                             $result['status'] = 0;
                             $result['message'] = '已经超过每月接受帮助总额度'.$grule->help_money_month.'元';
                        }
                    }else{
                        $result['status'] = 0;
                        $result['message'] = '每次接受帮助'.$grule->after_recive_days.'天后，才可进行第二次接受帮助';
                    }
                }else{
                    $result['status'] = 0;
                    $result['message'] = '申请帮助金额大于个人钱包,余额不足,请重新输入';
                }
                $transaction->commit();
            } catch (Exception $e) {
                $result['status']  = 0;
                $result['message'] = '程序发生错误，请联系网站管理员';
                $transaction->rollBack();
            }
                echo json_encode($result);

        }else{
            $money = $user->flow_money  - $get_money;
            Yii::$app->session['flow_money'] = $money;
            return $this->render('gethelp',['grule'=>$grule,'user'=>$user,'money'=>$money]);
        }
    }

    //确认付款
    public function actionPaymoney(){
        $this->title='确认付款';
        $request = Yii::$app->request;
        //付款页面
        if($request->isGet){
			if(Yii::$app->session['is_tra']  != 1){
                return $this->redirect(Url::toRoute('user/index'));
            }
            Yii::$app->session['is_tra'] = 0;
            $id  = $request->get('id');
            $model = Orders::findOne($id);
            $data['model']  = $model;
            $data['pay_bank']  = json_decode($model->payhelp->user->bank,true);
            $data['get_bank']  = json_decode($model->gethelp->user->bank,true);
            return $this->render('pay_money',$data);
        //是否付款
        }else if($request->isPost){
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();  //开启事务
            try {
                $id  = $request->post('id');
                $content  = $request->post('content');
                $model = Orders::findOne($id);
                $model->status = 3;
                $model->create_time = time();
                //判断用户是否完成付款，若完成则时间更新为最新时间,状态为等待对方确认
                if($model->save()){
                    $message = new Message();
                    if($request->post('img')){
                         $name = uploadImg($request->post('img'), Yii::$app->params['imgUrl']);
                         $message->img = '/huhui_pc/web/upload/'.$name;
                    }
                    //留言者
                    $message ->target_id   =  $model->payhelp->user_id;
                    //为XX用户留言
                    $message ->user_id  =  $model->gethelp->user_id;
                    $message ->content    =  $content;
                    $message ->create_time    = time();
                    $message ->type       = 1;
                    //产生 确认付款留言
                    if($message->save()){
                        $transaction->commit();
                        js_location(Url::toRoute("user/index"),'操作成功');
                    }else{
                        $transaction->commit();
                        js_location(Url::toRoute(["user/paymoney","id"=>$id]),'操作失败');
                    }
                }else{
                    $transaction->commit();
                    js_location(Url::toRoute(["user/paymoney","id"=>$id]),'操作失败');
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                js_location(Url::toRoute(["user/paymoney","id"=>$id]),'程序发生错误，请联系网站管理员');
            }
        }
    }

    //确认收款
    public function actionGetmoney(){
        $this->title='确认收款';
        $request = Yii::$app->request;
        if($request->isGet){
			if(Yii::$app->session['is_tra']  != 1){
           		 return $this->redirect(Url::toRoute('user/index'));
        	}
            Yii::$app->session['is_tra'] = 0;
            $id  = $request->get('id');
            $model = Orders::findOne($id);
            $data['model']  = $model;
            $data['pay_bank']  = json_decode($model->payhelp->user->bank,true);
            $data['get_bank']  = json_decode($model->gethelp->user->bank,true);
            return $this->render('get_money',$data);
        //确认付款操作
        }else if($request->isPost){
            $id  = $request->post('id');
            $content  = $request->post('content');
            $select  = $request->post('select');
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();  //开启事务
            try {
                $model = Orders::findOne($id);
                //判断用户收款选项状态 ，1为确认收款按钮 ，2为未收到款按钮
                if($select ==1){
                    $model->create_time = time();
                    $model->status = 7;
                    if(!$model->save()) return false;
                    //给上级的 推荐奖金流动钱包 或者 经理奖金流动钱包 加钱
                    $goders =  Orders::find()->where(['get_id'=>$model->get_id])->all();
                    $poders =  Orders::find()->where(['pay_id'=>$model->pay_id])->all();
                    // //查找受益者是否还有其他子订单 未完成交易
                    $a =1 ;
                    foreach ($goders as   $get) {
                        //判断子订单是否已经完成交易
                        if($get->status != 7) $a=0;
                    }
                    //当 $a =1时  表示 所有接受帮助的子订单的交易都已经完成
                        if($a == 1){
                            $gethelp  =Gethelp::findOne($model->get_id);
                            $gethelp->status =3;
                            $gethelp->match_time = time();
                            //当总接受帮助订单完成,修改该用户的个人流动钱包
                            if($gethelp->save()){
                                $user = User::findOne(Yii::$app->session['user_id']);
                                //产生钱包记录
                                $moneylog  = new MoneyLog();
                                $moneylog->user_id   = Yii::$app->session['user_id'];
                                $moneylog->handle    =  '-'.$gethelp->money;
                                $moneylog->create_time      =  time();
                                if($gethelp->type ==1){    //个人流动钱包
                                     $moneylog->old_money =  $user->flow_money;
                                     $moneylog->desc      = '接受帮助操作';
                                     $moneylog->new_money =  $user->flow_money  - $gethelp->money;
                                     $user->flow_money    =  $user->flow_money  - $gethelp->money ;
                                }else if($gethelp->type ==2){ //推荐奖金流动钱包
                                     $moneylog->old_money =  $user->flow_money_rec;
                                     $moneylog->desc      = '推荐奖金提现';
                                     $moneylog->new_money =  $user->flow_money_rec  - $gethelp->money;
                                     $user->flow_money_rec    =  $user->flow_money_rec  - $gethelp->money ;
                                }else if($gethelp->type ==3){ //经理奖金流动钱包
                                     $moneylog->desc      = '经理奖金提现';
                                     $moneylog->old_money =  $user->flow_money_manager;
                                     $moneylog->new_money =  $user->flow_money_manager  - $gethelp->money;
                                     $user->flow_money_manager    =  $user->flow_money_manager  - $gethelp->money ;
                                }
                                    if($moneylog->save() && $user->save()){
                                        $result['status']   = 1;
                                    }
                            }else{
                                $result['status']   = 0;
                                $result['message']  = '留言失败';
                            }
                        }
                    //查找提供帮助订单 是否还有其他子订单 未完成交易
                    $b = 1;
                    foreach ($poders as  $pay) {
                        //判断子订单是否已经完成交易
                        if($pay->status !=7) $a =0;
                    }
                     //当 $a =1时  表示 所有提供帮助的子订单的交易都已经完成
                    if($b ==1){
                            $payhelp  =Payhelp::findOne($model->pay_id);
                            $payhelp ->status = 3;
                            $payhelp ->match_time = time();
                            //当总接受帮助订单完成,修改该用户的个人流动钱包
                            if($payhelp->save()) $result['status']  = 1;
                             //给上级的 推荐奖金流动钱包 或者 经理奖金流动钱包 加钱
                            $aa = (new UserRelation())->getChildrenMoney($payhelp->user_id);
                    }
                }else if($select ==2){
                    //未收到款
                    $model->status = 4;
                    if(!$model->save()) return false;
                    $result['status'] = 2;

                }
                $message = new Message();
                $message ->target_id    =  $model->gethelp->user_id;
                $message ->user_id      =  $model->payhelp->user_id;
                $message ->content      =  $content;
                $message ->create_time  = time();
                $message ->type         = 1;
                if($message->save()){
                if($model->status ==4 || $model->status ==7){
                        $result['message']  = '操作成功';
                    }
                }else{
                    $result['status']   = 0 ;
                    $result['message']  =  '操作失败';
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


    //交易详情
    public function actionFinish_order(){
        $this->title  ='交易详情';
        $request = Yii::$app->request;
        if($request->isGet){
            $id  = $request->get('id');
            $model = Orders::findOne($id);
            $data['model']  = $model;
            $data['pay_bank']  = json_decode($model->payhelp->user->bank,true);
            $data['get_bank']  = json_decode($model->gethelp->user->bank,true);
            return $this->render('finish_order',$data);
        }
    }

    //头像图片上传
    public function actionTouxiang(){
        $request  =  Yii::$app->request;
        if($request->isPost){
            if(!$request->post()){
                $result['message'] ='图片上传大小不能超过1M';
                $result['status']  =0;
            }else{
                $suffix =  strtolower($request->post('suffix'));
                $img = base64_decode($request->post('img'));
                if($suffix =='jpeg' || $suffix =='png' || $suffix =='gif'  || $suffix =='jpg' ){
                    $path = '/huhui_weixin/web/upload/'.date('Y-m-d-',time()).mt_rand(10,99999).'.'.$suffix;
                    $aa= file_put_contents('../..'.$path,$img);
                    $user = User::findOne(Yii::$app->session['user_id']);
                    if(!empty($user->headicon)){
                        $aa = $user->headicon;
                        unlink('../..'.$aa);
                    }
                    $user->headicon = $path;
                    if($user->save()){
                        Yii::$app->session['headicon']  = $user->headicon;
                        $result['status']  =1;
                        $result['message']  =  '上传成功';
                    }
                }else{
                    $result['status']  =0;
                    $result['message']  =  '图片格式不正确';
                }
            }
              echo json_encode($result);
        }
    }

            //交易密码验证
    public function actionValidation(){
         $request  =  Yii::$app->request;
         if($request->isGet){
           $pwd  =  md5($request->get('pwd'));
           $user = User::findOne(Yii::$app->session['user_id']);
           if($pwd == $user->pwd_tra){
                $result['status']  = 1;
                $result['message'] = '验证成功';
                Yii::$app->session['is_tra']  = 1;
           }else{
                Yii::$app->session['is_tra']  = 0;
                $result['status']  = 0;
                $result['message'] = '交易密码有误,请重新输入';
           }
           echo json_encode($result);
        }
    }
}
