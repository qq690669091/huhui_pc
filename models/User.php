<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hl_user".
 *
 * @property string $user_id
 * @property string $nickname
 * @property string $account
 * @property string $pwd_log
 * @property string $pwd_tra
 * @property string $weixin
 * @property string $alipay
 * @property string $bank
 * @property string $phone
 * @property integer $logNum
 * @property integer $last_log
 * @property integer $status
 * @property integer $reg_ip
 * @property string $create_time
 * @property integer $is_active
 * @property integer $fixation_money
 * @property integer $money_manager
 * @property integer $money_rec
 * @property integer $level_id
 * @property string $wdk_count
 * @property integer $flow_money
 * @property integer $flow_money_manager
 * @property integer $flow_money_rec
 * @property string $headicon
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hl_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account', 'pwd_log', 'pwd_tra', 'phone'], 'required'],
            [['phone', 'reg_ip','status'], 'string'],
            [['last_log', 'create_time', 'is_active', 'fixation_money', 'money_manager', 'money_rec', 'level_id', 'wdk_count', 'flow_money', 'flow_money_manager', 'flow_money_rec','ip_id'], 'integer'],
            [['nickname'], 'string', 'max' => 32],
            [['account', 'pwd_log', 'pwd_tra', 'weixin', 'alipay', 'headicon'], 'string', 'max' => 255]
        ];
    }
    public function getLevel()
    {
        return $this->hasOne(Level::className(), ['level_id' => 'level_id']);
    }
       public function getParent()
    {
        return $this->hasOne(UserRelation::className(), ['user_id' => 'user_id']);
    }

    /**
     * @author RZLIAO
     * @date  2016-2-17
     */
    public function beforeSave( $insert ){
        if( parent::beforeSave( $insert ) ){
            if ($this->isNewRecord) {
                if( Ip::updateAllCounters(['count' => 1], ['name' => $_SERVER["REMOTE_ADDR"]]) ){
                    $this->ip_id = Ip::findByName($_SERVER["REMOTE_ADDR"])->id;
               }else{
                   $model = new Ip();
                   $model->save();
                   $this->ip_id = $model->id;
               }
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'nickname' => 'Nickname',
            'account' => 'Account',
            'pwd_log' => 'Pwd Log',
            'pwd_tra' => 'Pwd Tra',
            'weixin' => 'Weixin',
            'alipay' => 'Alipay',
            'bank' => 'Bank',
            'phone' => 'Phone',
            'last_log' => 'Last Log',
            'status' => 'Status',
            'reg_ip' => 'Reg Ip',
            'create_time' => 'Create Time',
            'is_active' => 'Is Active',
            'fixation_money' => 'Fixation Money',
            'money_manager' => 'Money Manager',
            'money_rec' => 'Money Rec',
            'level_id' => 'Level ID',
            'wdk_count' => 'Wdk Count',
            'flow_money' => 'Flow Money',
            'flow_money_manager' => 'Flow Money Manager',
            'flow_money_rec' => 'Flow Money Rec',
            'headicon' => 'Headicon',
            'ip_id'    => 'IpId',
        ];
    }

    public function getInfo($user_id){
        $query = $this->find();

        $query->select("*,l.name as l_name");

        $query->andFilterWhere(['user_id'=>$user_id]);

        $query->leftJoin(['l'=>'hl_level'],'l.level_id = hl_user.level_id');


        $res = $query->asArray()->one();

        return $res;
    }
}
