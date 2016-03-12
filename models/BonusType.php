<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hl_bonus_type".
 *
 * @property integer $bonus_type_id
 * @property integer $tx_days
 * @property integer $money
 * @property integer $exceed_money
 */
class BonusType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hl_bonus_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tx_days', 'money', 'exceed_money'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bonus_type_id' => 'Bonus Type ID',
            'tx_days' => 'Tx Days',
            'money' => 'Money',
            'exceed_money' => 'Exceed Money',
        ];
    }
}
