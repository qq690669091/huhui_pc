<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hl_news".
 *
 * @property integer $news_id
 * @property string $title
 * @property integer $content
 * @property string $cover
 * @property integer $type
 * @property string $create_time
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hl_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'type', 'create_time'], 'integer'],
            [['title', 'cover'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'news_id' => '公告id',
            'title' => '公告标题',
            'content' => '公告内容',
            'cover' => '头像',
            'type' => '1为新闻,2为帮助',
            'create_time' => '发布时间',
        ];
    }
}
