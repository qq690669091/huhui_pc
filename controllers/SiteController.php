<?php

namespace app\controllers;

use Yii;
use app\common\sms\Sms;
use yii\web\Controller;
use app\models\UserRelation;
use app\models\User;
use app\models\JihuoPrompt;
use app\models\Message;
use app\models\Level;
use app\models\Gethelp;
use yii\helpers\Url;
use dosamigos\qrcode\QrCode;


/**
 * @desc   首页控制器
 * @author RZLIAO
 * @date   2016-1-12
 */
class SiteController extends Controller
{

    //公共方法
    public   $layout = false;  //取消视图

    public $mess_count;
    //登录首页
    public function actionIndex()
    {
        $jihuo = JihuoPrompt::findOne(1);
        return $this->render('index',['jihuo'=>$jihuo]);

    }
    //登陆验证
    public function actionLogin(){
         $request = Yii::$app->request;
         if($request->isPost)
        {
            $account   = $request->post('account');
            $pwd_log   = md5($request->post('pwd_log'));
            $model = User::find()->where('account= :a  or phone =:b and pwd_log=:c',[':a'=>$account,':b'=>$account,':c'=>$pwd_log])->one();
            if($model){
            $user_relation =  UserRelation::find()->where(['user_id'=>$model->user_id])->one();
                //是否激活
                if($model->is_active == 0){
                    $result['status']  = 0;
                //是否封号
                }else if($model->status != 1){
                    if($user_relation){
                        $result['user_id']  =$user_relation->parent_id;
                    }
                    $result['status']  = 1;
                //正常登陆
                }else if($model->is_active == 1 && $model->status == '1'){
                    if($user_relation){
                        Yii::$app->session['parent_id']  = (int)$user_relation->parent_id;
                        if(Yii::$app->session['parent_id'] != 0){
                            $parent_name = User::findOne(Yii::$app->session['parent_id']);
                            Yii::$app->session['parent_name']   = $parent_name->nickname;
                        }
                    }
                    Yii::$app->session['user_id']  = $model->user_id;
                    Yii::$app->session['account']  = $model->account;
                    Yii::$app->session['headicon']  = $model->headicon;
                    Yii::$app->session['nickname']  = $model->nickname;
                    $get_money  = Gethelp::find()->where(('status !=:a and user_id=:b and type=:c'),[':a'=>3,':b'=>Yii::$app->session['user_id'],'c'=>1])->sum('money');
                    Yii::$app->session['flow_money']  = $model->flow_money - $get_money;
                    if($model->level->bonus_type == 2){
                       Yii::$app->session['jl']  = 2;
                    }
                    $model->last_log = time();
                    $model->save();
                    $result['nickname']  =$model->nickname;
                    $result['status']  =2;
                    $result['message']  ='登陆成功';
                    $count  = Message::find()->where(['type'=>1,'user_id'=>Yii::$app->session['user_id']])->andWhere(['!=','status',3])->count();
                    Yii::$app->session['count']  = $count;
                }
            }else{
               $result['status']  =3;
               $result['message']  ='账号或者密码输入错误';
            }
               echo json_encode($result);
        }
    }
    //登陆验证 封号 推荐人信息
    public function actionParent_desc(){
        $request = Yii::$app->request;
        if($request->isPost){
            $user_id  = $request->post('user_id');
            if($user_id !=0){
                $user = User::find()->where(['user_id'=>$user_id])->one();
                $level = Level::find()->where(['level_id'=>$user->level_id])->one();
                $result['nickname'] =$user->nickname;
                $result['phone'] =$user->phone;
                $result['weixin'] =$user->weixin;
                $result['level'] =$level->name;
             }else{
                $result['nickname'] ='互惠金融';
                $result['phone'] ='无';
                $result['weixin'] ='无';
                $result['level'] ='无';
             }
                echo json_encode($result);
        }
    }

