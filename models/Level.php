<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hl_level".
 *
 * @property string $level_id
 * @property string $name
 * @property string $tz_money
 * @property string $recommend
 * @property integer $moneylog_id
 * @property integer $bonus_type
 * @property integer $next_money_less
 * @property integer $month_money_less
 */
class Level extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hl_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level_id'], 'required'],
            [['level_id', 'tz_money', 'recommend', 'moneylog_id', 'bonus_type', 'next_money_less', 'month_money_less'], 'integer'],
            [['name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'level_id' => 'Level ID',
            'name' => 'Name',
            'tz_money' => 'Tz Money',
            'recommend' => 'Recommend',
            'moneylog_id' => 'Moneylog ID',
            'bonus_type' => 'Bonus Type',
            'next_money_less' => 'Next Money Less',
            'month_money_less' => 'Month Money Less',
        ];
    }


    /**
     * @return array 返回等级
     */
    public function getLevels(){
        $query = $this->find();

        $query->select("*");

        $res = $query->asArray()->all();

        return $res;
    }
}
