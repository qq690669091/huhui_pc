<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hl_orders".
 *
 * @property integer $mate_id
 * @property string $pay_id
 * @property string $get_id
 * @property integer $money
 * @property integer $create_time
 * @property integer $need_time
 * @property integer $status
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hl_orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_id', 'get_id', 'money', 'create_time', 'need_time', 'status'], 'integer']
        ];
    }
     public function getPayhelp()
    {
        return $this->hasOne(Payhelp::className(), ['pay_id' => 'pay_id']);
    }

     public function getGethelp()
    {
        return $this->hasOne(Gethelp::className(), ['get_id' => 'get_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mate_id' => 'Mate ID',
            'pay_id' => 'Pay ID',
            'get_id' => 'Get ID',
            'money' => 'Money',
            'create_time' => 'Create Time',
            'need_time' => 'Need Time',
            'status' => 'Status',
        ];
    }

}