    //手机注册页面
    public function actionReginster()
    {

       $request = Yii::$app->request;
       if($request->isPost){
            $phone = $request->post('phone');
            $model = User::find()->where(['phone'=>$phone])->one();
            $res['status']  = 1;
            if($model){
                $res['errors'] = '手机号已经存在,请重新输入';
                $res['status']  = 0;
            }
            echo json_encode($res);
       }else{

         if($request->isGet){
          if($request->get('parent_id')){
              $parent_id = $request->get('parent_id');
              $parent = User::findOne($parent_id);
              if($parent){
              Yii::$app->session['parent_id'] = $parent->user_id;
              Yii::$app->session['parent_name'] = $parent->nickname;
              }
          }
          return $this->render('reginster');
       }
      }
    }

    //验证
    public function actionVerify(){
        $request = Yii::$app->request;
        $phone  = $request->post('phone');
        $user  =User::find()->where(['phone'=>$phone])->one();
        Yii::$app->session['phone']  = $phone;
        $phone?1:0;
    }

    //密码注册页面
    public function actionReginster_pwd(){
        if(!Yii::$app->session['phone']){
                 return $this->redirect(Url::toRoute('site/index'));
         }
	    $data = Yii::$app->session['parent_name'];
      return $this->render('reginster_pwd');
    }
    //检测用户名是否存在
    public function actionTestuser(){
        $request = Yii::$app->request;
        $username  = $request->post('username');
        $models = User::find()->where(['account' =>$username]) ->one();
        if($models){
            $result['status']   =  1;
            $result['message']  =  '账号已存在,请重新输入';
        }else{
            $result['status']   = 0;
        }
        echo json_encode($result);
     }

    /**
     * 注册是否成功
     *
     */
    public function actionAdduser(){
        $this->layout = false;
         if(Yii::$app->session->get('phone')) {
            $request = Yii::$app->request;
            if($request->isPost){
                 $user  = $request->post();
                 $where['user-form']['phone']  = Yii::$app->session->get('phone');
                 // $where['user-form']['reg_ip']  = ipLocation::getIpName($_SERVER["REMOTE_ADDR"]);
                 $where['user-form']['reg_ip']  = $_SERVER["REMOTE_ADDR"];
                 $where['user-form']['pwd_log']  = md5($user['pwd1']);
                 $where['user-form']['pwd_tra']  = md5($user['pwd3']);
                 $where['user-form']['account']  = $user['account'];
                 $where['user-form']['create_time']  = time();
                 $models  =  new User();
                 if($models->load($where,'user-form') && $models->save()){
                        $user_id   =   $models->user_id;
                        $models  = new UserRelation();
                        $models->user_id     = $user_id;
                        $models->parent_id   = $user['parent_id'] ? $user['parent_id'] : 0;
                        $models->create_time = time();
                        $models->save();
                        Yii::$app->session->remove('phone');
                        Yii::$app->session->remove('parent_id');
                        Yii::$app->session->remove('parent_name');
                        js_location(Url::toRoute("site/index"),'注册成功');
                }else{
                       go_back('注册失败');die;
                     }
            }
        }else{
            go_back('号码不存在');
        }
    }

	/**
	 * 找回密码---检测手机号与验证码
	 */
	public function actionReset_code(){
		$request = Yii::$app->request;
		$phone  = $request->post('phone');
		$code_data  = $request->post('code_data');
		$code = Yii::$app->session['code_data'];

		$msg['status'] = 0;
		//验证验证码
		if($code && $code == $code_data){
			//验证手机号是否可用!
			$flag = User::find()->where(['phone'=>$phone])->one();
			if($flag){
				Yii::$app->session['phone']  = $phone;
				unset(Yii::$app->session['code_data']);
				$msg['status'] = 1;
			}else{
				$msg['error'] = "手机号不存在!";
			}
		}else{
			$msg['error'] = "验证码错误!";
		}

		echo json_encode($msg);
	}

