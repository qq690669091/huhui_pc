<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hl_gethelp_rule".
 *
 * @property string $grid
 * @property integer $mlutiple
 * @property integer $min_money
 * @property integer $max_money
 * @property integer $Help_money_month
 * @property integer $after_recive_days
 */
class GethelpRule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hl_gethelp_rule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grid'], 'required'],
            [['grid', 'mlutiple', 'min_money', 'max_money', 'Help_money_month', 'after_recive_days'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'grid' => 'Grid',
            'mlutiple' => 'Mlutiple',
            'min_money' => 'Min Money',
            'max_money' => 'Max Money',
            'Help_money_month' => 'Help Money Month',
            'after_recive_days' => 'After Recive Days',
        ];
    }
}
