<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hl_message".
 *
 * @property integer $mess_id
 * @property integer $user_id
 * @property string $title
 * @property integer $target_id
 * @property string $content
 * @property string $img
 * @property integer $status
 * @property integer $type
 * @property string $create_time
 * @property string $error_type
 * @property string $other
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hl_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'target_id', 'status', 'type', 'create_time'], 'integer'],
            [['title', 'content', 'img'], 'string', 'max' => 255],
            [['error_type'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    
     public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'target_id']);
    }
    public function attributeLabels()
    {
        return [
            'mess_id' => 'Mess ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'target_id' => 'Target ID',
            'content' => 'Content',
            'img' => 'Img',
            'status' => 'Status',
            'type' => 'Type',
            'create_time' => 'Create Time',
            'error_type' => 'Error Type',
            'other' => 'Other',
        ];
    }
}
