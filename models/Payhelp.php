<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hl_payhelp".
 *
 * @property integer $pay_id
 * @property integer $user_id
 * @property integer $money
 * @property string $match_time
 * @property string $create_time
 * @property integer $status
 */
class Payhelp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hl_payhelp';
    }

      public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'money', 'match_time','create_time','is_tx', 'accrual','status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pay_id' => 'Pay ID',
            'user_id' => 'User ID',
            'money' => 'Money',
            'match_time' => 'Match Time',
            'create_time' => 'Create Time',
            'status' => 'Status',
        ];
    }
}