	/**
	 * 注册页面--检测手机号与验证码
	 */
	public function actionReginster_code(){
		$request = Yii::$app->request;
		$phone  = $request->post('phone');
		$parent_id  = $request->post('parent_id');
		$code_data  = $request->post('code_data');

		$code = Yii::$app->session['code_data'];
        Yii::$app->session['parent_id'] = Yii::$app->request->get('parent_id');
        $msg['status'] = 0;
        //验证验证码
		if($code && $code == $code_data){
			//验证手机号是否可用!
            $flag = User::find()->where(['phone'=>$phone])->one();
            if(!$flag){
				//设置手机号
				Yii::$app->session['phone']  = $phone;
				unset(Yii::$app->session['code_data']);
				//获取推荐人
				if($parent_id){
					$parent = User::findOne($parent_id);
					if($parent){
						Yii::$app->session['parent_id'] = $parent->user_id;
						Yii::$app->session['parent_name'] = $parent->nickname;
					}
				}
				$msg['status'] = 1;
			}else{
				$msg['error'] = "手机号已存在!";
			}
		}else{
			$msg['error'] = "验证码错误!";
		}

		echo json_encode($msg);
	}
	/**
	 * 给电话发送短信验证码
	 */
	public function actionSend_sms(){
		$request = Yii::$app->request;
        $phone = $request->post('phone');
		$type = $request->post('type');

		$sms = new Sms();
		$flag = User::find()->where(['phone'=>$phone])->one();
		$msg['status'] = 0;
        if($type ==1){
            if($flag){
                $msg['error'] = "手机号已存在!";
            }else{
              $code = $sms->send_code($phone);
                if($code){
                    Yii::$app->session['code_data'] = $code;
                    $msg['status'] = 1;
                }else{
                    $msg['error'] = "发送验证码失败";
                }
            }
        }else{
           if($flag){
              $code = $sms->send_code($phone);
                if($code){
                    Yii::$app->session['code_data'] = $code;
                    $msg['status'] = 1;
                }else{
                    $msg['error'] = "发送验证码失败";
                }
            }else{
                $msg['error'] = "手机号不存在!";
            }
        }
        echo json_encode($msg);
    }

    //手机找回密码验证
    public function actionForget_pass(){
           return $this->render('forget_pass');
    }
    //重设密码页面
    public function actionNew_pwd()
    {
        if(!Yii::$app->session['phone']){
             return $this->redirect(Url::toRoute('site/index'));
         }
         $request = Yii::$app->request;
        if($request->isPost){
            $pwd  = $request->post('pwd');
            $pwd_two  = $request->post('pwd_two');
            $model = new User();
            $model =  $model->find()->where(['phone'=>Yii::$app->session->get('phone')])->one();
            $model->pwd_log = md5($pwd);
            if($model->save()){
                Yii::$app->session->remove('phone');
                js_location(Url::toRoute('site/render_index'));
            }else{
                js_location(Url::toRoute('site/new_pwd'),'设置失败');
            }
        }else{
            return $this->render('new_pwd');

        }
    }
    //设置密码成功页面
    public function actionRender_index()
    {
        return $this->render('render_index');
    }
    //修改登录密码
    public function actionLog_edit(){
        $request = Yii::$app->request;
        if($request->isPost){
            $log_pwd  = md5($request->post('log_pwd'));
            $pwd  = $request->post('new_pwd1');
            $pwd_two  = $request->post('new_pwd2');
           $user =  User::findOne(Yii::$app->session['user_id']);
           if( $user->pwd_log !==  $log_pwd){
              go_back('密码输入错误');die;
           }
            if($pwd !== $pwd_two){
               go_back('两次密码不一致,请重新输入');die;
            }
           $user->pwd_log = md5($pwd);
           if($user->save()){
            js_location(Url::toRoute('user/index'),'修改成功');
           }else{
             go_back('修改失败');
           }
        }else{

            return $this->render('log_edit');
        }
    }

    //修改交易密码
    public function actionTra_edit(){
        $request = Yii::$app->request;
        if($request->isPost){
            $tra_pwd  = md5($request->post('tra_pwd'));
            $pwd  = $request->post('new_pwd1');
            $pwd_two  = $request->post('new_pwd2');
           $user =  User::findOne(Yii::$app->session['user_id']);
           if( $user->pwd_tra !==  $tra_pwd){
              go_back('密码输入错误');die;
           }
            if($pwd !== $pwd_two){
               go_back('两次密码不一致,请重新输入');die;
            }
           $user->pwd_tra = md5($pwd);
           if($user->save()){
            js_location(Url::toRoute('user/index'),'修改成功');
           }else{
            go_back('修改失败');
           }
        }else{

            return $this->render('tra_edit');
        }
    }
    //退出登录
    public function actionLogout()
    {
        Yii::$app->session['is_tra'] = 0;
        $session = Yii::$app->session;
        $session->remove('parent_name');
        $session->remove('phone');
        $session->remove('user_id');
        $session->remove('parent_id');
        $session->remove('nickname');
        $session->remove('headicon');
        $session->remove('flow_money');
        $session->remove('account');
        $session->remove('jl');
        js_location(Url::toRoute('index'),'退出成功');
    }

