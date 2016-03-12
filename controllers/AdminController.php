<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\CommonController;
use app\Models\Admin;
use yii\data\ActiveDataProvider;
/**
 * @desc   管理员控制器
 * @author RZLIAO
 * @date   2016-1-12 
 */
class AdminController extends CommonController
{
	//权限手动添加
	public $permissions = [
			['name'=>'admin','desc'=>'管理员','child'=>[
				['name'=>'admin/index','desc'=>'管理员列表'],
				['name'=>'admin/safe','desc'=>'安全验证'],
			]],
			['name'=>'user','desc'=>'用户','child'=>[
				['name'=>'user/index','desc'=>'用户列表'],
				['name'=>'user/safe','desc'=>'安全验证'],
			]],
		];
	public function actionIndex() {
		
		$model = Admin::find();
		$provider = new ActiveDataProvider([
		    'query' => $model,
		    'pagination' => [
		        'pageSize' => 10,
		    ],
		    'sort' => [
		        'defaultOrder' => [
		            'create_time' => SORT_DESC,
		        ]
		    ],
		]);
		return $this->render('index',['provider' => $provider,'model'=>new Admin(),'permissions'=>$this->permissions]);
	}

	//修改或者新增用户
	public function actionEdit () {
		$auth = Yii::$app->authManager;
        $data = Yii::$app->request->post('Admin');

        if(is_numeric($data['admin_id']) && $data['admin_id']>0){
        	$user = Admin::findOne($data['admin_id']);
		    if (!$user) {
		        $result['status'] = 0;
		        $result['message'] = '未找到该记录';
		    } else {
		        $oldPassword = $user->password;
		    }
        }else{
        	$user = new Admin();
        }
        if ($user->load(Yii::$app->request->post())) {
        	if (!$user->isNewRecord && $user->password != '******') {
                $oldPassword = Yii::$app->security->generatePasswordHash($user->password);
            }
            if($user->isNewRecord){
            	if(Admin::findByUsername($user->username)){
            		$result['status']  = 0;
		        	$result['message'] = '此名字已存在';
            	}
            }else{
            	if($user->save()){
	        		if(isset($oldPassword)){
	                    //重置密码
	                    Admin::updateAll(['password'=>$oldPassword], 'admin_id=:id', [':id'=>$user->admin_id]);
	                }
	        		$pro = $auth->getRolesByUid($user->admin_id);  //原来的权限
	        		if(count($pro)>0){
	        			foreach($pro as $model){
				    		$oldPermissions[] = $model->name;
				   		}
	        		}else{
	        			$oldPermissions = [];
	        		}
				    $newPermissions = Yii::$app->request->post('Admin')['permissions'];   //新的权限
				    $jiaoji        = array_intersect($oldPermissions, $newPermissions);
				    //需要增加的权限
				    $newPermissions = array_diff($newPermissions, $jiaoji);
				    //需要删除的权限
				    $oldPermissions = array_diff($oldPermissions, $jiaoji);
				    foreach ($newPermissions as $new) {
				    	$role = $auth->createRole($new);
				    	$auth->assign($role, $user->admin_id);
				    }
				    foreach ($oldPermissions as $old) {
				    	$auth->revokeRole($old,$user->admin_id);
				    }
				    $result['status'] = 1;
	                $result['message'] = '保存成功';
	        	}
            }
        }
        $errors = $user->getFirstErrors();
        if ($errors) {
            $result['status'] = 0;
            $result['message'] = current($errors);
        }
        return $this->renderJson($result);
	}

	public function actionGetpermissions($id) {
        $result = array();
        $auth = \Yii::$app->authManager;
        $permissions = $auth->getRolesByUid($id);
        if ($permissions) {
            foreach ($permissions as $p) {
                $result[] = $p->name;
            }
        }
        return $this->renderJson($result);
    }
}