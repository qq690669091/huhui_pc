<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hl_money_log".
 *
 * @property string $log_id
 * @property string $user_id
 * @property string $desc
 * @property string $old_money
 * @property string $new_money
 * @property string $handle
 * @property integer $create_time
 */
class MoneyLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hl_money_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'desc'], 'required'],
            [['user_id', 'old_money', 'new_money', 'create_time'], 'integer'],
            [['desc'], 'string', 'max' => 100],
            [['handle'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'user_id' => 'User ID',
            'desc' => 'Desc',
            'old_money' => 'Old Money',
            'new_money' => 'New Money',
            'handle' => 'Handle',
            'create_time' => 'Create Time',
        ];
    }
}
