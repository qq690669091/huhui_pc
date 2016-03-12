<?php

namespace app\controllers;

use Yii;
use app\models\Message;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends CommonController
{
    public $loyout = 'main';
    public $title;
    public function init() {
        parent::init();
        $this->title = '通知';
        //视图中使用 ·· $this->context->title;
    }
    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
       $model  = Message::find()->where(['user_id'=>Yii::$app->session['user_id'],'type'=>1])->OrderBy(['create_time'=>SORT_DESC,'type'=>SORT_ASC])->all();
        return $this->render('index',['model'=>$model]);
    }

      public function actionMessage()
    {
        $request = Yii::$app->request;
        //用户留言
        if($request->isPost){
            if(empty($request->post())) go_back('图片上传大小不能超过1M');
            $model = new Message();
             $user_id  =  $request->post('target_id');
             foreach($_FILES as $key=>$val){
             if($_FILES[$key]['name']){

                $res = uploads($key);
                $data[$key] = $res;
                }
            }
            if(isset($data)) $model->img = $data['url'];
            if($user_id  == 0){
                //为管理员留言
                $model->target_id = 0;
                $model->user_id =  yii::$app->session['user_id'];
            }else{
                //为用户留言
                $model->type = 1;
                $model->user_id   = $user_id;
                $model->target_id = yii::$app->session['user_id'];
            }
            $content  =  $request->post('content');
            $model->content = $content;
            $model->create_time = time();
            if($model->save()){
                 js_location(Url::toRoute('message/index'),'留言成功');
            }else{
                js_alert('留言失败');return;
            }
        }else{
           //留言详情
            if($request->isGet){
                $mess_id  = $request->get('mess_id');
                $model =  Message::findOne(['mess_id'=>$mess_id]);
                $model->error_type = '2';
                $model->save();
                $count  = Message::find()->where(['type'=>1,'user_id'=>yii::$app->session['user_id']])->andWhere(['!=','error_type','2'])->count();
                Yii::$app->session['count']  = $count;
                return $this->render('message',['model'=>$model]);
            }
        }
    }
}
