<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hl_payhelp_rule".
 *
 * @property integer $prid
 * @property integer $mlutiple
 * @property integer $min_money
 * @property integer $max_money
 * @property integer $rate
 * @property integer $limit_days
 * @property integer $interest_days
 * @property integer $Help_money_month
 * @property integer $after_pay_days
 */
class PayhelpRule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hl_payhelp_rule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mlutiple', 'min_money', 'max_money', 'rate', 'limit_days', 'interest_days', 'Help_money_month', 'after_pay_days'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prid' => 'Prid',
            'mlutiple' => 'Mlutiple',
            'min_money' => 'Min Money',
            'max_money' => 'Max Money',
            'rate' => 'Rate',
            'limit_days' => 'Limit Days',
            'interest_days' => 'Interest Days',
            'Help_money_month' => 'Help Money Month',
            'after_pay_days' => 'After Pay Days',
        ];
    }
}