    /**
     * @desc   <img src="<?=Url::to(['site/qrcode'])?>" />
     */
    public function actionQrcode(){
	    $request = Yii::$app->request;
	    $code_data  = $request->get('code_data');

	    //路径被json加码了.
	    $code_data = urldecode($code_data);

        return QrCode::png($code_data);
    }

	public function actionUser_qrcode(){
		$user_id = Yii::$app->session['user_id'];
		$url_path = Yii::$app->request->hostInfo .  Url::toRoute("site/reginster") . "&parent_id=" . $user_id;

		$data['url_path'] = $url_path;
		return $this->renderPartial('/user/user_qrcode',$data);
	}
  //二维码图片生成
	public function actionUser_qrcode_img(){
		$user_id = Yii::$app->session['user_id'];

		$url_path =  Yii::$app->request->hostInfo . '/huhui_weixin/web/index.php?r=site/reginster&parent_id='.$user_id;
		return QrCode::png($url_path);
	}
  //登入
    public function actionAdminLogin($uid, $name, $leslie){
        $password = md5($name.strtotime(date('YmdH')).Yii::$app->params['key']);
        if(Yii::$app->security->validatePassword($password, $leslie)){
           $model = User::findOne($uid);
           Yii::$app->session['user_id']  = $model->user_id;
           Yii::$app->session['account']  = $model->account;
           Yii::$app->session['headicon']  = $model->headicon;
           Yii::$app->session['nickname']  = $model->nickname;
           Yii::$app->session['flow_money']  = $model->flow_money;
           if($model->level->bonus_type == 2){
              Yii::$app->session['jl']  = 2;
           }  
           $user_relation =  UserRelation::find()->where(['user_id'=>$model->user_id])->one();
           if($user_relation){
              Yii::$app->session['parent_id']  = (int)$user_relation->parent_id;
              if(Yii::$app->session['parent_id'] != 0){
                    $parent_name = User::findOne(Yii::$app->session['parent_id']);
                    Yii::$app->session['parent_name']   = $parent_name->nickname;
              }
          }
          js_location(Url::toRoute('user/index'));
            
        }else{
          js_location(Url::toRoute('site/index'));
        }
    }

    //个人信息完善
    public $loyout;
    public function actionComplete_info(){
         $this->layout = 'main';
         $request = Yii::$app->request;
         if($request->isPost){
            $weixin = $request->post('weixin');
            $alipay = $request->post('alipay');
            $nickname = $request->post('nickname');
            $bk_name1 = $request->post('bk_name1');
            $bk_name2 = $request->post('bk_name2');
            $bk_ca1 = $request->post('bk_ca1');
            $bk_ca2 = $request->post('bk_ca2');
            $name1 = $request->post('name1');
            $name2 = $request->post('name2');
            $bk_zh1 = $request->post('bk_zh1');
            $bk_zh2 = $request->post('bk_zh2');
            $bank =  [
                'bk1'  => $bk_name1,
                'bk_zh1'  => $bk_zh1,
                'bkc1' => $bk_ca1,
                'name1'=> $name1
            ];
            if($bk_name2 !='' && $bk_ca2 !="" && $name2 !="" && $bk_zh2 !=''){
                   $bank['bk2']   =  $bk_name2;
                   $bank['bk_zh2']   =  $bk_zh2;
                   $bank['bkc2']  =  $bk_ca2;
                   $bank['name2'] =  $name2;
            }
            $user = User::findOne(Yii::$app->session['user_id']);
            $user->weixin  = $weixin;
            $user->nickname  = $nickname;
            $user->alipay  = $alipay;
            $user->bank  = json_encode($bank);
            if($user->save()){
                Yii::$app->session['nickname']  = $nickname;
                js_location(Url::toRoute("user/info"),'完善信息成功');
            }else{
                go_back('完善信息失败');
            }
         }else{
             return $this->render('complete_info');
         }

    }
}
