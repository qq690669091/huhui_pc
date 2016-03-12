<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hl_gethelp".
 *
 * @property integer $get_id
 * @property integer $user_id
 * @property integer $money
 * @property integer $match_time
 * @property integer $create_time
 * @property integer $status
 * @property string $type
 */
class Gethelp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hl_gethelp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'money', 'match_time', 'create_time', 'status', 'type'], 'integer']
        ];
    }

      public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'get_id' => 'Get ID',
            'user_id' => 'User ID',
            'money' => 'Money',
            'match_time' => 'Match Time',
            'create_time' => 'Create Time',
            'status' => 'Status',
            'type' => 'Type',
        ];
    }
}
