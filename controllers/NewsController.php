<?php

namespace app\controllers;

use Yii;
use app\models\News;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends CommonController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public $title;
    public $class4;
    public $layout = 'main';
    public function init() {
        parent::init();
        $this->title = '资讯';
        $this->class4 = 'information_l';
        //视图中使用 ·· $this->context->title;
    }
     public function actionIndex( $pages = 1 )
    {
        $query = News::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' =>6,
            ],
            'sort' => [
                'defaultOrder' => [
                    'create_time' => SORT_DESC,
                ]
            ],
        ]);
        if(Yii::$app->request->isAjax){
            return $this->renderPartial('list', ['provider'=>$provider]);
        }
         return $this->render('index',['provider'=>$provider,'count'=>$query->count()]);
    }

    public function actionContent(){
       $id = Yii::$app->request->get('id');
       $model  = News::findOne($id)->toArray();
       $model['create_time']  = date('m-d',$model['create_time']);
       echo json_encode($model);
    }
}
