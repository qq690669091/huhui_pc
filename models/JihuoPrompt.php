<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hl_jihuo_prompt".
 *
 * @property integer $id
 * @property string $content
 * @property integer $get_time
 * @property integer $pay_time
 * @property integer $limt_time
 */
class JihuoPrompt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hl_jihuo_prompt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['get_time', 'pay_time', 'limt_time'], 'float'],
            [['content'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'get_time' => 'Get Time',
            'pay_time' => 'Pay Time',
            'limt_time' => 'Limt Time',
        ];
    }
}
